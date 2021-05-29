<?php 
require 'vendor/autoload.php';
session_start();
session_unset();
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUITS_DB?retryWrites=true&w=majority');
$db = $client->PRODUITS_DB;
$collection = $client->$db->PRODUITS;
$filters = [];
$options = [];
if(isset($_POST['rapide'])){
	//if(isset($_POST['search_name'])){
	$_SESSION['search_name'] = $_POST['search_name'];
	//}
	$search_value = $_SESSION['search_name'];
	$regex = new MongoDB\BSON\Regex($search_value, 'i');
	$filters += ["product_name"=>$regex];
}

elseif (isset($_POST['submit_avancee'])) {
	if(isset($_POST['search_name'])){
		$search_value = $_POST['search_name'];
		$regex = new MongoDB\BSON\Regex($search_value, 'i');
		$filters += ["product_name"=>$regex];
		$_SESSION['search_name'] = $_POST['search_name'];
	}
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
		$_SESSION['calories'] = $_POST['calories'];
		$_SESSION['calories_num'] = $_POST['calories_num'];
		//il faut ajouter tous les $_POST comme valeurs de session pour pouvoir les passer aux autres pages
    }

	if(isset($_POST['nutriscore'])) {
        if($_POST['nutriscore'] != "tt") {
            $filters += ['nutriscore_grade' =>$_POST['nutriscore']];
        }
		$_SESSION['nutriscore'] = $_POST['nutriscore'];
	
    }
	if(isset($_POST['ecoscore'])) {
        if($_POST['ecoscore'] != "tt") {
            $filters += ['ecoscore_grade_fr' =>$_POST['ecoscore']];
		}
		$_SESSION['ecoscore'] = $_POST['ecoscore'];
	
    }

	if(isset($_POST['search_marque'])) {
        if($_POST['search_marque'] != " ") {
			$search_value = $_POST['search_marque'];
			$regex = new MongoDB\BSON\Regex($search_value, 'i');
			$filters += ["brands"=>$regex];
        }
		$_SESSION['search_marque'] = $_POST['search_marque'];
	
    }
	if(isset($_POST['search_label'])) {
        if($_POST['search_label'] != " ") {
			$search_value = $_POST['search_label'];
			$regex = new MongoDB\BSON\Regex($search_value, 'i');
			$filters += ["labels"=>$regex];
        }
		$_SESSION['search_label'] = $_POST['search_label'];
	
    }
	if(isset($_POST['ingredient'])) {
        if($_POST['ingredient'] != " ") {
			$search_value = $_POST['ingredient'];
			if($_POST['ingredient_choix']=="oui"){
				$regex = new MongoDB\BSON\Regex($search_value, 'i');
			}
			elseif ($_POST['ingredient_choix']=="non") {
				$regex = new MongoDB\BSON\Regex('^(?!'.$search_value.'.)*$', 'i');
            }
			$filters += ["ingredients_text"=>$regex];
        }
		$_SESSION['ingredient'] = $_POST['ingredient'];
		$_SESSION['ingredient_choix'] = $_POST['ingredient_choix'];
    }

    if(isset($_POST['allergenes']) && !empty($_POST['allergenes'])){
        foreach($_POST['allergenes'] as $allergene) {
            $regex = new MongoDB\BSON\Regex('^(?!' . $allergene . '.)*$', 'i');
            $filters += ["allergens" => $regex];
        }
        $_SESSION['allergenes'] = $_POST['allergenes'];

    }

    if(isset($_POST['produits_populaires'])){
        $filters += ['nb_vues' => ['$gte' => 1]];
        $_SESSION['produits_populaires'] = $_POST['produits_populaires'];
    }

	if(isset($_POST['nutriment'])) {
        if($_POST['nutriment_choix'] != " ") {
			$option_value = $_POST['nutriment'];
			if($_POST['nutriment_choix'] == "egal") {
				$filters += [$option_value => ['$eq' => $_POST['nutriment_num']]];
			}
			elseif ($_POST['nutriment_choix'] == "sup"){
				$filters += [$option_value => ['$gte' => $_POST['nutriment_num']]];
			}
			elseif($_POST['nutriment_choix'] == "inf") {
				$filters += [$option_value => ['$lte' => $_POST['nutriment_num']]];
			}
        }
		$_SESSION['nutriment'] = $_POST['nutriment'];
		$_SESSION['nutriment_choix'] = $_POST['nutriment_choix'];
		$_SESSION['nutriment_num'] = $_POST['nutriment_num'];
    }
}

$cursor=$collection->find($filters,$options);
$i=0;
foreach($cursor as $document){
	$i=$i+1;
}
if ($i>1) {
	header('Location: liste_produits.php');
}
elseif ($i==1) {
	//echo '<pre>'; print_r(array("product_name" => $regex)); echo '</pre>';
	header('Location: fiche_produit.php');
	$_SESSION['code'] = $document['code'];
}
elseif ($i==0) {
	header('Location: produit_404.php');
}

?>