<?php
session_start();
require_once '../inc/headers.php';
require_once '../inc/functions.php';

$input = json_decode(file_get_contents('php://input'));
$username = filter_var($input->username, FILTER_SANITIZE_STRING);
$userEmail = filter_var($input->email, FILTER_SANITIZE_STRING);
$fname = filter_var($input->firstName, FILTER_SANITIZE_STRING);
$lname = filter_var($input->lastName, FILTER_SANITIZE_STRING);
$address = filter_var($input->streetAddress, FILTER_SANITIZE_STRING);
$zipcode = filter_var($input->zipcode, FILTER_SANITIZE_NUMBER_INT);
$city = filter_var($input->city, FILTER_SANITIZE_STRING);
$country = filter_var($input->country, FILTER_SANITIZE_STRING);
$phone = filter_var($input->phonenumber, FILTER_SANITIZE_NUMBER_INT);

try {
    $db = openDb();

    $update = $db->prepare("UPDATE customer SET email=:email, username=:username, firstName=:fname, lastName=:lname, streetAddress=:addr, zipcode=:zipcode, city=:city, country=:country, 
    phonenumber=:phone WHERE customer_id = 1");
    $update->bindvalue(":email", $userEmail, PDO::PARAM_STR);
    $update->bindValue(":username", $username, PDO::PARAM_STR);
    $update->bindValue(":fname", $fname, PDO::PARAM_STR);
    $update->bindValue(":lname", $lname, PDO::PARAM_STR);
    $update->bindValue(":addr", $address, PDO::PARAM_STR);
    $update->bindValue(":zipcode", $zipcode, PDO::PARAM_INT);
    $update->bindValue(":city", $city, PDO::PARAM_STR);
    $update->bindValue(":country", $country, PDO::PARAM_STR);
    $update->bindValue(":phone", $phone, PDO::PARAM_INT);
    $update->execute();

    header('HTTP/1.1 200 OK');
    echo json_encode(array("ok" => true));

}catch (PDOExeption $pdoex) {
    returnError($pdoex);
}