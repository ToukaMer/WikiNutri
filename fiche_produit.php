<?php
require 'vendor/autoload.php';
session_start();
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUITS_DB?retryWrites=true&w=majority');
$db = $client->PRODUITS_DB;
$collection = $client->$db->PRODUITS;
if(isset($_GET['product'])){
    $product_id=$_GET['product'];
    $document = $collection->findOne(['code' => intval($product_id)]);
    $updatedocument = $collection->findOneAndUpdate(['code' => intval($product_id)], [ '$inc' => [ 'nb_vues' => 1 ]]);
    $name=$document['product_name'];
    $image=$document['image_url'];
    $nutriscore=$document['nutriscore_grade'];
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
else{
    $product_id=$_SESSION['search_name'];
    $cursor=$collection->find( array("product_name" => $product_id));
    foreach($cursor as $document) {
        $name=$document['product_name'];
        $image=$document['image_url'];
        $nutriscore=$document['nutriscore_grade'];
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
}

function multipleexplode ($delimiters,$string) {
  $phase = str_replace($delimiters, $delimiters[0], $string);
  $processed = explode($delimiters[0], $phase);
  return  $processed;
}

   ?>
<!DOCTYPE html>

<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
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
                            <?php if(!empty($nutriscore)) {echo "<li><p><a href='liste_produits.php?nutriscore=$nutriscore'><img src='images/nutri_score_$nutriscore.png' alt='$nutriscore' width='140' height='90'></a><img src='images/nova-group-$novascore.svg' alt='$novascore' width='50' height='80'><img src='images/ecoscore-$ecoscore_g.svg' alt='$ecoscore_g' width='100' height='70'></p></li>";} ?>
                            <?php if(!empty($emballage)) {echo "<li><p>Emballage : "; echo $emballage; "</p></li>";} ?>
                            <?php if(!empty($poids)) {echo "<li><p>Poids Net : "; echo $poids; echo "</p></li>";} ?>
                            <?php if(!empty($portion)) {echo "<li><p>Portion : "; echo $portion; echo "</p></li>";} ?>
                            <?php if(!empty($marque)) {echo "<li><p>Marques : "; $marques=multipleexplode(array(",",".","|",":",")","("),$marque);foreach($marques as $mark){ echo "<a href='liste_produits.php?marque=$mark'>$mark</a>";} echo "</p></li>";} ?>
                            <?php if(!empty($categories)) {echo "<li><p>Catégories : "; $ncategories=multipleexplode(array(",",".","|",":",")","("),$categories);foreach($ncategories as $categ){ echo "<a href='liste_produits.php?categorie=$categ'>$categ</a>";} echo "</p></li>";} ?>
                            <?php if(!empty($labels)) {echo "<li><p>Labels : "; $nlabels=multipleexplode(array(",",".","|",":",")","("),$labels);foreach($nlabels as $lab){echo "<a href='liste_produits.php?label=$lab'>$lab</a>";} echo "</p></li>";} ?>
                            <?php if(!empty($ingredients)) {echo "<li><p>Liste des ingrédients : "; $ningredients=multipleexplode(array(",",".","|",":",")","("),$ingredients);foreach($ningredients as $ingred){echo "<a href='liste_produits.php?ingredient=$ingred'>$ingred</a>";} echo "</p></li>";} ?>
                            <?php if(!empty($allergenes)) {echo "<li><p>Liste des allergènes : "; $nallergenes = multipleexplode(array(",",".","|",":",")","("),$allergenes); foreach($nallergenes as $allerg){echo  "<a href='liste_produits.php?allergene=$allerg'>$allerg</a>";} echo "</p></li>";} ?>
                            <?php if(!empty($traces)) {echo "<li><p>Contient des traces de : "; echo $traces; echo "</p></li>";} ?>
                            <?php if(!empty($additifs)) {echo "<li><p>Additifs : "; echo $additifs; echo "</p></li>";} ?>
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
                                        <?php if(!empty($energie)) {echo "<tr>
                                            <td>Energie</td>
                                            <td>"; echo $energie; echo "</td>
                                        </tr>";}?>
                                        <?php if(!empty($gras)) {echo "<tr>
                                            <td>Matières grasses</td>
                                            <td>"; echo $gras; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($acides)) {echo "<tr>
                                            <td>Acides gras saturés</td>
                                            <td>"; echo $acides; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($glucides)) {echo "<tr>
                                            <td>Glucides</td>
                                            <td>"; echo $glucides; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($sucres)) {echo "<tr>
                                            <td>Sucres</td>
                                            <td>"; echo $sucres; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($fibres)) {echo "<tr>
                                            <td>Fibres alimentaires</td>
                                            <td>"; echo $fibres; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($proteines)) {echo "<tr>
                                            <td>Protéines</td>
                                            <td>"; echo $proteines; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($sel)) {echo "<tr>
                                            <td>Sel</td>
                                            <td>"; echo $sel; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($alcool)) {echo "<tr>
                                            <td>Alcool</td>
                                            <td>"; echo $alcool; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($calcium)) {echo "<tr>
                                            <td>Calcium</td>
                                            <td>"; echo $calcium; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($vitamine_b1)) {echo "<tr>
                                            <td>Vitamine-b1-thiamine</td>
                                            <td>"; echo $vitamine_b1; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($vitamine_b2)) {echo "<tr>
                                            <td>Vitamine-b2-riboflavine</td>
                                            <td>"; echo $vitamine_b2; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($vitamine_b6)) {echo "<tr>
                                            <td>Vitamine-b6-pyridoxine</td>
                                            <td>"; echo $vitamine_b6; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($vitamine_b9)) {echo "<tr>
                                            <td>Vitamine-b9-acide-folique</td>
                                            <td>"; echo $vitamine_b9; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($vitamine_b12)) {echo "<tr>
                                            <td>Vitamine-b12-cobalamine</td>
                                            <td>"; echo $vitamine_b12; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($amidons)) {echo "<tr>
                                            <td>Amidons</td>
                                            <td>"; echo $amidons; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($fer)) {echo "<tr>
                                            <td>Fer</td>
                                            <td>"; echo $fer; echo "</td>
                                        </tr>";} ?>
                                        <?php if(!empty($carbon_footprint)) {echo "<tr>
                                            <td>Empreinte de carbon</td>
                                            <td>"; echo $carbon_footprint; echo "</td>
                                        </tr>";} ?>
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
