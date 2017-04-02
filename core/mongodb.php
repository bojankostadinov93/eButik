<?php
require 'vendor/autoload.php';
$client = new MongoDB\Client;
$butik= $client->butik;
$categories=$butik->categories;
$Vnesi=$categories->insertMany([
    ['category' => 'Men', 'parent' => '0'],
    ['category' => 'Women', 'parent' => '0'],
    ['category' => 'Boys', 'parent' => '0'],
    ['category' => 'Girls', 'parent' => '0'],
    ['category' => 'Shirts', 'parent' => '1'],
    ['category' => 'Pants', 'parent' => '1'],
    ['category' => 'Shoes', 'parent' => '1'],
    ['category' => 'Accessories', 'parent' => '1'],
    ['category' => 'Shirts', 'parent' => '2'],
    ['category' => 'Pants', 'parent' => '2'],
    ['category' => 'Shoes', 'parent' => '2'],
    ['category' => 'Dresses', 'parent' => '2'],
    ['category' => 'Shirts', 'parent' => '3'],
    ['category' => 'Pants', 'parent' => '3'],
    ['category' => 'Dresses', 'parent' => '4'],
    ['category' => 'Shoes', 'parent' => '4'],
]);







?>