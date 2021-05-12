<?php 
require 'vendor/autoload.php';
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUITS_DB?retryWrites=true&w=majority');
$db = $client->PRODUITS_DB;
$collection = $client->$db->PRODUITS;
$cursor=$collection->find( array( "product_name" => "Brownies"));
foreach($cursor as $document) {
    print_r($document);
}
?>
<!DOCTYPE html>

<html lang="fr" xmlns="http://www.w3.org/1999/xhtml%22%3E">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>
<body>
    <div class="grid-container">
        <div class="header">
            <h1>WikiNutri.</h1>
        </div>
  
        <div class="left"> </div>
        
        <div class="middle">
            <div class="row">
                <h2>Vous avez envie de connaître tout sur les produits alimentaires que vous consommez ? &#127851;</h2>
                <h2>Vous souhaitez trouver des produits qui ne contiennent pas certains allèrgenes ? &#127838;</h2>
            </div>
            <div class="row">
                <h3>Lancer une recherche rapide avec le nom du produits souhaité &#128523;</h3>
                <h3>Ou cliquer sur recherche avancée pour choisir vos préférences &#128064;</h3>
                <form>
                    <p><input type="search" id="site-search" name="q" placeholder="Insérer le nom de l'aliment"></p>
                    <p><button type="button">Recherche avancée</button>
                    <button type="button">Recherche rapide</button></p>
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