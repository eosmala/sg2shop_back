<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

// read parameters from url
$uri = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);

// parameters are separated with a slash
$parameters = explode('/', $uri);

// category id is first parameter so it follows after address  separated with slash
$productId = $parameters[1];

try {
    $db = openDb();
    selectAsJson($db, "select * from product where product_id = $productId");
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}
?>