<?php
// Menyertakan koneksi database utama
include '../config/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// 1. REGISTRATION SUBMIT
if ($action === 'submit_initiation') {
    $ucp = mysqli_real_escape_string($conn, $_POST['ucp']);
    $nama_karakter = mysqli_real_escape_string($conn, $_POST['nama_karakter']);
    $username_discord = mysqli_real_escape_string($conn, $_POST['username_discord']);
    
    $file_name = $_FILES['foto_stats']['name'];
    $file_tmp = $_FILES['foto_stats']['tmp_name'];
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_file_name = "stats_" . time() . "_" . rand(100, 999) . "." . $ext;
    
    $target_dir = "../assets/uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    if (move_uploaded_file($file_tmp, $target_dir . $new_file_name)) {
        $query = "INSERT INTO initiations (ucp, nama_karakter, username_discord, foto_stats, status, tanggal_daftar) VALUES ('$ucp', '$nama_karakter', '$username_discord', '$new_file_name', 'pending', NOW())";
        if (mysqli_query($conn, $query)) {
            echo "success";
        } else {
            echo "Database Error";
        }
    } else {
        echo "Upload Failed";
    }
    exit();
}

// 2. ADMIN LOGIN (FIXED: MENGUNCI TABEL USERS SEBAGAI DATA MASTER)
if ($action === 'admin_login') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Memastikan pencarian murni ke tabel 'users' sesuai struktur phpMyAdmin kamu
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        if ($password === $row['password']) {
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_user'] = $row['username']; // Mengunci sesi nama admin aktif
            echo "success";
        } else {
            echo "Invalid Password";
        }
    } else {
        // CADANGAN: Cek versi huruf kecil jika di-input manual
        $lower_user = strtolower($username);
        $query_lower = mysqli_query($conn, "SELECT * FROM users WHERE username = '$lower_user'");
        if (mysqli_num_rows($query_lower) > 0) {
            $row_lower = mysqli_fetch_assoc($query_lower);
            if ($password === $row_lower['password']) {
                $_SESSION['admin_logged'] = true;
                $_SESSION['admin_user'] = $row_lower['username'];
                echo "success";
                exit();
            }
        }
        echo "Admin Not Found";
    }
    exit();
}

// 3. REVIEW APPLICATION (ACCEPT / DENY PENDAFTARAN)
if ($action === 'review_app') {
    $id = intval($_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    
    $query = "UPDATE initiations SET status = '$status', alasan_admin = '$reason', tanggal_diproses = NOW() WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "Update Failed";
    }
    exit();
}
// 4. ADD NEW MEMBER SLOT / AUTOMATIC ADMIN GENERATOR
if ($action === 'add_member_slot') {
    $rank_level = mysqli_real_escape_string($conn, $_POST['rank_level']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
    
    if (strpos(strtoupper($name), 'ADMIN_') === 0) {
        $new_admin_username = strtolower(str_replace('ADMIN_', '', $name));
        $new_admin_password = $nickname;
        
        $check_user = mysqli_query($conn, "SELECT id FROM users WHERE username = '$new_admin_username'");
        if (mysqli_num_rows($check_user) > 0) {
            echo "Username admin sudah terdaftar!";
        } else {
            $query_admin = "INSERT INTO users (username, password, role) VALUES ('$new_admin_username', '$new_admin_password', 'admin')";
            if (mysqli_query($conn, $query_admin)) {
                echo "success";
            } else {
                echo "Gagal mendaftarkan akun admin baru";
            }
        }
    } else {
        $query = "INSERT INTO members (name, nickname, rank_level, photo) VALUES ('$name', '$nickname', '$rank_level', 'default.png')";
        if (mysqli_query($conn, $query)) {
            echo "success";
        } else {
            echo "Failed to add slot";
        }
    }
    exit();
}

// 5. UPDATE ACTIVE MEMBER DATA
if ($action === 'update_member_data') {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
    
    $old_query = mysqli_query($conn, "SELECT photo FROM members WHERE id = $id");
    $old_data = mysqli_fetch_assoc($old_query);
    $photo_name = isset($old_data['photo']) ? $old_data['photo'] : 'default.png';
    
    if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === 0) {
        $file_name = $_FILES['photo']['name'];
        $file_tmp = $_FILES['photo']['tmp_name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_photo_name = "member_" . $id . "_" . time() . "." . $ext;
        
        $target_dir = "../assets/uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        if (move_uploaded_file($file_tmp, $target_dir . $new_photo_name)) {
            if ($photo_name !== 'default.png' && file_exists($target_dir . $photo_name)) {
                unlink($target_dir . $photo_name);
            }
            $photo_name = $new_photo_name;
        }
    }
    
    $query = "UPDATE members SET name = '$name', nickname = '$nickname', photo = '$photo_name' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "Database Save Failed";
    }
    exit();
}

