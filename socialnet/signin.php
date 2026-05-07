<?php
session_start();
require_once 'db.php';
if (isset($_SESSION['user_id'])) {
	echo "<script>window.location.href='index.php';</script>";
	exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $u_input = $_POST['username'];
        $p_input = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM account WHERE username = ?");
        $stmt->execute([$u_input]);
        $user = $stmt->fetch();

        if ($user && password_verify($p_input, $user['password'])) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            header("Location: index.php");
            exit;
        } else {
            $error = "ACCESS DENIED. INVALID CREDENTIALS.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>LOGIN</title>
</head>
<body>
<div class="container" style="margin-top:150px; text-align: center;">
    <h2 style="letter-spacing: 5px; font-weight: 400;">LOGIN</h2>
    
    <?php if ($error): ?>
        <div style="color: #ff0000; font-weight: bold; margin-bottom: 20px; font-size: 0.8em; letter-spacing: 1px;">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="signin.php">
        <div style="margin-bottom: 15px;">
            <input type="text" name="username" placeholder="USERNAME" required style="width: 100%;">
        </div>
        <div style="margin-bottom: 25px;">
            <input type="password" name="password" placeholder="PASSWORD" required style="width: 100%;">
        </div>
        <button type="submit" style="width: 100%; letter-spacing: 2px;">ENTER SYSTEM</button>
    </form>
</div>
</body>
</html>
