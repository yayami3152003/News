<?php
session_start();
include("./database/connection.php");

// Xử lý thông báo lỗi nếu có
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']); // Xóa thông báo lỗi sau khi hiển thị
}
?>

<?php
$categories = $dbConn->query("SELECT id,name,image  FROM categories");

if (isset($_POST['submit'])) {

    $currentDirectory = getcwd();
    $uploadDirectory = "/uploads/";
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
    //upload file
    move_uploaded_file($fileTmpName, $uploadPath);
    $name = $_POST['name'];
    $image = $_POST['image'];
    // lay ip cua may thay vao day thi moblie se hieu
    $image = "http://127.0.0.1:1233/images/" . $fileName;
    $sql = "INSERT INTO categories (name, image)
    VALUES ('$name', '$image')";
    $dbConn->exec($sql);
    // chuyển hướng trang web về index.php
    header("Location: ./category.php");
}

// Fetch data from the database
$result = $dbConn->query("SELECT id, name, image FROM categories");

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
                    <a href="insertcategory.php" style="text-decoration: none; color: white;">
                        <i class="bi bi-plus-lg"></i> Thêm mới
                    </a>
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <a href="index.php" style="text-decoration: none; color: white;">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </button>


            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="container my-5 p-0">
        <table class="table table-hover text-center">
            <thead class="bg-dark text-light">
                <tr>
                    <th width='35%' scope="col">Tên danh mục</th>
                    <th width='35%' scope="col">Hình ảnh</th>
                    <th width='30%' scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody class=" bg-white">
                <?php
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td><img src='" . $row['image'] . "' width='100' height='100' class='img-fluid rounded'></td>";
                    echo "<td>
                    <a href='editcategory.php?id=" . $row['id'] . "' class='btn btn-warning me-2'><i class='bi bi-pencil'></i></a>
                    <a onClick='confirmDelete(" . $row['id'] . ", \"" . $row['image'] . "\")' class='btn btn-danger'><i class='bi bi-trash'></i></a>
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
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this product!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // Perform the delete operation
                window.location.href = "deletecategory.php?id=" + id + "&image=" + image;
            }
        });
    }
    </script>
</body>

</html>