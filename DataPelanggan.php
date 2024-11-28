<?php
include('database.php');
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}


$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM akun WHERE id = $id");
    $editData = $result->fetch_assoc();
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $conn->query("UPDATE akun SET username = '$username', email = '$email', role = '$role' WHERE id = $id");
    header("Location: DataPelanggan.php");
    exit();
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM akun WHERE id = $id");
    header("Location: DataPelanggan.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Akun</title>
    <link rel="stylesheet" href="DataPelanggan.css">
</head>
<body>
<div class="container">
    <div class="sidebar">
        <h2>ADMIN</h2>
        <ul>
            <li><a href="DataPelanggan.php" class="active">Data Akun</a></li>
            <li><a href="DaftarPesanan.php">Daftar Pesanan</a></li>
            <li><a href="DaftarMenu.php">Daftar Menu</a></li>
        </ul>
        <a href="DataPelanggan.php?logout=true" class="logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <h1>Data Akun</h1>


        <?php if ($editData): ?>
        <form method="POST" class="edit-form">
            <h2>Edit Akun</h2>
            <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo $editData['username']; ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $editData['email']; ?>" required>
            <label>Role:</label>
            <select name="role" required>
                <option value="admin" <?php echo ($editData['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="user" <?php echo ($editData['role'] === 'user') ? 'selected' : ''; ?>>User</option>
            </select>
            <button type="submit" name="update">Update</button>
        </form>
        <?php endif; ?>


        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM users");
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['role']}</td>
                            <td>
                                <a href='DataPelanggan.php?edit={$row['id']}'>Edit</a> |
                                <a href='DataPelanggan.php?delete={$row['id']}' onclick='return confirm(\"Yakin ingin menghapus akun ini?\");'>Hapus</a>
                            </td>
                        </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