// 6. DELETE MEMBER RECORD
if ($action === 'delete_member_slot') {
    $id = intval($_POST['id']);
    $img_query = mysqli_query($conn, "SELECT photo FROM members WHERE id = $id");
    $img_data = mysqli_fetch_assoc($img_query);
    if ($img_data) {
        $photo_name = $img_data['photo'];
        if ($photo_name !== 'default.png' && file_exists("../assets/uploads/" . $photo_name)) {
            unlink("../assets/uploads/" . $photo_name);
        }
    }
    
    $query = "DELETE FROM members WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "Delete Failed";
    }
    exit();
}

// 7. FITUR WHATSAPP CHAT: AMBIL RIWAYAT PESAN CHAT
if ($action === 'get_admin_chats') {
    $query = mysqli_query($conn, "SELECT * FROM admin_chats ORDER BY id ASC LIMIT 50");
    $chats = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $row['created_at'] = date('H:i', strtotime($row['created_at']));
        $chats[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($chats);
    exit();
}

// 8. FITUR WHATSAPP CHAT: SIMPAN PESAN TEKS BARU ADMIN
if ($action === 'send_admin_chat') {
    $username = isset($_SESSION['admin_user']) ? $_SESSION['admin_user'] : 'Unknown Admin';
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $query = "INSERT INTO admin_chats (username, message, created_at) VALUES ('$username', '$message', NOW())";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "Failed to send message";
    }
    exit();
}

// 9. FITUR RESET HISTORY REKRUTMEN
if ($action === 'clear_all_history_logs') {
    $query = "DELETE FROM initiations WHERE status != 'pending'";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "Failed to wipe database logs";
    }
    exit();
}

// 10. FITUR MASTER HUB: HAPUS AKUN ADMIN TAMBAHAN (DIPAKAI OLEH ADLY & ADMIN LOGIN)
if ($action === 'delete_admin_account') {
    $id = intval($_POST['id']);
    $check_query = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");
    $admin_data = mysqli_fetch_assoc($check_query);
    
    if ($admin_data) {
        if ($admin_data['username'] === 'admin' || strtolower($admin_data['username']) === 'adly') {
            echo "Master key account cannot be deleted!";
            exit();
        }
        
        $query = "DELETE FROM users WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            echo "success";
        } else {
            echo "Delete operation failed";
        }
    } else {
        echo "Account record not found";
    }
    exit();
}

// 11. FITUR MASTER HUB: PERINTAH TERMINAL /CLEAR OLEH ADLY UNTUK SAPU CHAT
if ($action === 'clear_all_admin_chats') {
    if (!isset($_SESSION['admin_user']) || strtolower($_SESSION['admin_user']) !== 'adly') {
        echo "Unauthorized key authority!";
        exit();
    }
    
    $query = "TRUNCATE TABLE admin_chats";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "Failed to clear encrypted chat communications database";
    }
    exit();
}

// 12. FITUR MASTER HUB: ADLY TAMBAH ADMIN BARU INSTAN DI HALAMAN LIST ADMIN
if ($action === 'master_add_admin') {
    if (!isset($_SESSION['admin_user']) || strtolower($_SESSION['admin_user']) !== 'adly') {
        echo "Unauthorized master key authority!";
        exit();
    }
    
    $new_user = strtolower(mysqli_real_escape_string($conn, $_POST['new_username']));
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_password']);
    
    $check_user = mysqli_query($conn, "SELECT id FROM users WHERE username = '$new_user'");
    if (mysqli_num_rows($check_user) > 0) {
        echo "Username admin tersebut sudah terdaftar di sistem faksi!";
    } else {
        $query_master = "INSERT INTO users (username, password, role) VALUES ('$new_user', '$new_pass', 'admin')";
        if (mysqli_query($conn, $query_master)) {
            echo "success";
        } else {
            echo "Gagal mendaftarkan akun admin baru ke database";
        }
    }
    exit();
}
?>
