<?php
include 'database.php';

function createMenu($conn, $nama_menu, $deskripsi, $harga, $kategori, $gambar) {
    // Pastikan gambar yang diterima adalah array dari $_FILES
    if (isset($gambar) && is_array($gambar) && $gambar['error'] == 0) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($gambar['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek ekstensi file gambar
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            return;
        }

        // Memastikan direktori tujuan dapat ditulis
        if (!is_writable($target_dir)) {
            echo "The target directory is not writable.";
            return;
        }

        // Cek apakah file berhasil di-upload
        if (move_uploaded_file($gambar['tmp_name'], $target_file)) {
            // Query untuk menambah menu ke database
            $sql = "INSERT INTO menu (nama_menu, deskripsi, harga, kategori, gambar) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdss", $nama_menu, $deskripsi, $harga, $kategori, $gambar['name']);
            
            // Eksekusi query
            if ($stmt->execute()) {
                header("Location: daftarMenu.php?added=success");
                exit();
            } else {
                echo "Database error: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file. Error code: " . $gambar['error'];
        }
    } else {
        echo "Invalid image file or no image uploaded. Error code: " . $gambar['error'];
    }
}

// Fungsi untuk mendapatkan data menu berdasarkan ID
function getMenuById($conn, $id) {
    $query = "SELECT * FROM menu WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Fungsi untuk memperbarui menu
function updateMenu($conn, $id, $nama_menu, $deskripsi, $harga, $kategori, $gambar) {
    // Jika gambar baru di-upload
    if ($gambar["error"] == 0) {
        // Ambil data gambar lama sebelum update
        $old_image_query = "SELECT gambar FROM menu WHERE id = ?";
        $stmt = $conn->prepare($old_image_query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $old_image = $row['gambar'];

        // Hapus gambar lama dari folder img jika ada gambar baru
        if ($old_image) {
            unlink("img/" . $old_image); // Menghapus file gambar lama
        }

        // Upload gambar baru
        $target_dir = "img/";
        $target_file = $target_dir . basename($gambar["name"]);
        move_uploaded_file($gambar["tmp_name"], $target_file);
        $new_image = $gambar["name"];

        // Query untuk memperbarui menu
        $sql = "UPDATE menu SET nama_menu = ?, deskripsi = ?, harga = ?, kategori = ?, gambar = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdssi", $nama_menu, $deskripsi, $harga, $kategori, $new_image, $id);
    } else {
        // Jika tidak ada gambar baru, hanya update data lainnya
        $sql = "UPDATE menu SET nama_menu = ?, deskripsi = ?, harga = ?, kategori = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsi", $nama_menu, $deskripsi, $harga, $kategori, $id);
    }

    if ($stmt->execute()) {
        header("Location: daftarMenu.php?updated=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fungsi untuk menghapus menu
function deleteMenu($conn, $id) {
    // Ambil nama gambar menu yang akan dihapus
    $sql = "SELECT gambar FROM menu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $gambar = $row['gambar'];

    // Hapus file gambar jika ada
    if ($gambar) {
        unlink("img/" . $gambar); // Menghapus file gambar
    }

    // Hapus data menu dari database
    $sql = "DELETE FROM menu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: daftarMenu.php?deleted=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
