<?php
// create.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Buat Resep Makanan Baru</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
    /* Styling dasar untuk form */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; background: #f3fff2; color: #333; padding-bottom: 60px; /* Memberi ruang di bawah */ }
    header { background: #40ba37; padding: 25px 20px; color: white; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
    header h1 { font-size: 26px; font-weight: 600; }
    .container { max-width: 900px; margin: 30px auto; padding: 25px; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); }
    h2 { color: #1c8314; margin-bottom: 25px; }
    .form-group { margin-bottom: 20px; }
    label { font-weight: 600; display: block; margin-bottom: 8px; }
    input, textarea, select { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; font-family: 'Poppins', sans-serif; }
    .form-row { display: flex; gap: 20px; }
    .form-row .form-group { flex: 1; }
    button { background: #1c8314; color: white; padding: 12px 25px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: all 0.2s ease-in-out; font-size: 16px; }
    button:hover { background-color: #159d08; }

    /* CSS untuk Tombol Kembali ke Dashboard yang baru */
   
  </style>
</head>
<body>

  <header>
    <h1>🥗 Delicious - Buat Resep Baru</h1>
  </header>

  <div class="container">
    <h2>📝 Masukkan Detail Resep</h2>
    <form action="create_process.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="judul">Judul Resep</label>
        <input type="text" id="judul" name="judul" placeholder="e.g., Burger Daging Sapi Lezat" required>
      </div>
      
      <div class="form-group">
        <label for="gambar">Upload Gambar (bisa lebih dari satu)</label>
        <input type="file" id="gambar" name="gambar[]" accept="image/*" multiple required>
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="prep_time">Waktu Persiapan</label>
          <input type="text" id="prep_time" name="prep_time" placeholder="e.g., 15 mins" required>
        </div>
        <div class="form-group">
          <label for="cook_time">Waktu Memasak</label>
          <input type="text" id="cook_time" name="cook_time" placeholder="e.g., 30 mins" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="yields">Jumlah Porsi</label>
        <input type="text" id="yields" name="yields" placeholder="e.g., 8 Servings" required>
      </div>
      
      <div class="form-group">
        <label for="bahan">Bahan-bahan (pisahkan dengan baris baru)</label>
        <textarea id="bahan" name="bahan" rows="6" placeholder="contoh:&#10;2 telur&#10;1 sdt garam&#10;100ml susu" required></textarea>
      </div>
      
      <div class="form-group">
        <label for="langkah">Langkah-langkah (pisahkan dengan baris baru)</label>
        <textarea id="langkah" name="langkah" rows="8" placeholder="contoh:&#10;1. Kocok telur&#10;2. Tambahkan garam" required></textarea>
      </div>
      
      <button type="submit">💾 Simpan Resep</button>
    </form>
    
    <!-- Tautan ini sekarang akan terlihat dan berada di bawah form -->
    <a href="dashboard_admin.html" class="back-btn">&larr; Kembali ke Dashboard</a>
  </div>

  <

</body>
</html>
