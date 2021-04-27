<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';


$input = json_decode(file_get_contents('php://input'));
$product_id = filter_var($input->product_id,FILTER_SANITIZE_NUMBER_INT);

try{
$db = openDb();

$query = $db->prepare('DELETE FROM product WHERE product_id=:product_id');
$query->bindValue(':product_id', $product_id,PDO::PARAM_INT);

$query->execute();

header('HTTP/1.1 200 OK');
echo json_encode(array("ok" => true));
} 
catch (PDOExeption $pdoex) {
    returnError($pdoex);
}