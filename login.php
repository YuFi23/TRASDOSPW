<?php
session_start();
include 'database.php'; 

$login_error = '';
$signup_error = '';

// Proses Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
 
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];  
            $_SESSION['username'] = $user['username'];  
            $_SESSION['avatar'] = $user['avatar']; 

            // Redirect berdasarkan peran pengguna
            if ($user['role'] == 'admin') {
                header("Location: DataPelanggan.php"); 
            } elseif ($user['role'] == 'user') {
                header("Location: home.php"); 
            } else {
                header("Location: home3.php"); 
            }
            exit();
        } else {
            $login_error = "Password salah!";
        }
    } else {
        $login_error = "Email tidak ditemukan!";
    }
}

// Proses Signup
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        $signup_error = "Password dan konfirmasi password tidak cocok!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Set role default sebagai 'user'
        $role = 'user'; 
        
        // Cek apakah email sudah terdaftar
        $check_email = "SELECT * FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($check_email);
        $stmt_check->bind_param('s', $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $signup_error = "Email sudah terdaftar!";
        } else {
            // Menambah pengguna baru
            $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $username, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                header("Location: login.php?status=registered"); 
                exit();
            } else {
                $signup_error = "Terjadi kesalahan saat mendaftar: " . $conn->error;
            }
        }
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php"); 
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-image: url("img/utama.jpg");
        background-size: cover;
        background-position: center;
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-container {
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    .form-container h2 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .form-container input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .form-container button {
        width: 100%;
        background-color: #823b00;
        color: white;
        border: none;
        padding: 10px 15px;
        margin-top: 15px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .form-container button:hover {
        background-color: #db7304;
    }

    .form-container .error-message {
        color: red;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .form-container hr {
        margin: 20px 0;
        border: 0.5px solid #ddd;
    }

    .toggle-link {
        display: inline-block;
        margin-top: 10px;
        color: #aa4404;
        text-decoration: none;
        font-size: 14px;
    }

    .toggle-link:hover {
        text-decoration: underline;
    }

    /* Kontainer utama */
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        max-width: 100%;
    }

    /* Tombol Logout */
    .btn-danger {
        margin-top: 20px;
        width: auto;
    }

    /* Form login dan signup di tengah */
    #login-form, #signup-form {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }
</style>
</head>
<body>

<?php if (isset($_SESSION['username'])): ?>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <img src="<?php echo $_SESSION['avatar']; ?>" alt="Avatar" width="100" height="100">
        <p>You are logged in as <?php echo $_SESSION['role']; ?>.</p>
        
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="DataPelanggan.php" class="btn btn-primary">Admin Panel</a>
        <?php elseif ($_SESSION['role'] == 'user'): ?>
            <a href="home.php" class="btn btn-primary">User Dashboard</a>
        <?php else: ?>
            <a href="home3.php" class="btn btn-primary">Other Role Dashboard</a>
        <?php endif; ?>

        <a href="?logout=true" class="btn btn-danger">Logout</a>
    </div>
<?php else: ?>
    <!-- Form Login -->
    <div class="form-container">
        <div id="login-form">
            <h2>Login</h2>
            <?php if (!empty($login_error)): ?>
                <div class="error-message"><?php echo $login_error; ?></div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <a href="#" class="toggle-link" onclick="toggleForms('signup')">Don't have an account? Sign Up</a>
        </div>

        <!-- Form Sign Up -->
        <div id="signup-form" style="display: none;">
            <h2>Sign Up</h2>
            <?php if (!empty($signup_error)): ?>
                <div class="error-message"><?php echo $signup_error; ?></div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit" name="signup">Sign Up</button>
            </form>
            <a href="#" class="toggle-link" onclick="toggleForms('login')">Already have an account? Login</a>
        </div>
    </div>
<?php endif; ?>

<script>
    function toggleForms(form) {
        const loginForm = document.getElementById('login-form');
        const signupForm = document.getElementById('signup-form');

        if (form === 'signup') {
            loginForm.style.display = 'none';
            signupForm.style.display = 'block';
        } else if (form === 'login') {
            loginForm.style.display = 'block';
            signupForm.style.display = 'none';
        }
    }
</script>

</body>
</html>
