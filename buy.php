<?php
include('database.php');
session_start();

// Query untuk mengambil data dari tabel menu
$result = $conn->query("SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Cafe YAHM</title>
    <link rel="stylesheet" href="buy.css">
</head>
<body>
    <nav class="navbar">
        <div class="merk">Cafe YAHM</div>
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

    <div class="container">
        <h1>Our Menu</h1>
        <div class="menu-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="menu-card">
                    <!-- Menampilkan gambar menu -->
                    <img src="img/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_menu']; ?>" />
                    <h3><?php echo $row['nama_menu']; ?></h3>
                    <p><?php echo $row['deskripsi']; ?></p>
                    <p><strong>Price: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></strong></p>
                    <p><strong>Category: <?php echo ucfirst($row['kategori']); ?></strong></p>
                    <form action="order.php" method="POST">
                        <input type="hidden" name="menu_id" value="<?php echo $row['id']; ?>">
                        <label for="jumlah">Quantity:</label>
                        <input type="number" name="jumlah" id="jumlah" min="1" value="1" required>
                        <button type="submit">
                            <span>Order Now</span>
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
<script src="home.js"></script>
</html>
