<?php
include('database.php');
session_start();

// Check if the user is logged in and is a 'user' role
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit();
}

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the order items if they were submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['menu_id'])) {
    $menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : '';
    $menu_name = isset($_POST['menu_name']) ? $_POST['menu_name'] : '';
    $menu_price = isset($_POST['menu_price']) ? $_POST['menu_price'] : 0;
    $quantity = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;

    $menu_price = is_numeric($menu_price) && $menu_price > 0 ? $menu_price : 0;

    $_SESSION['order_items'][] = [
        'id' => $menu_id,
        'name' => $menu_name,
        'price' => $menu_price,
        'quantity' => $quantity,
    ];
}

// Delete or update the item
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['index'])) {
    $index = $_GET['index'];
    unset($_SESSION['order_items'][$index]);
    header('Location: pesen.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['index']) && isset($_GET['quantity'])) {
    $index = $_GET['index'];
    $quantity = (int)$_GET['quantity'];

    if ($quantity > 0) {
        $_SESSION['order_items'][$index]['quantity'] = $quantity;
    }
    header('Location: pesen.php');
    exit();
}

// Retrieve the order items from session
$order_items = isset($_SESSION['order_items']) ? $_SESSION['order_items'] : [];
$total_price = 0;
foreach ($order_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Initialize success flags
$payment_success = false;
$reservation_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_method']) && isset($_POST['user_name']) && isset($_POST['table_number'])) {
    $payment_method = $_POST['payment_method'];
    $user_name = htmlspecialchars($_POST['user_name']);
    $table_number = (int)$_POST['table_number'];

    // Insert the reservation into the table_reservations table
    $stmt = $conn->prepare("INSERT INTO table_reservations (user_name, table_number) VALUES (?, ?)");
    $stmt->bind_param("si", $user_name, $table_number);

    if ($stmt->execute()) {
        $reservation_success = true;

        // Process the order details (including name, menu, table number, etc.)
        foreach ($order_items as $item) {
            $stmt = $conn->prepare("INSERT INTO pesanan (nama_pelanggan, nama_menu, nomor_meja, jumlah) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $user_name, $item['name'], $table_number, $item['quantity']);

            if (!$stmt->execute()) {
                $order_error = $stmt->error;
            }
        }

        // Clean up the order session after the purchase is processed
        unset($_SESSION['order_items']);

        // Redirect to refresh the page and avoid resubmission
        header('Location: pesen.php');
        exit();
    } else {
        $reservation_error = $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Pembayaran - Cafe YAHM</title>
    <link rel="stylesheet" href="pesen.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="merk">YAHM</div>
        <ul class="nav-links">
            <li><a href="home.php">HOME</a></li>
            <li><a href="about.php">ABOUT US</a></li>
            <li><a href="contact.php">CONTACT US</a></li>
            <?php if (isset($_SESSION['email'])): ?>
                <li class="user-avatarr">
                    <img src="img/<?php echo isset($_SESSION['avatar']) ? $_SESSION['avatar'] : 'avatar.png'; ?>" alt="Avatar">
                    <div class="dropdown-menu">
                        <p><?php echo $_SESSION['username']; ?></p>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="login.php">LOGIN</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Content Section -->
    <div class="container">
        <h1>Rincian Pembayaran</h1>

        <!-- Order Summary -->
        <div class="order-summary">
            <h2>Order Summary</h2>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($order_items)): ?>
                    <tr>
                        <td colspan="4">No items in your order.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($order_items as $index => $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td>
                                <form action="pesen.php" method="GET">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                            <td>Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="pesen.php?action=delete&index=<?php echo $index; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2">Total</td>
                            <td>Rp <?php echo number_format($total_price, 0, ',', '.'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

<!-- Buy Again Button Section -->
<div class="buy-again-section">
    <form action="buy.php" method="POST">
        <button type="submit" name="buy_again" value="true" class="buy-again-button">Buy Again</button>
    </form>
</div>

<!-- Table Reservation and Payment Section -->
<div class="reservation-section">
    <h2>Reserve a Table & Pay</h2>
    <form action="pesen.php" method="POST" class="reservation-form">
        <div class="form-group">
            <label for="user_name">Name:</label>
            <input type="text" id="user_name" name="user_name" required>
        </div>

        <div class="form-group">
            <label for="table_number">Table Number:</label>
            <input type="number" id="table_number" name="table_number" required>
        </div>

        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="qris">QRIS</option>
                <option value="credit_card">Credit Card</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="submit-button">Submit Reservation and Payment</button>
        </div>
    </form>
</div>


        <?php if (isset($reservation_success) && $reservation_success): ?>
        <div class="success-message">
            <p>Table reserved and payment successful!</p>
        </div>
        <?php elseif (isset($reservation_error)): ?>
        <div class="error-message">
            <p>Error: <?php echo $reservation_error; ?></p>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>
