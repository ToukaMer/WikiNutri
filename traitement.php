<?php 
require 'vendor/autoload.php';
session_start();
$_SESSION["search_name"] = $_POST['search_name'];
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUITS_DB?retryWrites=true&w=majority');
$db = $client->PRODUITS_DB;
$collection = $client->$db->PRODUITS;
$cursor=$collection->find( array( "product_name" => $_POST['search_name']));
$i=0;
foreach($cursor as $document) {
//    print_r($document);
	$i=$i+1;
}
if (isset($_POST['avancee'])) {
	header('Location: recherche_avancee.html');
}
else {
	if ($i>1) {
		header('Location: liste_produits.html');
	}
	elseif ($i==1) {
		header('Location: fiche_produit.php');
	}
	elseif ($i==0) {
		header('Location: produit_404.html');
	}
}
?>