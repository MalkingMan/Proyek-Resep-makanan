<?php
// Hentikan output sebelum header
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
$query = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// 4. Verifikasi hasil
if ($user = mysqli_fetch_assoc($result)) {
    if ($password === $user['password'])
 {
        // Login berhasil: redirect
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: dashboard_admin.html");
        exit();
    }
}

// Jika login gagal
mysqli_stmt_close($stmt);
mysqli_close($conn);
echo "Username atau password salah!";

// Tutup output buffer
ob_end_flush();
?>
