<?php
require 'vendor/autoload.php';
session_start();
$client = new MongoDB\Client(
    'mongodb+srv://Yosra:iaIqRPWxXN9AsFuF@cluster0.bbe6n.mongodb.net/PRODUITS_DB?retryWrites=true&w=majority');
$db = $client->PRODUITS_DB;
$collection = $client->$db->PRODUITS;
$filters = $_POST["filters"];
$options = $_POST["options"];
$limit = $_POST["limit"];
$derniercode = $_POST["derniercode"];
$cursor=$collection->find($filters,$options);