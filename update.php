<?php
// update.php (Halaman untuk memilih resep yang akan diedit)
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Resep</title>
    <link rel="stylesheet" href="style.css">
   
</head>
<body class="section-padding-80">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h3>Pilih Resep untuk Diupdate</h3>
                </div>
            </div>
        </div>

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
                    <!-- Tautan ini akan mengarahkan ke edit_resep.php dengan ID yang benar -->
                    <a href="edit_resep.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit Resep Ini</a>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>Tidak ada resep yang tersedia untuk diupdate.</p>";
            }
            $conn->close();
            ?>
        </div>
         <a href="dashboard_admin.html" class="back-btn">&larr; Kembali ke Dashboard</a>
    </div>
</body>
</html>
