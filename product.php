<?php
// http://127.0.0.1:3456/edit.php?id=2
//including the database connection file
include("./database/connection.php");
?>
<?php
// xử lý update sản phẩm
if (isset($_POST['submit'])) {

    $currentDirectory = getcwd();
    $uploadDirectory = "/images/";
    $fileName = $_FILES['image']['name'];
    $fileTmpName  = $_FILES['image']['tmp_name'];
    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
    // upload file
    move_uploaded_file($fileTmpName, $uploadPath);

    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $categoryId = $_POST['categoryId'];
    $description = trim($_POST['description']);


    // kiểm tra có cập nhật hình ảnh hay không
    if (empty($fileName)) {
        $sql = "UPDATE products SET name='$name',
                price='$price', quantity='$quantity',
                categoryId='$categoryId', 
                description='$description' WHERE id=$id";
    } else {
        $image = "http://127.0.0.1:1233/images/" . $fileName;
        $sql = "UPDATE products SET name='$name',
                price='$price', quantity='$quantity', 
                image='$image', categoryId='$categoryId', 
                description='$description' WHERE id=$id";
    }

    $dbConn->exec($sql);
    // chuyển hướng trang web về index.php
    header("Location: index.php");
    // SQL injection
} else {
    try {
        // lấy danh sách danh mục
        $categories = $dbConn->query("SELECT id, name FROM categories");
        // lấy id từ url
        $id = $_GET['id'];
        // kiểm tra id có tồn tại hay không
        if (empty($id) || !is_numeric($id)) {
            // hiện trang 404
            header("Location: 404.php");
        }
        // lấy thông tin sản phẩm
        $product = $dbConn->query("SELECT id, name, price, quantity, 
                image, description, categoryId FROM products WHERE id=$id");

        while ($row = $product->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $image = $row['image'];
            $description = $row['description'];
            $categoryId = $row['categoryId'];
        }
    } catch (Exception $e) {
    }
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
</head>

<body>

    <div class="container mt-3">
        <h2>Chỉnh sửa sản phẩm</h2>
        <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên sản phẩm:</label>
                <input value="<?php echo $id; ?>" type="hidden" name="id">
                <input value="<?php echo $name; ?>" type="text" class="form-control" id="name" placeholder="Enter name"
                    name="name">
            </div>
            <div class="mb-3 mt-3">
                <label for="price">Giá sản phẩm:</label>
                <input value="<?php echo $price; ?>" type="number" class="form-control" id="price"
                    placeholder="Enter price" name="price">
            </div>
            <div class="mb-3 mt-3">
                <label for="quantity">Số lượng:</label>
                <input value="<?php echo $quantity; ?>" type="number" class="form-control" id="quantity"
                    placeholder="Enter quantity" name="quantity">
            </div>
            <div class="mb-3 mt-3">
                <label for="image">Hình ảnh:</label>
                <input type="file" class="form-control" id="image" placeholder="Enter image" name="image">
                <img src="<?php echo $image; ?>" width="100" alt="Hình ảnh" />
            </div>
            <div class="mb-3 mt-3">
                <label for="categoryId">Danh mục:</label>
                <select class="form-control" id="categoryId" name="categoryId">
                    <?php
                    while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
                        if ($categoryId == $row['id']) {
                            echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        } else {
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" id="description" placeholder="Enter description"
                    name="description"><?php echo $description; ?></textarea>
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        // Kiểm tra người dùng có nhập đủ thông tin hay không
        const name = document.querySelector('#name').value;
        const price = document.querySelector('#price').value;
        const quantity = document.querySelector('#quantity').value;
        const categoryId = document.querySelector('#categoryId').value;
        const description = document.querySelector('#descriptionInput').value;

        if (!name || !price || !quantity || !categoryId || !description) {
            alert('Vui lòng nhập đầy đủ thông tin.');
            e.preventDefault();
            return false;
        }
    });
    </script>
</body>

</html>