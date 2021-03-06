<?php 
require 'vendor/autoload.php';
session_start();
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUCTS_DB?retryWrites=true&w=majority');
$db = $client->PRODUCTS_DB;
$collection = $client->$db->PRODUCTS;
$filters = [];
$options = ['sort' => ['code' => 1]];
$i=0;
if(isset($_GET['marque'])){

    $marque_id=$_GET['marque'];
    $regex = new MongoDB\BSON\Regex($marque_id, 'i');
    $filters += ["brands"=>$regex];
    //$cursor=$collection->find($filters,$options);
}

elseif(isset($_GET['categorie'])){

    $categorie_id=$_GET['categorie'];
    $regex = new MongoDB\BSON\Regex($categorie_id, 'i');
    $filters += ["categories"=>$regex];
    //$cursor=$collection->find($filters,$options);
}

 elseif(isset($_GET['label'])){

    $label_id=$_GET['label'];
    $regex = new MongoDB\BSON\Regex($label_id, 'i');
    $filters += ["labels"=>$regex];
    //$cursor=$collection->find($filters,$options);
}

 elseif(isset($_GET['nutriscore'])){

    $nutriscore_id=$_GET['nutriscore'];
    $filters += ["nutriscore_grade"=>$nutriscore_id];
    //$cursor=$collection->find($filters,$options);
}

 elseif(isset($_GET['ingredient'])){

    $ingredient_id=$_GET['ingredient'];
    $regex = new MongoDB\BSON\Regex($ingredient_id, 'i');
    $filters += ["ingredients_text"=>$regex];
    //$cursor=$collection->find($filters,$options);
}

 elseif(isset($_GET['allergene'])){

    $allergene_id=$_GET['allergene'];
    $regex = new MongoDB\BSON\Regex($allergene_id, 'i');
    $filters += ["allergens"=>$regex];
    //$cursor=$collection->find($filters,$options);
}

else{
    if(isset($_SESSION['search_name'])){
        $search_value = $_SESSION['search_name'];
        $regex = new MongoDB\BSON\Regex($search_value, 'i');
        $filters += ["product_name"=>$regex];
    }
    //$filters += ['energy-kcal_100g' => ['$lte' => '2500']];
    //echo $search_value;
    //echo $_SESSION['calories_num'];
    //echo $_SESSION['search_name'];
    if(isset($_SESSION['calories_num'])) {
        if($_SESSION['calories'] == "egal") {
            $filters += ['energy-kcal_100g' => ['$eq' => $_SESSION['calories_num']]];
        }
        elseif ($_SESSION['calories'] == "sup"){
            $filters += ['energy-kcal_100g' => ['$gte' => $_SESSION['calories_num']]];
        }
        elseif($_SESSION['calories'] == "inf") {
            $filters += ['energy-kcal_100g' => ['$lte' => $_SESSION['calories_num']]];
        }

    }
    if(isset($_SESSION['nutriscore'])) {
        if($_SESSION['nutriscore'] != "tt") {
            $filters += ['nutriscore_grade' =>$_SESSION['nutriscore']];
        }
	
    }
    if(isset($_SESSION['ecoscore'])) {
        if($_SESSION['ecoscore'] != "tt") {
            $filters += ['ecoscore_grade_fr' =>$_SESSION['ecoscore']];
        }
	
    }
    if(isset($_SESSION['search_marque'])) {
        if($_SESSION['search_marque'] != " ") {
			$search_value = $_SESSION['search_marque'];
			$regex = new MongoDB\BSON\Regex($search_value, 'i');
			$filters += ["brands"=>$regex];
        }
	
    }
    if(isset($_SESSION['search_label'])) {
        if($_SESSION['search_label'] != " ") {
			$search_value = $_SESSION['search_label'];
			$regex = new MongoDB\BSON\Regex($search_value, 'i');
			$filters += ["labels"=>$regex];
        }
	
    }
    if(isset($_SESSION['ingredient'])) {
        if($_SESSION['ingredient'] != "") {
			$search_value = $_SESSION['ingredient'];
			if($_SESSION['ingredient_choix']=="oui"){
				$regex = new MongoDB\BSON\Regex($search_value, 'i');
				$filters += ["ingredients_text"=>$regex];
			}
			elseif ($_SESSION['ingredient_choix']=="non") {
				$regex = new MongoDB\BSON\Regex($search_value, 'i');
                $filters += ["ingredients_text" => ['$not' => $regex]];
            }
        }
    }
    if(isset($_SESSION['produits_populaires'])){
        $filters += ['nb_vues' => ['$gte' => 1]];
        $options = ['sort' => ['nb_vues' => -1]];
    }

    if(isset($_SESSION['allergenes']) && !empty($_SESSION['allergenes'])){
        foreach($_SESSION['allergenes'] as $allergene) {
            $regex = new MongoDB\BSON\Regex($allergene , 'i');
            $filters += ['$or' => [["allergens" => ['$not' => $regex]],['ingredients_text' => ['$not' => $regex]]]];
        }
    }

    if(isset($_SESSION['categorie'])){
        $categorie = $_SESSION['categorie'];
        $regex = new MongoDB\BSON\Regex($categorie, 'i');
        $filters += ["categories"=>$regex];
    }

    if(isset($_SESSION['nutriment'])) {
        if($_SESSION['nutriment_choix'] != " ") {
			$option_value = $_SESSION['nutriment'];
			if($_SESSION['nutriment_choix'] == "egal") {
				$filters += [$option_value => ['$eq' => $_SESSION['nutriment_num']]];
			}
			elseif ($_SESSION['nutriment_choix'] == "sup"){
				$filters += [$option_value => ['$gte' => $_SESSION['nutriment_num']]];
			}
			elseif($_SESSION['nutriment_choix'] == "inf") {
				$filters += [$option_value => ['$lte' => $_SESSION['nutriment_num']]];
			}
        }
    }


}

