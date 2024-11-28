<?php
include('database.php');

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>
    <link rel="stylesheet" href="DaftarPesanan.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>ADMIN</h2>
            <ul>
                <li><a href="DataPelanggan.php">Data Akun</a></li>
                <li><a href="DaftarPesanan.php" class="active">Daftar Pesanan</a></li>
                <li><a href="DaftarMenu.php">Daftar Menu</a></li>
            </ul>
            <a href="DataPelanggan.php?logout=true" class="logout-btn">Logout</a>
        </div>
        <div class="main-content">
            <h1>Daftar Pesanan</h1>
            <table>
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>Nama Menu</th>
                        <th>Nomor Meja</th>
                        <th>Jumlah Pesanan</th>
                        <th>Tanggal Pesan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "
                        SELECT 
                            pesanan.nama_pelanggan, 
                            pesanan.nama_menu, 
                            pesanan.nomor_meja, 
                            pesanan.jumlah, 
                            pesanan.created_at AS tanggal_pesan
                        FROM pesanan
                    ";

                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['nama_pelanggan']}</td>
                                    <td>{$row['nama_menu']}</td>
                                    <td>{$row['nomor_meja']}</td>
                                    <td>{$row['jumlah']}</td>
                                    <td>{$row['tanggal_pesan']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Belum ada pesanan yang terdaftar.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
