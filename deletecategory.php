<?php
// include("./database/connection.php");
// try {
//     $id = $_GET['id'];
//     $sql = "DELETE FROM categories WHERE id=:id";
//     $query = $dbConn->prepare($sql);
//     $query->execute(array(':id' => $id));
//     header("Location:./category.php");
// } catch (Exception $e) {
//     session_start();
//     $_SESSION['error'] = "Lỗi khi xóa dữ liệu: " . $e->getMessage();
//     header("Location: ./category.php");
// }

include("./database/connection.php");
$id = $_GET['id'];
$sql = "DELETE FROM categories WHERE id=:id";
$query = $dbConn->prepare($sql);
$query->execute(array(':id' => $id));
header("Location:./category.php");
?>