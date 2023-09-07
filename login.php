 <?php
    session_start();
    include_once("./database/connection.php");

    if (isset($_SESSION["email"])) {
        header("Location: index.php");
        exit();
    }

    if (isset($_POST['submit'])) {
        $email = $_POST['email']; // Lấy giá trị email từ $_POST
        $pswd = $_POST['pswd']; // Lấy giá trị password từ $_POST

        // Kiểm tra xem email và mật khẩu có rỗng hay không
        if (!empty($email) && !empty($pswd)) {
            // Lấy thông tin người dùng từ cơ sở dữ liệu dựa trên email
            $stmt = $dbConn->prepare("SELECT id, email, password FROM users WHERE email=:email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra xem email có tồn tại hay không
            if ($user) {
                // Lấy thông tin người dùng
                $id = $user['id'];
                $email = $user['email'];
                $password_hash = $user['password'];
                // Kiểm tra mật khẩu
                if (password_verify($pswd, $password_hash)) {
                    // Lưu thông tin người dùng vào session
                    $_SESSION['email'] = $email;
                    // Redirect đến trang chính hoặc trang xác nhận đăng nhập thành công
                    header("Location: index.php");
                    exit();
                } else {
                    // Mật khẩu không chính xác
                    // Hiển thị thông báo lỗi
                    echo "<font color='red'>Mật khẩu không chính xác.</font><br/>";
                }
            } else {
                // Email không tồn tại
                echo "<font color='red'>Email của bạn không tồn tại.</font><br/>";
            }
        } else {
            // Người dùng không nhập đủ thông tin
            echo "<font color='red'>Bạn cần nhập đủ thông tin.</font><br/>";
        }
    }
    ?>

 <!doctype html>
 <html lang="en">

 <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

     <title>Login!</title>
     <link rel="stylesheet" type="text/css" href="./css/signin.css">

 </head>

 <body>

     <section class="Form my-4 mx-5">
         <div class="container">
             <div class="row no-gutters">
                 <div class="col-lg-5">
                     <img src="./images/background.jpg" class="img-fluid" alt="">
                 </div>
                 <div class="col-lg-7 px-5 pt-5">
                     <img src="./images/logo.jpg" class="py-1 logo" alt="">
                     <!-- <h1 class="font-weight-bold py-3">Logo</h1> -->
                     <h4>Sign into your account</h4>
                     <form action="login.php" method="post">
                         <div class="from-row p-1">
                             <div class="col-lg-7">
                                 <input type="email" placeholder="Email-Address" class="form-control my-3 p-3 "
                                     name="email">

                             </div>
                             <div class="from-row">
                                 <div class="col-lg-7">
                                     <input type="password" placeholder="***" class="form-control my-2 p-3 "
                                         name="pswd">
                                 </div>
                             </div>
                             <div class="from-row">
                                 <div class="col-lg-7">
                                     <button name="submit" type="submit" class="btn1 mt-3 mb-5">Login</button>
                                 </div>
                             </div>
                             <div class="form-check mb-3">
                                 <label class="form-check-label">
                                     <input class="form-check-input" type="checkbox" name="remember"> Remember me
                                 </label>
                             </div>
                             <a href="reset_password.php">Forgot password</a>
                             <p>Don't have an account? <a href="#">Register here</a></p>
                     </form>
                 </div>
             </div>
         </div>

     </section>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
         integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
     </script>

     <!-- Option 2: Separate Popper and Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
         integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
     </script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
         integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
     </script>

 </body>

 </html>