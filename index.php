<!-- // * IMPORT FILE -->
<?php
// kiểm tra nếu không tồn tại biến $session['email]
// thì chuyển hướng trang web về login.php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include_once("./database/connection.php");
$_result = $dbConn->query("SELECT id, name, price, quantity, image FROM products");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Danh sách sản phẩm</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</head>

<body class="bg-light">
    <!-- me-2 and mx-2 -->
    <div class="container bg-dark text-light p-3 rounded my-4">
        <div class="d-flex align-items-center justify-content-end px-3">
            <h2><a class="text-white text-decoration-none"><i class="bi bi-yelp"></i> Thêm mới</a></h2>
            <!-- Button trigger modal -->
            <div class="ms-auto">
                <button type="button" class="btn btn-success mx-2" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop">
                    <a href="insert.php" style="text-decoration: none; color: white;">
                        <i class="bi bi-plus-lg"></i> Thêm mới
                    </a>
                </button>
                <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop">
                    <a href="logout.php" style="text-decoration: none; color: white;">
                        <i class="bi bi-box-arrow-left"></i></i> Logout
                    </a>
                </button>
                <a href="category.php" class='btn btn-success' style="margin-right: 10px">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    Danh mục
                </a>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="container mt-5 p-0">

        <table class="table table-hover text-center">
            <thead class="bg-dark text-light">
                <tr>
                    <th with='10%' scope="col" class="rounded-start">Sr</th>
                    <th with='15%' scope="col">Tên</th>
                    <th with='10%' scope="col">Giá</th>
                    <th with='10%' scope="col">Số lượng</th>
                    <th with='35%' scope="col">Hình ảnh</th>
                    <th with='20%' scope="col" class="rounded-end">Thao tác</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php
                while ($row = $_result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>"; // Hiển thị id
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td> <img src='" . $row['image'] . "' width='100'/></td>";
                    echo "<td>
            <a href='edit.php?id=" . $row['id'] . "&image=\"" . $row['image'] . " ' class='btn btn-warning me-2'><i class='bi bi-pencil-square'></i></a>
            <a onClick='confirmDelete(" . $row['id'] . ", \"" . $row['image'] . "\")' class='btn btn-danger'><i class='bi bi-trash3'></i> </a>
        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

    <script>
    const confirmDelete = (id, image) => {
        swal({
            title: "Bạn có chắc chắn muốn xóa?",
            text: "Sản phẩm này sẽ không thể khôi phục!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // Perform the delete operation
                window.location.href = "delete.php?id=" + id + "&image=" + image;
            }
        });
    }
    </script>
</body>

</html>