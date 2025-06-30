<?php
// edit_resep.php (Form untuk Mengedit Resep)
include 'db_connect.php';

// Pastikan ID ada dan valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID resep tidak valid.");
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$resep = $result->fetch_assoc();

if (!$resep) {
    die("Resep tidak ditemukan.");
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Resep: <?php echo htmlspecialchars($resep['title']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Gaya CSS ini dibuat agar konsisten dengan halaman create.php */
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        body { 
            font-family: 'Poppins', sans-serif; 
            background: #f3fff2; /* Warna latar belakang hijau muda */
            color: #333; 
        }
        header { 
            background: #40ba37; /* Warna hijau utama */
            padding: 25px 20px; 
            color: white; 
            text-align: center; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        }
        header h1 { 
            font-size: 26px; 
            font-weight: 600; 
        }
        .container { 
            max-width: 900px; 
            margin: 30px auto; 
            padding: 25px; 
            background: #ffffff; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.08); 
        }
        h2 { 
            color: #1c8314; /* Warna hijau tua */
            margin-bottom: 25px; 
        }
        .form-group { 
            margin-bottom: 20px; 
        }
        label { 
            font-weight: 600; 
            display: block; 
            margin-bottom: 8px; 
        }
        input, textarea { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ccc; 
            border-radius: 6px; 
            font-size: 14px; 
            font-family: 'Poppins', sans-serif; 
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row .form-group {
            flex: 1;
        }
        button { 
            background: #40ba37; /* Warna hijau utama */
            color: white; 
            padding: 12px 25px; 
            border: none; 
            border-radius: 6px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: background 0.3s;
        }
        button:hover { 
            background: #1c8314; /* Warna hijau tua saat hover */
        }
        .current-images { 
            font-size: 12px; 
            color: #555;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <header><h1>Edit Resep</h1></header>
    <div class="container">
        <h2>📝 Edit Detail Resep: <?php echo htmlspecialchars($resep['title']); ?></h2>
        <form action="update_process.php" method="POST" enctype="multipart/form-data">
            <!-- Input tersembunyi untuk menyimpan ID resep -->
            <input type="hidden" name="id" value="<?php echo $resep['id']; ?>">
            <input type="hidden" name="existing_images" value="<?php echo htmlspecialchars($resep['images']); ?>">

            <div class="form-group">
                <label for="judul">Judul Resep</label>
                <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($resep['title']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="gambar">Upload Gambar Baru (Opsional: Ini akan menggantikan semua gambar lama)</label>
                <input type="file" id="gambar" name="gambar[]" accept="image/*" multiple>
                <p class="current-images">Gambar saat ini: <?php echo htmlspecialchars($resep['images']); ?></p>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="prep_time">Waktu Persiapan</label>
                    <input type="text" id="prep_time" name="prep_time" value="<?php echo htmlspecialchars($resep['prep_time']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="cook_time">Waktu Memasak</label>
                    <input type="text" id="cook_time" name="cook_time" value="<?php echo htmlspecialchars($resep['cook_time']); ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="yields">Jumlah Porsi</label>
                <input type="text" id="yields" name="yields" value="<?php echo htmlspecialchars($resep['yields']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="bahan">Bahan-bahan (Pisahkan dengan baris baru)</label>
                <textarea id="bahan" name="bahan" rows="6" required><?php echo htmlspecialchars($resep['ingredients']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="langkah">Langkah-langkah (Pisahkan dengan baris baru)</label>
                <textarea id="langkah" name="langkah" rows="8" required><?php echo htmlspecialchars($resep['steps']); ?></textarea>
            </div>
            
            <button type="submit">💾 Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
