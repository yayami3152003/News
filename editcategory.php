<?php
include_once("./database/connection.php");

try {
    //lay ds danh muc
    $categories = $dbConn->query("SELECT id,name  FROM categories");
    $id = $_GET['id'];
    // lay tt sp
    if (empty($id) || !is_numeric($id)) {
        header("Location: 404.php");
    }
    $category = $dbConn->query("select id,name,image from categories where id=$id");
    while ($row = $category->fetch(PDO::FETCH_ASSOC)) {
        $name = $row['name'];
        $image = $row['image'];
    }
} catch (Exception $e) {
    echo $e;
}

?>
<?php
if (isset($_POST['submit'])) {
    $currentDirectory = getcwd();
    $uploadDirectory = "/images/";
    $fileName = $_FILES['image']['name'];
    $fileTmpName  = $_FILES['image']['tmp_name'];
    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
    move_uploaded_file($fileTmpName, $uploadPath);
    $id = $_POST['id'];
    $name = $_POST['name'];
    $image = "http://127.0.0.1:1233/images/" . $fileName;
    if (empty($fileName)) {
        $sql = "UPDATE  categories set name='$name' where id=$id";
        $dbConn->exec($sql);
    } else {
        $sql = "UPDATE  categories set name='$name',image='$image' where id=$id";
        $dbConn->exec($sql);
    }
    header("Location:./category.php");
} else {
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit category</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Chỉnh sửa danh mục</h2>
        <form action="editcategory.php?id=<?php echo $id; ?>" method="post" onsubmit="validation(this)" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên:</label>
                <input value="<?php echo $id; ?>" name="id" type="hidden">
                <input value="<?php echo $name; ?>" type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <div class="mb-3 mt-3">
                <label for="image">Hình ảnh:</label>
                <input type="file" class="form-control" id="image" placeholder="Enter image" name="image">
                <img src="<?php echo $image; ?>" width="100px" id="image-display" alt="Hình ảnh" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const name = document.querySelector('name').value;
            if (!name || name.trim().length === 0) {
                swal('Vui lòng nhập tên danh mục');
                e.preventDefault();
                return false;
            }
            return true;
        });
        const image = document.querySelector('#image');
        const imageDisplay = document.querySelector('#image-display');
        image.addEventListener('change', function(e) {
            const file = this.files[0];
            const url = URL.createObjectURL(file);
            imageDisplay.src = url;
        });
    </script>
</body>

</html>