<?php
include 'db_connect.php'; // Hubungkan ke database

// Ambil ID resep dari URL
$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($recipe_id == 0) {
    die("Resep tidak ditemukan.");
}

// Ambil data resep dari database
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
$images_list = explode(",", $recipe['images']);
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

    <!-- Header (sama seperti sebelumnya) -->
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

    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb-area bg-img bg-overlay" style="background-image: url(<?php echo htmlspecialchars($images_list[0]); ?>);">
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
        <!-- Receipe Slider -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="receipe-slider owl-carousel">
                        <?php foreach($images_list as $image): ?>
                            <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Receipe Content Area -->
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
                            <?php foreach($ingredients_list as $ingredient): ?>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="ing_<?php echo md5($ingredient); ?>">
                                <label class="custom-control-label" for="ing_<?php echo md5($ingredient); ?>"><?php echo htmlspecialchars(trim($ingredient)); ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer (sama seperti sebelumnya) -->
    <footer class="footer-area"> ... </footer>
    
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/popper.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>
</body>
</html>
