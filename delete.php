<?php
//including the database connection file
include("./database/connection.php");
//getting id of the data from url
$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id=:id";
$query = $dbConn->prepare($sql);
$query->execute(array(':id' => $id));
header("Location:index.php");
?>