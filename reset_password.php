<?php
include_once("./database/connection.php");

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password != $confirm_password) {
        header("Location: reset_password.php?email=$email&token=$token");
        exit();
    }

    // Validate token and email
    $result = $dbConn->prepare("SELECT id FROM reset_password
      WHERE email = :email
      AND token = :token
      AND createdAt >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
      AND avaiable = 1"); // Corrected column name here
    $result->bindParam(':email', $email);
    $result->bindParam(':token', $token);
    $result->execute();

    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        header("Location: 404.php");
        exit();
    } else {
        echo "User found, proceeding with password reset."; // Debug output
    }

    // Update password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $updatePasswordQuery = $dbConn->prepare("UPDATE users SET password = :password WHERE email = :email");
    $updatePasswordQuery->bindParam(':password', $hashedPassword);
    $updatePasswordQuery->bindParam(':email', $email);
    $updatePasswordQuery->execute();

    // Invalidate token
    $invalidateTokenQuery = $dbConn->prepare("UPDATE reset_password SET avaiable = 0 WHERE email = :email AND token = :token");
    $invalidateTokenQuery->bindParam(':email', $email);
    $invalidateTokenQuery->bindParam(':token', $token);
    $invalidateTokenQuery->execute();

    header("Location: login.php");
    exit();
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

    <title>Reset Password</title>
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
                    <h4>Reset Your Password</h4>
                    <form action="reset_password.php" method="post">
                        <!-- Hidden inputs for email and token -->
                        <input type="hidden" name="email"
                            value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                        <input type="hidden" name="token"
                            value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : ''; ?>">
                        <div class="from-row p-1">
                            <div class="col-lg-7">
                                <!-- Password input fields -->
                                <input type="password" placeholder="New Password" class="form-control my-3 p-3"
                                    name="password" required>
                                <input type="password" placeholder="Confirm Password" class="form-control my-3 p-3"
                                    name="confirm_password" required>
                            </div>
                        </div>
                        <div class="from-row">
                            <div class="col-lg-7">
                                <button name="submit" type="submit" class="btn1 mt-3 mb-5">Reset Password</button>
                            </div>
                        </div>
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