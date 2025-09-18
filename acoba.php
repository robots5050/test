<?php
session_start();

// Hash password yang kamu kasih
$stored_hash = '$2y$10$RBixSEJlKQeOGHkdB./pvOkrafivXc2O4h8ChjLLWL01GwKPDzlBy';

// Jika sudah login, langsung ke home
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: home.php");
    exit;
}

// Tangani submit form
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Misalnya usernamenya "admin"
    if ($username === 'admin' && password_verify($password, $stored_hash)) {
        $_SESSION['logged_in'] = true;
        header("Location: home.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login GUI</title>
    <style>
        body {
            margin:0; padding:0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        .login-box {
            background:#fff;
            border-radius:12px;
            box-shadow:0 5px 20px rgba(0,0,0,.3);
            padding:40px;
            width:320px;
            text-align:center;
        }
        .login-box h2 {
            margin-bottom:20px;
            color:#333;
        }
        .login-box input[type=text],
        .login-box input[type=password] {
            width:100%;
            padding:12px;
            margin:8px 0;
            border:1px solid #ccc;
            border-radius:6px;
            box-sizing:border-box;
        }
        .login-box input[type=submit] {
            width:100%;
            padding:12px;
            background:#667eea;
            border:none;
            color:#fff;
            font-weight:bold;
            border-radius:6px;
            cursor:pointer;
            transition:0.3s;
        }
        .login-box input[type=submit]:hover {
            background:#764ba2;
        }
        .error {
            color:red;
            margin-top:10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
