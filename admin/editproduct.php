<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';


$input = json_decode(file_get_contents('php://input'));
$product_id = filter_var($input->product_id,FILTER_SANITIZE_NUMBER_INT);
$product_name = filter_var($input->product_name,FILTER_SANITIZE_STRING);
$price = filter_var($input->price,FILTER_SANITIZE_STRING);
$stock_amount = filter_var($input->stock_amount,FILTER_SANITIZE_NUMBER_INT);
$category_id = filter_var($input->category_id,FILTER_SANITIZE_NUMBER_INT);
$description = filter_var($input->description,FILTER_SANITIZE_STRING);

try{
$db = openDb();

$query = $db->prepare('UPDATE product SET product_name=:product_name, price=:price, stock_amount=:stock_amount, category_id=:category_id, description=:description WHERE product_id=:product_id');
$query->bindValue(':product_id', $product_id,PDO::PARAM_INT);
$query->bindValue(':description', $description,PDO::PARAM_STR);
$query->bindValue(':product_name', $product_name,PDO::PARAM_STR);
$query->bindValue(':price', $price,PDO::PARAM_STR);
$query->bindValue(':stock_amount', $stock_amount,PDO::PARAM_INT);
$query->bindValue(':category_id', $category_id,PDO::PARAM_INT);
$query->execute();

header('HTTP/1.1 200 OK');
echo json_encode(array("ok" => true));
} 
catch (PDOExeption $pdoex) {
    returnError($pdoex);
}