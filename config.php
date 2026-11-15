<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_sidang_yudisium";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

define('PUBLIC_KEY_PATH', __DIR__ . '/keys/public_key.pem');
?>