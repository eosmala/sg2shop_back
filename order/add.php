<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$db = null;

$input = json_decode(file_get_contents('php://input'));
$fname = filter_var($input->firstName,FILTER_SANITIZE_STRING);
$lname = filter_var($input->lastName,FILTER_SANITIZE_STRING);
$address = filter_var($input->streetAddress,FILTER_SANITIZE_STRING);
$zipcode = filter_var($input->zipcode,FILTER_SANITIZE_STRING);
$city = filter_var($input->city,FILTER_SANITIZE_STRING);
$pnumber = filter_var($input->phonenumber,FILTER_SANITIZE_STRING);
$email = filter_var($input->email,FILTER_SANITIZE_STRING);
$cart = $input->cart;

try {
    $db = openDb();

    $db->beginTransaction();


    $query = $db->prepare('insert into customer (firstName, lastName, streetAddress, zipcode, city, phonenumber, email) values(:firstName, :lastName, :streetAddress, :zipcode, :city, :phonenumber, :email)');
    $query->bindValue(':firstName', $fname,PDO::PARAM_STR);
    $query->bindValue(':lastName', $lname,PDO::PARAM_STR);
    $query->bindValue(':streetAddress', $address,PDO::PARAM_STR);
    $query->bindValue(':zipcode', $zipcode,PDO::PARAM_STR);
    $query->bindValue(':city', $city,PDO::PARAM_STR);
    $query->bindValue(':phonenumber', $pnumber,PDO::PARAM_STR);
    $query->bindValue(':email', $email,PDO::PARAM_STR);
    $query->execute();

    $customer_id = $db->lastInsertId();

    $sql = "insert into `product_order` (customer_id) values ($customer_id)";
    $ordernumber = executeInsert($db,$sql);

    foreach ($cart as $product) {
        $sql = "insert into order_items (ordernumber, product_id) values ("
        .
          $ordernumber . "," . 
          $product->product_id
        . ")";
        executeInsert($db,$sql);
    }

    $db->commit();

    header('HTTP/1.1 200 OK');
    $data = array('id' => $customer_id);
    echo json_encode($data);
}
catch (PDOException $pdoex) {
    $db->rollback();
    returnError($pdoex);
}