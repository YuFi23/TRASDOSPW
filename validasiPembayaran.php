<?php
include('database.php'); 
session_start();

// Proses validasi pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $concert_id = $_POST['concert_id'];
    $ticket_type = $_POST['ticket_type'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Menyiapkan query SQL untuk memasukkan data ke database
    $stmt = $conn->prepare("INSERT INTO pembayaran (concert_id, ticket_type, name, email, phone, payment_status) VALUES (?, ?, ?, ?, ?, ?)");
    $status = 'Validated'; // Status default setelah validasi
    $stmt->bind_param("isssss", $concert_id, $ticket_type, $name, $email, $phone, $status);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('Pembayaran berhasil divalidasi!');</script>";
        header("Location: success.php"); // Redirect ke halaman sukses
        exit();
    } else {
        echo "<script>alert('Gagal memvalidasi pembayaran.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Pembayaran</title>
    <link rel="stylesheet" href="validasi.css">
</head>
<body>
    <div class="container">
        <h1>Validasi Pembayaran</h1>
        <p>Data pembayaran Anda sedang diproses. Silakan tunggu...</p>
    </div>
</body>
</html>
