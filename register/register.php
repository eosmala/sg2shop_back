<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';


$input = json_decode(file_get_contents('php://input'));
$username = filter_var($input->username, FILTER_SANITIZE_STRING);
$email = filter_var($input->email, FILTER_SANITIZE_STRING);
$password = filter_var($input->passwrd, FILTER_SANITIZE_STRING);
//$cPass = filter_var($input->cPass, FILTER_SANITIZE_STRING);
$passHash = password_hash($password, PASSWORD_BCRYPT, array("cost => 12"));

try{
    $db = openDb();
    $query = $db->prepare('INSERT INTO customer(username, email, password) values(:username, :email, :pass)');
    $query->bindValue(':username', $username,PDO::PARAM_STR);
    $query->bindValue(':email', $email,PDO::PARAM_STR);
    $query->bindValue(':pass', $passHash,PDO::PARAM_STR);
    $query->execute();
    
    header('HTTP/1.1 200 OK');
    echo json_encode(array("ok" => true));
    } 
    catch (PDOExeption $pdoex) {
        returnError($pdoex);
    }