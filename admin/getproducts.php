<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

try {
    $db = openDb();
    selectAsJson($db, "select * from product, category WHERE product.category_id=category.category_id");
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}