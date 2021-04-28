<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';
session_start();


try {
    $db = openDb();
    SelectAsJson($db, "SELECT * FROM customer WHERE customer_id= 1");
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}





