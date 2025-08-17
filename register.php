<?php
session_start();
include 'config/db.php'; // Assumes your db.php contains connection $conn

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // Validate fields
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } elseif ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    // If no errors, insert into DB
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $username, $email, $hashed);

        if ($stmt->execute()) {
            // Auto login user
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Username or email already exists.";
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header><h1>Register</h1></header>

<div class="container" style="
    padding: 40px;
    max-width: 500px;
    margin: 40px auto;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
">

    <h2 style="text-align: center; color: #333; margin-bottom: 30px;">Register</h2>

    <?php if (!empty($errors)): ?>
        <ul style="color: red; margin-bottom: 20px; padding-left: 20px;">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" style="display: flex; flex-direction: column;">
        <label style="margin-bottom: 5px; color: #555;">Username:</label>
        <input type="text" name="username" required style="
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        ">

        <label style="margin-bottom: 5px; color: #555;">Email:</label>
        <input type="email" name="email" required style="
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        ">

        <label style="margin-bottom: 5px; color: #555;">Password:</label>
        <input type="password" name="password" required style="
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        ">

        <label style="margin-bottom: 5px; color: #555;">Confirm Password:</label>
        <input type="password" name="confirm" required style="
            padding: 10px;
            margin-bottom: 25px;
            border: 1px solid #ccc;
            border-radius: 5px;
        ">

        <input type="submit" value="Register" style="
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        " onmouseover="this.style.backgroundColor='#45a049'" onmouseout="this.style.backgroundColor='#4CAF50'">
    </form>

    <p style="text-align: center; margin-top: 20px; font-size: 14px;">
        Already registered?
        <a href="login.php" style="color: #007BFF; text-decoration: none;">Login</a>
    </p>
</div>


<footer>
    <p>&copy; 2025 Library Management System</p>
</footer>
</body>
</html>