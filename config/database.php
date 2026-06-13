<?php
// Memastikan sesi diaktifkan di baris paling pertama sistem faksi
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "gang_street"; // Pastikan nama database di phpMyAdmin kamu persis seperti ini!

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>
