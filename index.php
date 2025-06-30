<?php
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

    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/core-img/favicon.ico">
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
            <?php
                // Mengambil 3 resep terbaru untuk ditampilkan di slider
                $slider_sql = "SELECT id, title, images FROM recipes ORDER BY created_at DESC LIMIT 3";
                $slider_result = $conn->query($slider_sql);
                if ($slider_result && $slider_result->num_rows > 0) {
                    while($slide = $slider_result->fetch_assoc()) {
                        $slide_image = !empty($slide['images']) ? trim(explode(",", $slide['images'])[0]) : 'img/bg-img/bg1.jpg';
            ?>
            <div class="single-hero-slide bg-img" style="background-image: url(<?php echo htmlspecialchars($slide_image); ?>);">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                            <div class="hero-slides-content" data-animation="fadeInUp" data-delay="100ms">
                                <h2 data-animation="fadeInUp" data-delay="300ms"><?php echo htmlspecialchars($slide['title']); ?></h2>
                                <p data-animation="fadeInUp" data-delay="700ms">Temukan cara membuatnya di sini dan sajikan hidangan terbaik untuk keluarga Anda.</p>
                                <a href="receipe-post.php?id=<?php echo $slide['id']; ?>" class="btn delicious-btn" data-animation="fadeInUp" data-delay="1000ms">Lihat Resep</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else { // Tampilkan slide default jika tidak ada resep
            ?>
             <div class="single-hero-slide bg-img" style="background-image: url(img/bg-img/bg1.jpg);">
                <div class="container h-100"><div class="row h-100 align-items-center"><div class="col-12 col-md-9 col-lg-7 col-xl-6"><div class="hero-slides-content" data-animation="fadeInUp" data-delay="100ms"><h2 data-animation="fadeInUp" data-delay="300ms">Resep Lezat Setiap Hari</h2><p data-animation="fadeInUp" data-delay="700ms">Selamat datang di Delicious, temukan inspirasi memasak Anda di sini.</p></div></div></div></div>
            </div>
            <?php } ?>
        </div>
    </section>
    <section class="best-receipe-area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h3>Resep Terbaru</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                    // Query untuk mengambil semua resep dan menampilkannya sebagai kartu
                    $sql = "SELECT id, title, images FROM recipes ORDER BY created_at DESC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $first_image = !empty($row["images"]) ? trim(explode(",", $row["images"])[0]) : 'img/default.jpg';
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
                    <div class="footer-social-info text-right">
                        <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    </div>
                    <div class="footer-logo">
                        <a href="index.php"><img src="img/core-img/logo.png" alt=""></a>
                    </div>
                    <a href="login_admin.html" class="admin-login-button">Login as Admin</a>
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
