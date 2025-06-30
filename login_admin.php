<?php
// Mulai output buffering di baris paling awal
ob_start();

// 1. Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "pdw_db");

// Jika koneksi gagal, hentikan skrip
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// 3. Gunakan prepared statements
$query = "SELECT * FROM admin WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// 4. Verifikasi hasil
if ($user = mysqli_fetch_assoc($result)) {
    // Verifikasi password (Di contoh ini password tidak di-hash, seharusnya di-hash)
    if ($password === $user['password']) {
        // Login berhasil: tutup koneksi dan redirect ke dashboard
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: dashboard_admin.html");
        exit(); // <-- Penting
    }
}

// Jika kode sampai di sini, artinya login GAGAL.
// Tutup koneksi dan redirect kembali ke halaman login.
mysqli_stmt_close($stmt);
mysqli_close($conn);
header("Location: login_admin.html?error=1");
ob_end_flush(); // Kirim output buffer (jika ada)
exit(); // <-- Penting
?>
