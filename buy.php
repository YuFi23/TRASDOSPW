<?php
include('database.php');
session_start();

// Query untuk mendapatkan semua data menu
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

    <div class="container">
        <h1>Our Menu</h1>
        <div class="menu-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                // Validasi harga untuk memastikan nilai valid
                $price = is_numeric($row['harga']) && $row['harga'] > 0 ? $row['harga'] : 0;
                ?>
                <div class="menu-card">
                    <img src="img/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_menu']; ?>" />
                    <h3><?php echo $row['nama_menu']; ?></h3>
                    <p><?php echo $row['deskripsi']; ?></p>
                    <p><strong>Price: Rp <?php echo number_format($price, 0, ',', '.'); ?></strong></p>
                    <form action="pesen.php" method="POST" class="order-form">
                        <input type="hidden" name="menu_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="menu_name" value="<?php echo $row['nama_menu']; ?>">
                        <input type="hidden" name="menu_price" value="<?php echo $price; ?>">
                        <label for="jumlah_<?php echo $row['id']; ?>">Quantity:</label>
                        <input type="number" name="jumlah" id="jumlah_<?php echo $row['id']; ?>" class="quantity-input" data-price="<?php echo $price; ?>" min="1" value="1" required>
                        <p><strong>Total: Rp <span id="total_price_<?php echo $row['id']; ?>"><?php echo number_format($price, 0, ',', '.'); ?></span></strong></p>
                        <button type="submit" class="order-button">
                            <span>Order Now</span>
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        // Script untuk menghitung total harga secara dinamis
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', function() {
                const price = parseInt(this.dataset.price, 10);
                const quantity = parseInt(this.value, 10) || 1; // Default ke 1 jika kosong
                const totalPrice = price * quantity;

                // Update total harga di elemen terkait
                const totalPriceElement = document.querySelector(`#total_price_${this.id.split('_')[1]}`);
                totalPriceElement.textContent = totalPrice.toLocaleString('id-ID');
            });
        });
    </script>
</body>
</html>
