<?php
include 'db.php';

$user = $_POST['user'];
$pass = $_POST['pass'];

// BU KOD TƏHLÜKƏLİDİR (Vulnerable to SQL Injection)
$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Giriş uğurludur! Xoş gəldiniz Admin.</h1>";
    echo "<a href='admin.php'>Admin Panelinə Get</a>";
} else {
    echo "<h1>Səhv məlumat!</h1>";
    echo "<a href='login.html'>Yenidən cəhd et</a>";
}
?>