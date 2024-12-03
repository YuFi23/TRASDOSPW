<?php
include 'database.php';

function createMenu($conn, $nama_menu, $deskripsi, $harga, $kategori, $gambar) {
    if (!empty($gambar) && is_array($gambar) && isset($gambar['tmp_name']) && $gambar['error'] == 0) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($gambar['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        if (!in_array($imageFileType, $allowed_types)) {
            echo "Error: Only JPG, JPEG, PNG, & GIF files are allowed.";
            return;
        }

        if (!is_writable($target_dir)) {
            echo "Error: The target directory is not writable.";
            return;
        }

        if (move_uploaded_file($gambar['tmp_name'], $target_file)) {
            $sql = "INSERT INTO menu (nama_menu, deskripsi, harga, kategori, gambar) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdss", $nama_menu, $deskripsi, $harga, $kategori, $gambar['name']);

            if ($stmt->execute()) {
                header("Location: daftarMenu.php?added=success");
                exit();
            } else {
                echo "Database error: " . $conn->error;
            }
        } else {
            echo "Error: There was an issue uploading your file.";
        }
    } else {
        echo "Error: Invalid image file or no image uploaded.";
    }
}

function getMenuById($conn, $id) {
    $query = "SELECT * FROM menu WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0 ? $result->fetch_assoc() : null;
}

function updateMenu($conn, $id, $nama_menu, $deskripsi, $harga, $kategori, $gambar) {
    if (!empty($gambar) && is_array($gambar) && $gambar['error'] == 0) {
        $old_image_query = "SELECT gambar FROM menu WHERE id = ?";
        $stmt = $conn->prepare($old_image_query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!empty($row['gambar'])) {
            unlink("img/" . $row['gambar']);
        }

        $target_dir = "img/";
        $target_file = $target_dir . basename($gambar['name']);
        move_uploaded_file($gambar['tmp_name'], $target_file);
        $new_image = $gambar['name'];

        $sql = "UPDATE menu SET nama_menu = ?, deskripsi = ?, harga = ?, kategori = ?, gambar = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdssi", $nama_menu, $deskripsi, $harga, $kategori, $new_image, $id);
    } else {
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

function deleteMenu($conn, $id) {
    $sql = "SELECT gambar FROM menu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!empty($row['gambar'])) {
        unlink("img/" . $row['gambar']);
    }

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
