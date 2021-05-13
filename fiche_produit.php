<?php
require 'vendor/autoload.php';
session_start();
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUITS_DB?retryWrites=true&w=majority');
$db = $client->PRODUITS_DB;
$collection = $client->$db->PRODUITS;
$cursor=$collection->find( array( "product_name" => $_SESSION['search_name']));
foreach($cursor as $document) {
    $name=$document['product_name'];
    $image=$document['image_url'];
    $nutriscore=$document['nutriscore_score'];
    $novascore=$document['nova_group'];
    $poids=$document['quantity'];
    $emballage=$document['packaging'];
    $marque=$document['brands'];
    $categories=$document['categories'];
    $labels=$document['labels'];
    $ingredients=$document['ingredients_text'];
    $allergenes=$document['allergens'];
    $traces=$document['traces'];
    $portion=$document['serving_quantity'];
}
?>
<!DOCTYPE html>

<html lang="fr" xmlns="http://www.w3.org/1999/xhtml%22%3E">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Fiche produit</title>
</head>
<body>
    <div class="grid-container">
        <div class="header">
            <h1>WikiNutri.</h1>
        </div>

        <div class="left"> </div>

        <div class="middle">
            <div class="row">
                <h2>Lancez une autre recherche</h2>
                <form>
                    <p><input type="search" id="site-search" name="q" placeholder="Insérer le nom de l'aliment"></p>
                    <p>
                        <button type="button">Recherche avancée</button>
                        <button type="button">Recherche rapide</button>
                    </p>
                </form>
            </div>
            <div class="row">
                <h2>Voici le résultat de votre recherche &#128525;</h2>
                <div class="column1">
                    <figure>
                        <img src="<?php echo $image ?>" alt="<?php echo $name ?>" width="250" height="250">
                        <figcaption><?php echo $name ?></figcaption>
                    </figure>
                </div>
                <div class="column2">
                    <div class="product_info">
                        <ul>
                            <li><p>Nutri Score : <?php echo $nutriscore ?></p></li>
                            <li><p>Nova Score : <?php echo $novascore ?></p></li>
                            <li><p>Poids Net : <?php echo $poids ?></p></li>
                            <li><p>Emballage : <?php echo $emballage ?></p></li>
                            <li><p>Marques : <?php echo $marque ?></p></li>
                            <li><p>Catégories : <?php echo $categories ?></p></li>
                            <li><p>Labels : <?php echo $labels ?></p></li>
                            <li><p>Liste des ingrédients : <?php echo $ingredients ?></p></li>
                            <li><p>Liste des allergènes : <?php echo $allergenes ?></p></li>
                            <li><p>Contient des traces de : <?php echo $traces ?></p></li>
                            <li><p>Portion : <?php echo $portion ?></p></li>
                            <li><p>Tableau des apports nutritionnels :</p></li>
                            <li>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nutriments</th>
                                            <th>Dans 100g/100ml</th>
                                            <th>Par portion (30g)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Energie</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Matières grasses</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Acides gras saturés</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Glucides</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Sucres</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Fibres alimentaires</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Protéines</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Sel</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Alcool</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Calcium</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b6-pyridoxine</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b12-cobalamine</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b1-thiamine</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b9-acide-folique</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b3-vitamine-pp-niacine</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b2-riboflavine</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Amidons</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                        <tr>
                                            <td>Fer</td>
                                            <td>?</td>
                                            <td>?</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="right">
            <h3>Suggestion d'autres produits similaires</h3>
            <div class="column_list">
                <ul>
                    <li>
                        <figure>
                            <img src="images/tresor_cacahuete.jpg" alt="tresor_cacahuete">
                            <figcaption>Kellogs Trésor</figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="images/tresor_cacahuete.jpg" alt="tresor_cacahuete">
                            <figcaption>Kellogs Trésor</figcaption>
                        </figure>
                    </li>
                </ul>
            </div>
        </div>
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