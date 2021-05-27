
<?php
require 'vendor/autoload.php';
session_start();
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUITS_DB?retryWrites=true&w=majority');
$db = $client->PRODUITS_DB;
$collection = $client->$db->PRODUITS;
$filters = [];
$options = [];


function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');

    $f = fopen('php://output', 'w');

    foreach ($array as $line) {
        fputcsv($f, $line, $delimiter);
    }
}  


$product_id=$_POST['code_fixe'];
$document = $collection->findOne(['code' => intval($product_id)]);


array_to_csv_download(array(
  array("name", $document['product_name'],), // this array is going to be the first row
  array("nutriscore", $document['nutriscore_grade']),
  array("ingredients", $document['ingredients_text']),
  array("novascore=", $document['nova_group']),
  array("poids", $document['quantity']),
  array("emballage", $document['packaging']),
  array("marque", $document['brands']),
  array("categories", $document['categories']),
  array("allergenes", $document['allergens']),
  array("portion", $document['serving_quantity']),
  array("additifs", $document['additives_en']),
  array("ecoscore", $document['ecoscore_grade_fr']),
  array("energie", $document['energy_100g']),
  array("gras", $document['fat_100g']),
  array("acides", $document['saturated-fat_100g']),
  array("glucides", $document['carbohydrates_100g']),
  array("sucres", $document['sugars_100g']),
  array("fibres", $document['fiber_100g']),
  array("sel", $document['proteins_100g']),
  array("alcool", $document['alcohol_100g']),
  array("calcium", $document['calcium_100g']),
  array("vitamine_b6", $document['vitamin-b6_100g']),
  array("vitamine_b12", $document['vitamin-b12_100g']),
  array("vitamine_b9", $document['vitamin-b9_100g']),
  array("vitamine_b2", $document['vitamin-b2_100g']),
  array("amidons", $document['starch_100g']),
  array("fer", $document['iron_100g']),
  array("carbon_footprint", $document['carbon-footprint_100g']),
  ), // this array is going to be the second row
  "numbers.csv"


);

?>
