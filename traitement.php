<?php 
require 'vendor/autoload.php';
session_start();
if(isset($_POST['search_name'])){
    $_SESSION['search_name'] = $_POST['search_name'];
}
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUITS_DB?retryWrites=true&w=majority');
$db = $client->PRODUITS_DB;
$collection = $client->$db->PRODUITS;
$search_value = $_SESSION["search_name"];
$regex = new MongoDB\BSON\Regex($search_value, 'i');
$cursor=$collection->find( array("product_name" => $regex));
$i=0;
foreach($cursor as $document){
	$i=$i+1;
}
if (isset($_POST['rapide'])) {
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
}

?>