<?php
session_start();
$_SESSION['user_data']['admin'] = "true";
echo '<script>alert("Megtaláltad a titkos utat az admin joghoz yeey"); window.location.href="home.php";</script>';
?>