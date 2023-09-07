<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");

try {
    $body = json_decode(file_get_contents("php://input"));

    $email = $body->email;
    $pswd = $body->password;

    $user = $dbConn->prepare("SELECT id, email, password FROM users WHERE email=:email");
    $user->execute(array(':email' => $email));

    // Kiểm tra xem email có tồn tại hay không
    if ($row = $user->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        $email = $row['email'];
        $password_hash = $row['password'];

        // Kiểm tra mật khẩu
        if (password_verify($pswd ,$password_hash)) {
            // Trả về thông tin user dưới dạng JSON
            echo json_encode(array(
                "status" => true,
        
            ));
        } else {
            // Trả về "status" false với thông báo lỗi
            echo json_encode(array(
                "status" => false,
                "message" => "Mật khẩu không đúng"
            ));
        }
    } else {
        // Trả về "status" false với thông báo lỗi
        echo json_encode(array(
            "status" => false,
            "message" => "Email không tồn tại"
        ));
    }
} catch (Exception $e) {
    // Trả về "status" false với thông báo lỗi
    echo json_encode(array(
        "status" => false,
        "message" => "Đã xảy ra lỗi"
    ));
}
?>