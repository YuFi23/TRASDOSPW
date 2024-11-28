<?php 
include('database.php'); 
include('functions.php'); 

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
    <title>Daftar Menu</title>
    <link rel="stylesheet" href="DaftarMenu.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>ADMIN</h2>
            <ul>
                <li><a href="DataPelanggan.php">Data Akun</a></li>
                <li><a href="DaftarPesanan.php">Daftar Pesanan</a></li>
                <li><a href="DaftarMenu.php" class="active">Daftar Menu</a></li>
            </ul>
            <a href="DataPelanggan.php?logout=true" class="logout-btn">Logout</a>
        </div>
        <div class="main-content">
            <h1>Daftar Menu</h1>

            <!-- Form untuk Menambah Menu -->
            <form method="POST" action="process.php" enctype="multipart/form-data" class="form-crud">
                <input type="text" name="nama_menu" placeholder="Nama Menu" required>
                <input type="text" name="deskripsi" placeholder="Deskripsi" required>
                <input type="number" step="0.01" name="harga" placeholder="Harga" required>
                <select name="kategori" required>
                    <option value="makanan">Makanan</option>
                    <option value="minuman">Minuman</option>
                    <option value="snack">Snack</option>
                </select>
                <input type="file" name="gambar" accept="image/*" required>
                <button type="submit" name="add">Tambah Menu</button>
            </form>


            <!-- Tabel Daftar Menu -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Menu</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM menu");
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nama_menu']}</td>
                            <td>{$row['deskripsi']}</td>
                            <td>{$row['harga']}</td>
                            <td><img src='img/{$row['gambar']}' width='100'></td>
                            <td>
                                <a href='DaftarMenu.php?edit={$row['id']}'>Edit</a> |
                                <a href='process.php?delete={$row['id']}'>Hapus</a>
                            </td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Form Edit Menu -->
            <?php if (isset($_GET['edit'])): 
                $id = $_GET['edit'];
                $edit_data = getMenuById($conn, $id);
                if ($edit_data):
            ?>
                <form method="POST" action="process.php" enctype="multipart/form-data" class="form-crud">
                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                    <input type="text" name="nama_menu" value="<?php echo $edit_data['nama_menu']; ?>" required>
                    <input type="text" name="deskripsi" value="<?php echo $edit_data['deskripsi']; ?>" required>
                    <input type="number" step="0.01" name="harga" value="<?php echo $edit_data['harga']; ?>" required>
                    <select name="kategori" required>
                        <option value="makanan" <?php if ($edit_data['kategori'] == 'makanan') echo 'selected'; ?>>Makanan</option>
                        <option value="minuman" <?php if ($edit_data['kategori'] == 'minuman') echo 'selected'; ?>>Minuman</option>
                        <option value="snack" <?php if ($edit_data['kategori'] == 'snack') echo 'selected'; ?>>Snack</option>
                    </select>

                    <?php if (!empty($edit_data['gambar'])): ?>
                        <label>Gambar Saat Ini:</label>
                        <img src="img/<?php echo $edit_data['gambar']; ?>" alt="Gambar Menu" width="100">
                    <?php else: ?>
                        <p>Tidak ada gambar saat ini.</p>
                    <?php endif; ?>

                    <input type="file" name="gambar" accept="image/*"> <!-- Input untuk gambar baru -->
                    <button type="submit" name="update">Update</button>
                </form>
            <?php else: ?>
                <p>Data Menu tidak ditemukan.</p>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
