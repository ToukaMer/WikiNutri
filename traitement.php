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
}
elseif ($i==0) {
	header('Location: produit_404.html');
}

?>