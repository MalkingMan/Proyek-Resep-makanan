<?php
// delete.php (Halaman untuk memilih resep yang akan dihapus)
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Resep</title>
    <link rel="stylesheet" href="style.css">
       
</head>
<body class="section-padding-80">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h3>Pilih Resep untuk Dihapus</h3>
                </div>
            </div>
        </div>

        <?php
        // Tampilkan pesan sukses jika ada parameter 'status=success' di URL
        if (isset($_GET['status']) && $_GET['status'] == 'success') {
            echo '<div class="success-message">Resep berhasil dihapus!</div>';
        }
        ?>

        <div class="recipe-card-container">
            <?php
            $sql = "SELECT id, title, images FROM recipes ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $first_image = !empty($row['images']) ? explode(',', $row['images'])[0] : 'img/default.jpg';
            ?>
            <div class="recipe-card">
                <img src="<?php echo htmlspecialchars(trim($first_image)); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                <div class="recipe-card-content">
                    <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                    <form action="delete_process.php" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus resep ini secara permanen?');">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="delete-btn">Hapus Resep Ini</button>
                    </form>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>Tidak ada resep yang tersedia untuk dihapus.</p>";
            }
            $conn->close();
            ?>
        </div>
        <a href="dashboard_admin.html" class="back-btn">&larr; Kembali ke Dashboard</a>
    </div>
</body>
</html>
