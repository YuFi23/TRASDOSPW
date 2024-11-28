<?php 
include('database.php'); 
include('functions.php');

if (isset($_POST['add'])) {
   
    $nama_menu = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori']; 
    
    
  
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $gambar = $_FILES['gambar'];

   
    $target_dir = "img/"; 
    $target_file = $target_dir . basename($gambar["name"]);
    move_uploaded_file($gambar["tmp_name"], $target_file);

    
    createMenu($conn, $nama_menu, $deskripsi, $harga, $kategori, $gambar["name"]);
} else {
    echo "Error: Tidak ada gambar yang di-upload.";
}

}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_menu = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $gambar = null;

   
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar'];

        
        $target_dir = "img/"; 
        $target_file = $target_dir . basename($gambar["name"]);
        move_uploaded_file($gambar["tmp_name"], $target_file);
    }


    updateMenu($conn, $id, $nama_menu, $deskripsi, $harga, $kategori, $gambar ? $gambar["name"] : null);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    deleteMenu($conn, $id);
}
?>
