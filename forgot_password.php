<?php
include_once("./database/connection.php");
//GET
if (!isset($_POST['submit'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    // kiểm tra email và token có tồn tại hay không
    if (empty($email) || empty($token)) {
        $error_message = "Đã xảy ra lỗi. k co email hoac token";
        header("Location: 404.php?error_message=" . urlencode($error_message));
        exit();
    }
    // check token
    $result = $dbConn->query("select id from reset_password where email ='$email' 
        and token ='$token' 
        and createdAt >= DATE_SUB(NOW(),INTERVAL 1 HOUR)
        and avaiable =1 ");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        $error_message = "Đã xảy ra lỗi. k co user";
        header("Location: 404.php?error_message=" . urlencode($error_message));
        exit();
    }
}
//POST
else {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($password != $confirm_password) {
        $error_message = "Đã xảy ra lỗi. Mat khau k khop";
        header("Location: 404.php?error_message=" . urlencode($error_message));
        exit();
    }
    // check token
    $result = $dbConn->query("select id from reset_password where email ='$email' 
                and token ='$token' 
                and createdAt >= DATE_SUB(NOW(),INTERVAL 1 HOUR)
                and avaiable =1 ");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        $error_message = "Đã xảy ra lỗi. k co user";
        header("Location: 404.php?error_message=" . urlencode($error_message));
        exit();
    }
    // cap nhat mk moi 
    $password = password_hash($password, PASSWORD_BCRYPT);
    $dbConn->query("update users set 
        password = '$password'
        where email='$email' ");

    // hủy token
    $dbConn->query(" update reset_password set 
                    avaiable = 0 
                    where email = '$email'
                    and token = '$token' ");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='/stylesheets/style.css' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>Document</title>

</head>

<body
    style="background-image: url('https://duhocchaudaiduong.edu.vn/hinh-nen-one-piece-4k/imager_2_4169_700.jpg');background-repeat: no-repeat; background-size: cover">
    <section
        style="background-image: url('https://duhocchaudaiduong.edu.vn/hinh-nen-one-piece-4k/imager_2_4169_700.jpg');background-repeat: no-repeat; background-size: cover"
        class="vh-150 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Forgot password</h2>
                                <p class="text-white-50 mb-4">Please enter your new password and re-enter your new
                                    password!</p>
                                <p class="text-white-50 mb-4">Từ Thị Thu Trang</p>
                                <form action="forgot_password.php" method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input placeholder="Mật khẩu mới" type="password" id="typeEmailX"
                                            class="form-control form-control-lg" name="password" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input placeholder="Nhập lại mật khẩu mới" type="password" id="typePasswordX"
                                            class="form-control form-control-lg" name="confirm_password" />
                                    </div>
                                    <input type="hidden" name="email" value="<?php echo $_GET['email'] ?>">
                                    <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
                                    <button class="btn btn-outline-light btn-lg px-5" name="submit" type="submit">Khôi
                                        phục</button>
                                </form>
                            </div>
                            <div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
        </style>
    </section>

</body>

</html>