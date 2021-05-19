<?php 
require 'vendor/autoload.php';
session_start();
$_SESSION['search_val'] = $_POST['search_name'];
$search_value = $_SESSION['search_val'];
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUITS_DB?retryWrites=true&w=majority');
$db = $client->PRODUITS_DB;
$collection = $client->$db->PRODUITS;
$filters = [];
$options = [];
$regex = new MongoDB\BSON\Regex($search_value, 'i');
$filters += ["product_name"=>$regex];
//$filters += ['energy-kcal_100g' => ['$lte' => '2500']];


//echo $search_value;
//echo $_POST['calories_num'];
//echo $_POST['search_name'];


if(isset($_POST['calories_num'])) {
    if($_POST['calories'] == "egal") {
        $filters += ['energy-kcal_100g' => ['$eq' => $_POST['calories_num']]];
    }
    elseif ($_POST['calories'] == "sup"){
        $filters += ['energy-kcal_100g' => ['$gte' => $_POST['calories_num']]];
    }
    elseif($_POST['calories'] == "inf") {
        $filters += ['energy-kcal_100g' => ['$lte' => $_POST['calories_num']]];
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
                <h2>Voici le résultat de votre recherche &#128525;</h2>
                <div class="product_list">
                    <?php
                    foreach($cursor as $document) {
                        $name=$document['product_name'];
                        $image=$document['image_url'];
                        $code=$document['code'];
                        echo "<a href='fiche_produit.php?product=$code'><figure> <img src='$image' alt='$name' width='200' height='200'> <figcaption>$name</figcaption> </figure></a>";
	                }
                    ?>
                </div>
            </div>
            <div class="row">
                <h2>Lancez une autre recherche</h2>
                <form method="post" action="traitement.php">
                    <p><input type="search" id="site-search" name="search_name" placeholder="Insérer le nom de l'aliment"></p>
                    <p>
                        <button type="submit" name="rapide">Recherche rapide</button>
                        <button type="submit" name="avancee">Recherche avancée</button>
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
                <p class="copyright">WikiNutri. © 2021</p>
            </footer>
        </div>
    </div>
</body>
</html>