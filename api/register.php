<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once("../database/connection.php");
try {
    //code...

    $body = json_decode(file_get_contents("php://input"));

    $email = $body->email;
    $password = $body->password;
    $name = $body->name;

    if (empty($email) || empty($password) || empty($name)) {
        echo json_encode(array(
            "status" => false,
            "message" => " Vui lòng nhập đầy đủ thông tin"
        ));
        return;
    }

    $user = $dbConn->query("SELECT id,email, password 
                    FROM users where email='$email'");
    if ($user->rowCount() > 0) {
        echo json_encode(array(
            "status" => false,
            "message" => "Tài khoảng đã tồn tại"
        ));
        return;
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $dbConn->query("INSERT INTO users (email,password,name) 
                        VALUES ('$email','$password','$name') ");
        echo json_encode(array(
            "status" => true
        ));
    }
} catch (Exception $e) {
    //throw $th;
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}