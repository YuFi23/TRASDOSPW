<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YAHM</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <nav class="navbar">
        <div class="merk">YAHM</div>
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>
        <ul class="nav-links">
            <li><a href="home.php">HOME</a></li>
            <li><a href="about.php">ABOUT US</a></li>
            <li><a href="contact.php">CONTACT US</a></li>
            <?php if (isset($_SESSION['email'])): ?>
                <li class="user-avatarr">
                    <img src="img/<?php echo isset($_SESSION['avatar']) ? $_SESSION['avatar'] : 'avatar.png'; ?>" alt="Avatar" class="avatarr" id="avatar">
                    <div class="dropdown-menu" id="dropdown-menu">
                        <p class="user-name"><?php echo $_SESSION['username']; ?></p>
                        <a href="logout.php" class="logout">Logout</a>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="login.php">LOGIN</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <h1 class="welcome">WELCOME TO YAHM</h1>
    <img src="img/logo.png" class="logo3" alt="Encore Shield Logo" />
    <div class="order-container">
        <a class="order" href="buy.php">ORDER NOW!</a>
    </div>

    <div class="container card-container section">
        <div class="card">
            <div class="avatar"><img src="img/yerky.jpg" alt="Avatar"></div>
            <h2>Yerky</h2>
            <p>672023186</p>
        </div>
        <div class="card">
            <div class="avatar"><img src="img/praditya.jpg" alt="Avatar"></div>
            <h2>Praditya</h2>
            <p>672023088</p>
        </div>
        <div class="card">
            <div class="avatar"><img src="img/hana.jpg" alt="Avatar"></div>
            <h2>Hana</h2>
            <p>672023004</p>
        </div>
        <div class="card">
            <div class="avatar"><img src="img/mattia.jpg" alt="Avatar"></div>
            <h2>Mattia</h2>
            <p>672023005</p>
        </div>
    </div>

    <div class="container">
        <section class="about-section section">
            <p>
            Selamat datang di Yahm Cafe, Kami berkomitmen untuk menyajikan hidangan lezat yang tidak hanya memuaskan selera, tetapi juga menciptakan pengalaman bersantap yang tak terlupakan. Dengan menggunakan bahan-bahan segar dan berkualitas tinggi, setiap menu kami dirancang untuk memberikan kenikmatan maksimal. Dari sarapan yang mengenyangkan hingga hidangan penutup yang menggoda, kami berusaha menjadikan setiap kunjungan Anda istimewa.

            Yahm Cafe didirikan oleh sekelompok pecinta kuliner yang ingin berbagi kecintaan mereka terhadap makanan enak dalam suasana yang hangat dan ramah. Kami percaya bahwa makanan adalah tentang kebersamaan dan pengalaman. Kami mengundang Anda untuk bergabung dengan kami, baik untuk bersantai dengan teman, berkumpul dengan keluarga, atau menikmati momen sendiri. Terima kasih telah mengunjungi halaman tentang kami, dan kami berharap dapat menyambut Anda di Yahm Cafe!
            </p>
        </section>
    </div>
</body>
<script src="home.js"></script>
</html>