$cursor=$collection->find($filters,$options);

//echo '<pre>'; print_r($filters); echo '</pre>';

?>
<!DOCTYPE html>

<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="jsfunctions.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste Produits</title>
</head>
<body>

    <div class="grid-container">
        <div class="header">
            <h1>WikiNutri.</h1>
        </div>
  
        <div class="left"> </div>
        
        <div class="middle">
            <div class="row">
                <h2>Voici le r??sultat de votre recherche &#128525;</h2>
                <h3>Choisissez deux produit en cochant les checkboxes correspondants pour les comparer</h3>
                <div class="product_list">
                    <form method="post" action="comparaison_produits.php">
                    <button type="submit" id ="comparer" name="comparer" disabled>Comparer</button>
                    <div class="checkboxes">
                    <ul id="datalist">
                    <?php
                    foreach($cursor as $document) {
                        $name=$document['product_name'];
                        $image=$document['image_url'];
                        $code=$document['code'];
                        echo "<li><figure><a href='fiche_produit.php?product=$code'><img src='$image' alt='$name' width='200' height='200'><figcaption>$name</figcaption></a><input type='checkbox' id='compare' name='compare[]' value=$code autocomplete='off' onClick='ckChange(this)'></figure></li>";
	                    $i=$i+1;
                    }
                    ?>
                    </ul>
                    </div>
                    </form>
                    <span>Afficher Plus</span>
                </div>
            </div>
            <div class="row">
                <h2>Lancez une autre recherche</h2>
                <form method="post" action="traitement.php">
                    <p><input type="search" id="site-search" name="search_name" placeholder="Ins??rer le nom de l'aliment" required></p>
                    <p>
                        <button type="submit" name="rapide">Recherche rapide</button>
                    </p>
                </form>
            </div>
            
        </div>  
        
        <div class="right"></div>
  
        <div class="footer">
            <footer>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="index.html">Accueil</a></li>
                    <li class="list-inline-item"><a href="#">Terms</a></li>
                    <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="#">Nous Contacter</a></li>
                </ul>
                <p class="copyright">WikiNutri. ?? 2021</p>
            </footer>
        </div>
    </div>
    <script>
        var j = 0;
        $(function () {
            $('span').click(function () {
                $('#datalist li:hidden').slice(0, 8).show();
                if ($('#datalist li').length == $('#datalist li:visible').length) {
                    $('span ').hide();
                }
            });
        });
        function ckChange(el) {
            var ckName = document.getElementsByName(el.name);
            var i;
            if(el.checked === true){
                j = j+1;
            }
            if(el.checked === false){
                j = j-1;
                for (i = 0; i< ckName.length; i++) {
                    ckName[i].disabled = false;
                }
            }
            if(j === 2){
                for (i = 0; i< ckName.length; i++) {
                if(ckName[i].checked === false)
                    ckName[i].disabled = true;
                    document.getElementById("comparer").disabled = false;
                }
            }
            if(j !== 2){
                document.getElementById("comparer").disabled = true;
            }
        }
    </script>
</body>
</html>