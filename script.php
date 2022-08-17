<?php
/*
 * -Makes Api call and fills the database.
 * -Avoids repeated data entry for Country and Petroleum Product tables
 * -Important to run this file at-least once  before running index.php
 */

require_once 'API/Models/Countries.php';
require_once 'API/Models/Sales.php';
require_once 'API/Models/Petrolium.php';

$countryTable = new Countries('./DB');
$salesTable = new Sales('./DB');
$productTable = new Petrolium('./DB');

$jsonArray = getJsonFromApi();

/*
 * Traverses jsonArray, pushes each unique country and product to respective list
 */
$countryList = array();
$productList = array();
foreach ($jsonArray as $data) {
    if (!isset($countryList[$data->country])) {
        $countryList[$data->country] = $data->country;
    }
    if (!isset($productList[$data->petroleum_product])) {
        $productList[$data->petroleum_product] = $data->petroleum_product;
    }
}

/*
 * Fill Country and Product table
 */
foreach ($countryList as $country) {
    $countryTable->insert(country: $country);
}
foreach ($productList as $product) {
    $productTable->insert(product: $product);
}

/*
 * Fetch country id and product id, then Fill Sales table
 */

foreach ($jsonArray as $data) {
    $countryId = $countryTable->getIdByName($data->country);
    $productId = $productTable->getIdByName($data->petroleum_product);
    $year = $data->year;
    $sale = $data->sale;
    $params = array(
        "cid" => $countryId,
        "pid" => $productId,
        "year" => $year,
        "sale" => $sale,
    );
    $salesTable->insert(sale: $params);
}


if($jsonArray){
    echo "Script execution completed. <a href='./WebApp/index.php'>Click here</a> to view data.";
}


function getJsonFromApi()
{
    $url = "https://raw.githubusercontent.com/younginnovations/internship-challenges/master/programming/petroleum-report/data.json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    return json_decode($result);
}