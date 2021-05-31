<?php
require 'vendor/autoload.php';
session_start();
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUCTS_DB?retryWrites=true&w=majority');
$db = $client->PRODUCTS_DB;
$collection = $client->$db->PRODUCTS;
$p=[];
$compares = $_POST['compare'];
if(empty($compares)) 
  {
    echo("Vous n'avez pas sélectionné de produits");
  } 
  else
  {
    $N = count($compares);
    for($i=0; $i < $N; $i++)
    {
      $p[$i]=$compares[$i];
    }
 }
$produit1=$collection->findOne(['code'=> intval($p[0])]);
$produit2=$collection->findOne(['code'=> intval($p[1])]);
$produit1nutri=$produit1['nutriscore_grade'];
$produit2nutri=$produit2['nutriscore_grade'];
$produit1nova=$produit1['nova_group'];
$produit2nova=$produit2['nova_group'];
$produit1eco=$produit1['ecoscore_grade_fr'];
$produit2eco=$produit2['ecoscore_grade_fr'];

$code_fixe1=$produit1['code'];
$categories1=$produit1['categories'];
$code_fixe2=$produit2['code'];
$categories2=$produit2['categories'];


// Produit 1
$cursor_suggestion1=$collection->find( array("nutriscore_grade" => $produit1nutri, "categories" => $categories1));
$cursor_count1=$collection->find( array("nutriscore_grade" => $produit1nutri, "categories" => $categories1));
$a1 = 0;
foreach($cursor_count1 as $document){
	$a1++;
}

// Produit 2
$cursor_suggestion2=$collection->find( array("nutriscore_grade" => $produit2nutri, "categories" => $categories2));
$cursor_count2=$collection->find( array("nutriscore_grade" => $produit2nutri, "categories" => $categories2));
$a2 = 0;
foreach($cursor_count2 as $document){
	$a2++;
}

?>
<!DOCTYPE html>

