<?php
include('database.php');
include('functions.php');

if (isset($_POST['add'])) {
    $nama_menu = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $gambar = $_FILES['gambar'] ?? null;

    if ($gambar && $gambar['error'] == 0) {
        createMenu($conn, $nama_menu, $deskripsi, $harga, $kategori, $gambar);
    } else {
        echo "Error: No valid image uploaded.";
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_menu = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $gambar = $_FILES['gambar'] ?? null;

    updateMenu($conn, $id, $nama_menu, $deskripsi, $harga, $kategori, $gambar);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    deleteMenu($conn, $id);
}
?>
