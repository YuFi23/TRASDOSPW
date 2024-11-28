<?php
include 'database.php';

// Fungsi untuk mendapatkan menu berdasarkan ID
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

// Fungsi untuk menambah menu
// Fungsi untuk menambah menu
function createMenu($conn, $nama_menu, $deskripsi, $harga, $kategori, $gambar) {
    $target_dir = "img/";
    // Memastikan $gambar adalah array yang benar
    $target_file = $target_dir . basename($gambar['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek ekstensi file gambar
    if (in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        // Cek apakah gambar berhasil di-upload
        if (move_uploaded_file($gambar['tmp_name'], $target_file)) {
            // Query untuk menambah data menu ke database
            $sql = "INSERT INTO menu (nama_menu, deskripsi, harga, kategori, gambar) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdss", $nama_menu, $deskripsi, $harga, $kategori, $gambar['name']);
            if ($stmt->execute()) {
                header("Location: daftarMenu.php?added=success");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
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

// Fungsi untuk mendapatkan data user
function getUserById($conn, $id) {
    $query = "SELECT * FROM users WHERE id = ?";
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

// Fungsi untuk menambah user
function createUser($conn, $username, $email, $password, $role = 'user', $avatar = null) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (username, email, password, role, avatar) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $email, $hashed_password, $role, $avatar);

    if ($stmt->execute()) {
        header("Location: daftarUsers.php?added=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
