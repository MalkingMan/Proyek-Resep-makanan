<?php
// update_process.php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['judul'];
    $prep_time = $_POST['prep_time'];
    $cook_time = $_POST['cook_time'];
    $yields = $_POST['yields'];
    $ingredients = $_POST['bahan'];
    $steps = $_POST['langkah'];
    $existing_images = $_POST['existing_images'];

    $images_str = $existing_images;

    // Cek jika ada file gambar baru yang diunggah
    if (isset($_FILES['gambar']) && !empty($_FILES['gambar']['name'][0])) {
        $image_paths = [];
        $target_dir = "img/resep-img/";

        // Hapus gambar lama jika ada
        $old_images = explode(',', $existing_images);
        foreach ($old_images as $old_image) {
            $image_path = trim($old_image);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Unggah gambar baru
        foreach ($_FILES['gambar']['name'] as $key => $name) {
            $target_file = $target_dir . basename($name);
            if (move_uploaded_file($_FILES['gambar']['tmp_name'][$key], $target_file)) {
                $image_paths[] = $target_file;
            } else {
                echo "Gagal mengunggah file baru: " . htmlspecialchars($name);
            }
        }
        $images_str = implode(",", $image_paths);
    }

    // Update data ke database
    $stmt = $conn->prepare("UPDATE recipes SET title = ?, prep_time = ?, cook_time = ?, yields = ?, ingredients = ?, steps = ?, images = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $title, $prep_time, $cook_time, $yields, $ingredients, $steps, $images_str, $id);

    if ($stmt->execute()) {
        echo "<body style='font-family: Arial, sans-serif; text-align: center; margin-top: 50px;'>";
        echo "<h3>Resep berhasil diupdate!</h3>";
        echo "<a href='dashboard_admin.html' style='text-decoration: none; color: #4CAF50; margin: 10px;'>Kembali ke Dashboard</a> atau ";
        echo "<a href='update.php' style='text-decoration: none; color: #008CBA;'>Update Resep Lain</a>";
        echo "</body>";
    } else {
        echo "Error saat mengupdate data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
