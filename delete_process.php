<?php
// delete_process.php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // 1. Dapatkan path gambar sebelum menghapus data resep dari database
    $stmt_select = $conn->prepare("SELECT images FROM recipes WHERE id = ?");
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $recipe = $result->fetch_assoc();
    
    if ($recipe && !empty($recipe['images'])) {
        $images_to_delete = explode(',', $recipe['images']);
        foreach ($images_to_delete as $image) {
            $image_path = trim($image);
            // Cek apakah file ada sebelum mencoba menghapusnya
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
    }
    $stmt_select->close();

    // 2. Hapus data resep dari database
    $stmt_delete = $conn->prepare("DELETE FROM recipes WHERE id = ?");
    $stmt_delete->bind_param("i", $id);

    if ($stmt_delete->execute()) {
        // Tampilkan pesan sukses dan link kembali
        echo "<body style='font-family: Arial, sans-serif; text-align: center; margin-top: 50px; background-color: #f9f9f9;'>";
        echo "<div style='background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: inline-block;'>";
        echo "<h3 style='color: #d9534f;'>Resep berhasil dihapus!</h3>";
        echo "<a href='delete.php' style='text-decoration: none; color: #008CBA; margin: 10px; display: inline-block;'>Hapus Resep Lain</a>";
        echo "<br><br>";
        echo "<a href='dashboard_admin.html' style='text-decoration: none; color: #4CAF50;'>Kembali ke Dashboard</a>";
        echo "</div>";
        echo "</body>";
    } else {
        echo "Error saat menghapus data: " . $stmt_delete->error;
    }

    $stmt_delete->close();
    $conn->close();
} else {
    // Jika halaman ini diakses secara langsung tanpa melalui form,
    // alihkan kembali ke halaman delete.
    header("Location: delete.php");
    exit();
}
?>
