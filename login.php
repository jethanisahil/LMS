<?php
session_start();
include 'config/db.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $errors[] = "Please enter both username and password.";
    } else {
        // Secure query using prepared statements
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $db_username, $db_password, $role);
            $stmt->fetch();

            if (password_verify($password, $db_password)) {
                // Correct password
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $db_username;
                $_SESSION['role'] = $role;
                header("Location: index.php");
                exit();
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "No user found with that username.";
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header><h1>Login</h1></header>
<div class="container" style="padding: 40px; max-width: 400px; margin: 50px auto; background: #f9f9f9; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.2); font-family: Arial, sans-serif;">
    <h2 style="text-align:center; color: #333; margin-bottom: 20px;">Library Management System Login</h2>

    <?php if (!empty($errors)): ?>
        <ul style="color:red; padding-left: 20px;">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" style="display: flex; flex-direction: column;">
        <label style="margin-bottom: 5px; color: #555;">Username:</label>
        <input type="text" name="username" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 20px;">

        <label style="margin-bottom: 5px; color: #555;">Password:</label>
        <input type="password" name="password" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 25px;">

        <input type="submit" value="Login" style="padding: 12px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background 0.3s;">
    </form>

    <p style="text-align:center; margin-top: 20px; font-size: 14px;">Don't have an account? <a href="register.php" style="color: #007BFF; text-decoration: none;">Register</a></p>
</div>


<footer>
    <p>&copy; 2025 Library Management System</p>
</footer>
</body>
</html>