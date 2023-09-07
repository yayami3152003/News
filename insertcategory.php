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
  $uploadDirectory = "/images/";
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
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

  <div class="container mt-3">
    <h2>Thêm sản phẩm</h2>
    <form id="form" action="insertcategory.php" method="post" enctype="multipart/form-data">
      <div class="mb-3 mt-3">
        <label for="name">Tên sản phẩm: </label>
        <input type="Text" class="form-control" id="name" placeholder="Enter name" name="name">
      </div>
      <div class="mb-3 mt-3">
        <label for="image">Hình ảnh: </label>
        <input type="file" class="form-control" id="image" placeholder="Enter image" name="image">
        <img id="image-display" width="100" height="100" aria-readonly="10" alt="Hình ảnh" />
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

</body>

</html>
<script>
  const addButton = document.getElementById("add-button");

  //hien thi hinh anh khi ng dung chon anh
  const image = document.querySelector('#image');
  const imageDisplay = document.querySelector('#image-display');
  image.addEventListener('change', function(e) {
    const file = this.files[0];
    const url = URL.createObjectURL(file);
    imageDisplay.src = url;
  });
</script>