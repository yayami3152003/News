<?php 
  // xóa session
  session_start();
  session_destroy();
  // chuyển hướng trang web về login.php
  header("Location: login.php");
  

 ?>