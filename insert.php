<?php
session_start();
include_once("./database/connection.php");
$_result = $dbConn->query("SELECT id, name FROM categories");
?>
<!-- //? Save data to database when submitted -->
<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    //! Check image file
    // You can use the `mkdir()` function to create a directory if it doesn't exist:
    $targetDir = "images/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    // Upload the image file and save the path
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if the file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        $uploadOk = 0;
    }

    // Check the file size
    if ($_FILES["image"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    // Check if the destination directory has write permission using `is_writable()` function:
    if (!is_writable($targetDir)) {
        // Display error message or perform other actions if needed
        echo "The destination directory does not have write permission.";
        exit;
    }

    // Perform additional checks and operations related to the image field
    if (isset($_FILES["image"])) {
        // Perform operations related to the image field
    } else {
        // echo "The image field does not exist.";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Upload failed.";
        // If there are no errors, save the file to the 'images/' directory
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = "images/" . basename($_FILES["image"]["name"]);
            $categoryId = $_POST['categoryId'];
            $description = trim($_POST['description']);

            $sql = "INSERT INTO products (name, price, quantity, image, categoryId, description)
            VALUES ('$name', '$price', '$quantity', '$image', '$categoryId', '$description')";
            $dbConn->exec($sql);

            // Redirect the web page to index.php
            header("Location: index.php");
        } else {
            echo "Error uploading the file.";
        }
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <div class="container mt-3">
        <h2>Add Product</h2>
        <form action="insert.php" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Product Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <div class="mb-3 mt-3">
                <label for="price">Product Price:</label>
                <input type="number" class="form-control" id="price" placeholder="Enter price" name="price">
            </div>
            <div class="mb-3 mt-3">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" placeholder="Enter quantity" name="quantity">
            </div>
            <div class="mb-3 mt-3">
                <label for="image">Image:</label>
                <input type="file" class="form-control" id="image" placeholder="Enter image" name="image" onchange="displayImage(this)">
                <img id="previewImage" src="" width="100" />
            </div>
            <div class="mb-3 mt-3">
                <label for="categoryId">Categories:</label>
                <select class="form-control" id="categoryId" name="categoryId">
                    <?php
                    while ($row = $_result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" placeholder="Enter description" name="description"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        if (isset($_POST['description'])) {
            $description = $_POST['description'];
        } else {
            $description = '';
        }
    </script>
    <script>
        // Check if the user has selected an image:
        var imageInput = document.getElementById("image");
        // Check if the user has entered data in the other fields
        var nameInput = document.getElementById("name");
        var priceInput = document.getElementById("price");
        var quantityInput = document.getElementById("quantity");
        var categoryIdInput = document.getElementById("categoryId");
        var descriptionInput = document.getElementById("description");

        // const form =document.querySelector('#form');
        // form.addEventListener('submit', function(e){
        //     // Check if the user has entered a product name
        //     const name = document.querySelector('#name').value;
        //     if(!name || name.trim().length===0){
        //         alert('Please enter all required fields');
        //         e.preventDefault();
        //         return false;
        //     }
        //     return true;
        // });
    </script>
    <script>
        function displayImage(input) {
            var previewImage = document.getElementById("previewImage");
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>