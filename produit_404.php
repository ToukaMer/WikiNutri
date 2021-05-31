<?php
require 'vendor/autoload.php';
session_start();
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUCTS_DB?retryWrites=true&w=majority');
$db = $client->PRODUCTS_DB;
$collection = $client->$db->PRODUCTS;
$filters = [];
$options = [];

$filters += ['nb_vues' => ['$gte' => 1]];
$options = ['sort' => ['nb_vues' => -1]];

$cursor_suggestion=$collection->find($filters,$options);

?>

<!DOCTYPE html>

<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produit non trouvé</title>
</head>
<body>
    <div class="grid-container">
        <div class="header">
            <h1>WikiNutri.</h1>
        </div>
  
        <div class="left"> </div>
        
        <div class="middle">
            <div class="row">
                <h2>Oups ! Nous n'avons pas trouvé le produit que vous cherchez &#128531;</h2>
                <h3>Voici quelques suggestions ...</h3>
                <div class="product_list">
                <?php

                $count = 0;
                foreach($cursor_suggestion as $document)  {
                    $name=$document['product_name'];
                    $image=$document['image_url'];
                    $code=$document['code'];
                    if ($count < 3)
                            echo "<li><figure><a href='fiche_produit.php?product=$code'><img src='$image' alt='$name' width='400' height='250'><figcaption>$name</figcaption></a></figure></li>";
                    $count++;

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