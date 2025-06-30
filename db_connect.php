<?php
// db_connect.php

$servername = "localhost";
$username = "root";
$password = ""; // Sesuaikan jika Anda menggunakan password
$dbname = "pdw_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi dan menampilkan pesan error jika gagal
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// Baris ini bisa diaktifkan untuk memastikan koneksi berhasil saat testing
// echo "Koneksi berhasil!"; 
?>
