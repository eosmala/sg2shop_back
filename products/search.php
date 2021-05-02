<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$uri = parse_url(filter_input(INPUT_SERVER,'PATH_INFO'),PHP_URL_PATH);
$criteria = $_GET['product'];

try {
    $db = openDb();
    $sql = "select * from product where product_name like '%$criteria%'";
    $query = $db->query($sql);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    echo header('HTTP/1.1 200 OK');
    echo json_encode($results);
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}