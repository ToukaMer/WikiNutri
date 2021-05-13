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
    $additifs=$document['additives_en'];
    $ecoscore=$document['ecoscore_score_fr'];
    $ecoscore_g=$document['ecoscore_grade_fr'];
    $energie=$document['energy_100g'];
    $gras=$document['fat_100g'];
    $acides=$document['saturated-fat_100g'];
    $glucides=$document['carbohydrates_100g'];
    $sucres=$document['sugars_100g'];
    $fibres=$document['fiber_100g'];
    $proteines=$document['proteins_100g'];
    $sel=$document['salt_100g'];
    $alcool=$document['alcohol_100g'];
    $calcium=$document['calcium_100g'];
    $vitamine_b6=$document['vitamin-b6_100g'];
    $vitamine_b12=$document['vitamin-b12_100g'];
    $vitamine_b1=$document['vitamin-b1_100g'];
    $vitamine_b9=$document['vitamin-b9_100g'];
    $vitamine_b2=$document['vitamin-b2_100g'];
    $amidons=$document['starch_100g'];
    $fer=$document['iron_100g'];
    $carbon_footprint=$document['carbon-footprint_100g'];
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
                <form method="post" action="traitement.php">
                    <p><input type="search" id="site-search" name="search_name" placeholder="Insérer le nom de l'aliment"></p>
                    <p>
                        <button type="submit" name="rapide">Recherche rapide</button>
                        <button type="submit" name="avancee">Recherche avancée</button>
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
                            <li><p>Additifs : <?php echo $additifs ?></p></li>
                            <li><p>Éco score : <?php echo $ecoscore ?></p></li>
                            <li><p>Éco grade : <?php echo $ecoscore_g ?></p></li>
                            <li><p>Portion : <?php echo $portion ?></p></li>
                            <li><p>Tableau des apports nutritionnels :</p></li>
                            <li>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nutriments</th>
                                            <th>Dans 100g/100ml</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Energie</td>
                                            <td><?php echo $energie ?></td>
                                        </tr>
                                        <tr>
                                            <td>Matières grasses</td>
                                            <td><?php echo $gras ?></td>
                                        </tr>
                                        <tr>
                                            <td>Acides gras saturés</td>
                                            <td><?php echo $acides ?></td>
                                        </tr>
                                        <tr>
                                            <td>Glucides</td>
                                            <td><?php echo $glucides ?></td>
                                        </tr>
                                        <tr>
                                            <td>Sucres</td>
                                            <td><?php echo $sucres ?></td>
                                        </tr>
                                        <tr>
                                            <td>Fibres alimentaires</td>
                                            <td><?php echo $fibres ?></td>
                                        </tr>
                                        <tr>
                                            <td>Protéines</td>
                                            <td><?php echo $proteines ?></td>
                                        </tr>
                                        <tr>
                                            <td>Sel</td>
                                            <td><?php echo $sel ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alcool</td>
                                            <td><?php echo $alcool ?></td>
                                        </tr>
                                        <tr>
                                            <td>Calcium</td>
                                            <td><?php echo $calcium ?></td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b6-pyridoxine</td>
                                            <td><?php echo $vitamine_b6 ?></td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b12-cobalamine</td>
                                            <td><?php echo $vitamine_b12 ?></td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b1-thiamine</td>
                                            <td><?php echo $vitamine_b1 ?></td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b9-acide-folique</td>
                                            <td><?php echo $vitamine_b9 ?></td>
                                        </tr>
                                        <tr>
                                            <td>Vitamine-b2-riboflavine</td>
                                            <td><?php echo $vitamine_b2 ?></td>
                                        </tr>
                                        <tr>
                                            <td>Amidons</td>
                                            <td><?php echo $amidons ?></td>
                                        </tr>
                                        <tr>
                                            <td>Fer</td>
                                            <td><?php echo $fer ?></td>
                                        </tr>
                                        <tr>
                                            <td>Empreinte de carbon</td>
                                            <td><?php echo $carbon_footprint ?></td>
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
