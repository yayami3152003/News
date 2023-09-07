<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");

try {
    $keyword = $_GET('keyword');
    // $products = $dbConn->query("SELECT id, name, price,
    // quantity, image, description, categoryId FROM products");
    $products = $dbConn->query(" SELECT p.id, p.name, p.price, 
    p.quantity, p.image, p.description from products as p
    inner join categories as c on p.`categoryId` = c.id 
    where p.name like '%{$keyword}%' 
    or p.description like '%{$keyword}%' ");
    $products = $products->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(array(
        "status" => true,
        "products" => $products
    ));
} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "massage" => $e->getMessage()
        
    ));
}