<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Comparaison Produits</title>
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
                    </p>
                </form>
            </div>
            <div class="row">
                <h2>Comparatif &#128525;</h2>
                
                    <table>
                        <thead>
                            <tr>
                                <th>Info</th>
                                <th>
                                    <figure>
                                        <img src="<?php echo $produit1['image_url'] ?>" alt="image produit1" width="250" height="250">
                                        <figcaption><?php echo $produit1['product_name'] ?></figcaption>
                                    </figure>
                                </th>
                                <th>
                                    <figure>
                                        <img src="<?php echo $produit2['image_url'] ?>" alt="image produit2" width="250" height="250">
                                        <figcaption><?php echo $produit2['product_name'] ?></figcaption>
                                    </figure>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nutri Score</td>
                                <td><?php if(!empty($produit1nutri)){ echo "<img src='images/nutri_score_$produit1nutri.png' alt='$produit1nutri' width='140' height='90'>"; }; ?></td>
                                <td><?php if(!empty($produit2nutri)){ echo "<img src='images/nutri_score_$produit2nutri.png' alt='$produit2nutri' width='140' height='90'>"; }; ?></td>
                            </tr>
                            <tr>
                                <td>Nova Score</td>
                                <td><?php if(!empty($produit1nova)){ echo "<img src='images/nova-group-$produit1nova.svg' alt='$produit1nova' width='50' height='80'>"; }; ?></td>
                                <td><?php if(!empty($produit2nova)){ echo "<img src='images/nova-group-$produit2nova.svg' alt='$produit2nova' width='50' height='80'>"; }; ?></td>
                            </tr>
                            <tr>
                                <td>Éco Score</td>
                                <td><?php if(!empty($produit1eco)){ echo "<img src='images/ecoscore-$produit1eco.svg' alt='$produit1eco' width='100' height='70'>"; }; ?></td>
                                <td><?php if(!empty($produit2eco)){ echo "<img src='images/ecoscore-$produit2eco.svg' alt='$produit2eco' width='100' height='70'>"; }; ?></td>
                            </tr>
                            <tr>
                                <td>Emballage</td>
                                <td><?php echo $produit1['packaging']?></td>
                                <td><?php echo $produit2['packaging']?></td>
                            </tr>
                            <tr>
                                <td>Poids Net</td>
                                <td><?php echo $produit1['quantity']?></td>
                                <td><?php echo $produit2['quantity']?></td>
                            </tr>
                            <tr>
                                <td>Portion</td>
                                <td><?php echo $produit1['serving_quantity']?></td>
                                <td><?php echo $produit2['serving_quantity']?></td>
                            </tr>
                            <tr>
                                <td>Marques</td>
                                <td><?php echo $produit1['brands']?></td>
                                <td><?php echo $produit2['brands']?></td>
                            </tr>
                            <tr>
                                <td>Labels</td>
                                <td><?php echo $produit1['labels']?></td>
                                <td><?php echo $produit2['labels']?></td>
                            </tr>
                            <tr>
                                <td>Ingrédients</td>
                                <td><?php echo $produit1['ingredients_text']?></td>
                                <td><?php echo $produit2['ingredients_text']?></td>
                            </tr>
                            <tr>
                                <td>Allergènes</td>
                                <td><?php echo $produit1['allergens']?></td>
                                <td><?php echo $produit2['allergens']?></td>
                            </tr>
                            <tr>
                                <td>Traces</td>
                                <td><?php echo $produit1['traces']?></td>
                                <td><?php echo $produit2['traces']?></td>
                            </tr>
                            <tr>
                                <td>Additifs</td>
                                <td><?php echo $produit1['additives_en']?></td>
                                <td><?php echo $produit2['additives_en']?></td>
                            </tr>
                            <tr>
                                <td>Energie</td>
                                <td><?php echo $produit1['energy_100g']?></td>
                                <td><?php echo $produit2['energy_100g']?></td>
                            </tr>
                            <tr>
                                <td>Matières grasses</td>
                                <td><?php echo $produit1['fat_100g']?></td>
                                <td><?php echo $produit2['fat_100g']?></td>
                            </tr>
                            <tr>
                                <td>Acides gras saturés</td>
                                <td><?php echo $produit1['saturated-fat_100g']?></td>
                                <td><?php echo $produit2['saturated-fat_100g']?></td>
                            </tr>
                            <tr>
                                <td>Glucides</td>
                                <td><?php echo $produit1['carbohydrates_100g']?></td>
                                <td><?php echo $produit2['carbohydrates_100g']?></td>
                            </tr>
                            <tr>
                                <td>Sucres</td>
                                <td><?php echo $produit1['sugars_100g']?></td>
                                <td><?php echo $produit2['sugars_100g']?></td>
                            </tr>
                            <tr>
                                <td>Fibres alimentaires</td>
                                <td><?php echo $produit1['fiber_100g']?></td>
                                <td><?php echo $produit2['fiber_100g']?></td>
                            </tr>
                            <tr>
                                <td>Protéines</td>
                                <td><?php echo $produit1['proteins_100g']?></td>
                                <td><?php echo $produit2['proteins_100g']?></td>
                            </tr>
                            <tr>
                                <td>Sel</td>
                                <td><?php echo $produit1['salt_100g']?></td>
                                <td><?php echo $produit2['salt_100g']?></td>
                            </tr>
                            <tr>
                                <td>Alcool</td>
                                <td><?php echo $produit1['alcohol_100g']?></td>
                                <td><?php echo $produit2['alcohol_100g']?></td>
                            </tr>
                            <tr>
                                <td>Calcium</td>
                                <td><?php echo $produit1['calcium_100g']?></td>
                                <td><?php echo $produit2['calcium_100g']?></td>
                            </tr>
                            <tr>
                                <td>Vitamine-b6-pyridoxine</td>
                                <td><?php echo $produit1['vitamin-b6_100g']?></td>
                                <td><?php echo $produit2['vitamin-b6_100g']?></td>
                            </tr>
                            <tr>
                                <td>Vitamine-b12-cobalamine</td>
                                <td><?php echo $produit1['vitamin-b12_100g']?></td>
                                <td><?php echo $produit2['vitamin-b12_100g']?></td>
                            </tr>
                            <tr>
                                <td>Vitamine-b1-thiamine</td>
                                <td><?php echo $produit1['vitamin-b1_100g']?></td>
                                <td><?php echo $produit2['vitamin-b1_100g']?></td>
                            </tr>
                            <tr>
                                <td>Vitamine-b9-acide-folique</td>
                                <td><?php echo $produit1['vitamin-b9_100g']?></td>
                                <td><?php echo $produit2['vitamin-b9_100g']?></td>
                            </tr>
                            <tr>
                                <td>Vitamine-b2-riboflavine</td>
                                <td><?php echo $produit1['vitamin-b2_100g']?></td>
                                <td><?php echo $produit2['vitamin-b2_100g']?></td>
                            </tr>
                            <tr>
                                <td>Amidons</td>
                                <td><?php echo $produit1['starch_100g']?></td>
                                <td><?php echo $produit2['starch_100g']?></td>
                            </tr>
                            <tr>
                                <td>Fer</td>
                                <td><?php echo $produit1['iron_100g']?></td>
                                <td><?php echo $produit2['iron_100g']?></td>
                            </tr>
                            <tr>
                                <td>Empreinte de carbon</td>
                                <td><?php echo $produit1['carbon-footprint_100g']?></td>
                                <td><?php echo $produit2['carbon-footprint_100g']?></td>
                            </tr>
                        </tbody>
                    </table>
                
            </div>
        </div>

        <div class="right">
            <h3>Suggestion d'autres produits similaires</h3>
            <div class="column_list">
                <ul>
                <?php
                $count = 0;
                $code_array = array();
                $random_number_array = range(0, $a1+1);
                shuffle($random_number_array );
                $random_number_array = array_slice($random_number_array ,0,3);
                foreach($cursor_suggestion1 as $document)  {
                    $name=$document['product_name'];
                    $image=$document['image_url'];
                    $code=$document['code'];
                    if ($code != $code_fixe1)
                    	if ($code != $code_fixe2)
                    			if (in_array($count, $random_number_array))
		                   		 echo "<li><figure><a href='fiche_produit.php?product=$code'><img src='$image' alt='$name' width='200' height='150'><figcaption>$name</figcaption></a></figure></li>";
	                $count++;
	                array_push($code_array, $code);

                }

                $count = 0;
                $random_number_array = range(0, $a2+1);
                shuffle($random_number_array );
                $random_number_array = array_slice($random_number_array ,0,3);
                foreach($cursor_suggestion2 as $document)  {
                    $name=$document['product_name'];
                    $image=$document['image_url'];
                    $code=$document['code'];
                    if ($code != $code_fixe1)
                    	if ($code != $code_fixe2)
                    			if (in_array($count, $random_number_array))
		                    		echo "<li><figure><a href='fiche_produit.php?product=$code'><img src='$image' alt='$name' width='200' height='150'><figcaption>$name</figcaption></a></figure></li>";
	                $count++;
                }

                ?>
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