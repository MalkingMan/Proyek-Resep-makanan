<?php
// create_process.php

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php'; // Hubungkan ke database

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil data dari form
    $title = $_POST['judul'];
    $prep_time = $_POST['prep_time'];
    $cook_time = $_POST['cook_time'];
    $yields = $_POST['yields'];
    // Ganti koma dengan baris baru agar konsisten
    $ingredients = str_replace(',', "\n", $_POST['bahan']);
    $steps = $_POST['langkah'];

    // 2. Proses upload gambar
    $image_paths = [];
    $target_dir = "img/resep-img/"; 

    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            die("Gagal membuat folder 'img/resep-img/'. Pastikan Anda memiliki izin yang benar.");
        }
    }

    if (isset($_FILES['gambar']) && !empty($_FILES['gambar']['name'][0])) {
        foreach ($_FILES['gambar']['name'] as $key => $name) {
            $target_file = $target_dir . basename($name);
            if (move_uploaded_file($_FILES['gambar']['tmp_name'][$key], $target_file)) {
                $image_paths[] = $target_file;
            } else {
                echo "Gagal mengunggah file: " . htmlspecialchars($name);
            }
        }
    } else {
        die("Error: Tidak ada gambar yang diunggah.");
    }
    
    // Gabungkan path gambar menjadi satu string, dipisahkan koma
    $images_str = implode(",", $image_paths);

    // 3. Simpan data ke database (Nama tabel dikembalikan menjadi 'recipes')
    $stmt = $conn->prepare("INSERT INTO recipes (title, prep_time, cook_time, yields, ingredients, steps, images) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("sssssss", $title, $prep_time, $cook_time, $yields, $ingredients, $steps, $images_str);

    if ($stmt->execute()) {
        echo "<body style='font-family: Arial, sans-serif; text-align: center; margin-top: 50px;'>";
        echo "<h3>Resep baru berhasil disimpan!</h3>";
        echo "<a href='dashboard_admin.html' style='text-decoration: none; color: #4CAF50; margin: 10px;'>Kembali ke Dashboard</a> atau ";
        echo "<a href='create.php' style='text-decoration: none; color: #008CBA;'>Tambah Resep Lain</a>";
        echo "</body>";
    } else {
        echo "<h3>Error saat menyimpan data:</h3> <p>" . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
// index.php

include 'db_connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Delicious - Food Blog Template | Home</title>
    <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="preloader">
        <i class="circle-preloader"></i>
        <img src="img/core-img/salad.png" alt="">
    </div>
    
    <header class="header-area">
        <div class="delicious-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <nav class="classy-navbar justify-content-between" id="deliciousNav">
                        <a class="nav-brand" href="index.php"><img src="img/core-img/logo.png" alt=""></a>
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>
                        <div class="classy-menu">
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>
                            <div class="classynav">
                                <ul>
                                    <li class="active"><a href="index.php">Home</a></li>
                                    <li><a href="about.html">About us</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    
    <section class="hero-area">
        <div class="hero-slides owl-carousel">
            <div class="single-hero-slide bg-img" style="background-image: url(img/bg-img/bg1.jpg);">
                <div class="container h-100"><div class="row h-100 align-items-center"><div class="col-12 col-md-9 col-lg-7 col-xl-6"><div class="hero-slides-content" data-animation="fadeInUp" data-delay="100ms"><h2 data-animation="fadeInUp" data-delay="300ms">Resep Makanan Lezat</h2><p data-animation="fadeInUp" data-delay="700ms">Temukan berbagai resep masakan dari seluruh dunia.</p></div></div></div></div>
            </div>
        </div>
    </section>

    <section class="best-receipe-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h3>Daftar Resep</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                    // Nama tabel dikembalikan menjadi 'recipes'
                    $sql = "SELECT id, title, images FROM recipes ORDER BY created_at DESC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $images = !empty($row["images"]) ? explode(",", $row["images"]) : ['img/default.jpg'];
                            $first_image = trim($images[0]);
                ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-best-receipe-area mb-30">
                        <img src="<?php echo htmlspecialchars($first_image); ?>" alt="<?php echo htmlspecialchars($row["title"]); ?>" style="width:100%; height: 250px; object-fit: cover;">
                        <div class="receipe-content">
                            <a href="receipe-post.php?id=<?php echo $row["id"]; ?>">
                                <h5><?php echo htmlspecialchars($row["title"]); ?></h5>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    } else {
                        echo "<div class='col-12'><p>Belum ada resep yang ditambahkan.</p></div>";
                    }
                    $conn->close();
                ?>
            </div>
        </div>
    </section>
    
    <footer class="footer-area">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 h-100 d-flex flex-wrap align-items-center justify-content-between">
                    <a href="login_admin.html" class="admin-login-button">Login as Admin</a>
                    <div class="footer-logo">
                        <a href="index.php"><img src="img/core-img/logo.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/popper.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>
</body>
</html>
```php
<?php
// receipe-post.php

include 'db_connect.php'; // Hubungkan ke database

// Ambil ID resep dari URL
$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($recipe_id == 0) {
    die("Resep tidak ditemukan.");
}

// Ambil data resep dari database (Nama tabel dikembalikan menjadi 'recipes')
$stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $recipe = $result->fetch_assoc();
} else {
    die("Resep tidak ditemukan.");
}

$stmt->close();
$conn->close();

// Pisahkan string menjadi array
$ingredients_list = explode("\n", trim($recipe['ingredients']));
$steps_list = explode("\n", trim($recipe['steps']));
$images_list = !empty($recipe['images']) ? explode(",", $recipe['images']) : ['img/bg-img/breadcumb3.jpg'];
$first_image = trim($images_list[0]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($recipe['title']); ?> - Delicious</title>
    <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="preloader">
        <i class="circle-preloader"></i>
        <img src="img/core-img/salad.png" alt="">
    </div>

    <header class="header-area">
        <div class="delicious-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <nav class="classy-navbar justify-content-between" id="deliciousNav">
                        <a class="nav-brand" href="index.php"><img src="img/core-img/logo.png" alt=""></a>
                        <div class="classy-navbar-toggler"><span class="navbarToggler"><span></span><span></span><span></span></span></div>
                        <div class="classy-menu">
                            <div class="classycloseIcon"><div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div></div>
                            <div class="classynav">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="about.html">About us</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="breadcumb-area bg-img bg-overlay" style="background-image: url(<?php echo htmlspecialchars($first_image); ?>);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-text text-center">
                        <h2>Recipe</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="receipe-post-area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="receipe-slider owl-carousel">
                        <?php foreach($images_list as $image): ?>
                            <img src="<?php echo htmlspecialchars(trim($image)); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="receipe-content-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="receipe-headline my-5">
                            <span><?php echo date("F j, Y", strtotime($recipe['created_at'])); ?></span>
                            <h2><?php echo htmlspecialchars($recipe['title']); ?></h2>
                            <div class="receipe-duration">
                                <h6>Prep: <?php echo htmlspecialchars($recipe['prep_time']); ?></h6>
                                <h6>Cook: <?php echo htmlspecialchars($recipe['cook_time']); ?></h6>
                                <h6>Yields: <?php echo htmlspecialchars($recipe['yields']); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-8">
                        <?php foreach($steps_list as $index => $step): ?>
                        <div class="single-preparation-step d-flex">
                            <h4><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>.</h4>
                            <p><?php echo htmlspecialchars(trim($step)); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="col-12 col-lg-4">
                        <div class="ingredients">
                            <h4>Ingredients</h4>
                            <?php foreach($ingredients_list as $ingredient): if(!empty(trim($ingredient))): ?>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="ing_<?php echo md5($ingredient); ?>">
                                <label class="custom-control-label" for="ing_<?php echo md5($ingredient); ?>"><?php echo htmlspecialchars(trim($ingredient)); ?></label>
                            </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-area"> ... </footer>
    
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/popper.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>
</body>
</html>
