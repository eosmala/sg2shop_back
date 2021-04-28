<?php
session_start();
require_once '../inc/headers.php';
require_once '../inc/functions.php';

$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

$sql = "SELECT customer_id, email, password FROM customer WHERE email='$email'";

try {
  $db = openDb();
  $query = $db->query($sql);
  $user = $query->fetch(PDO::FETCH_OBJ);
  if ($user) {
    $passwordFromDb = $user->password;
    if (password_verify($password,$passwordFromDb)) {
      $data = array(
        'customer_id' => $user->customer_id
      );
      $_SESSION['user'] = $user;
    } else {
      header('HTTP/1.1 401 Unauthorized');
      $data = array('message' => "Unsuccessfull login.");
    }
  } else {
    header('HTTP/1.1 401 Unauthorized');
    $data = array('message' => "Unsuccessfull login.");
  }
  echo json_encode($data);


  
} catch (PDOException $pdoex) {
  returnError($pdoex); 
}