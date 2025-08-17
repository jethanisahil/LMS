<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Management - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <h1>Welcome to the Library Management System</h1>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="view_books.php">Books</a>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="transactions.php">Transactions</a>
        <a href="add_book.php">Add Book</a>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
</nav>

<div class="container" style="
    padding: 30px;
    max-width: 600px;
    margin: 50px auto;
    background: #1e293b;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: white;
">

    <h2 style="text-align: center; color: #f0f0f0; margin-bottom: 25px;">
        Hello, <?= htmlspecialchars($_SESSION['username']); ?>!
    </h2>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <div class="admin-panel" style="
            background-color: #334155;
            padding: 20px;
            border-radius: 8px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        ">
            <h3 style="margin-bottom: 15px; color: #93c5fd;">Admin Panel</h3>
            <ul style="list-style-type: none; padding-left: 0;">
                <li style="margin-bottom: 10px;">
                    <a href="transactions.php" style="
                        text-decoration: none;
                        color: #38bdf8;
                        font-weight: bold;
                        transition: color 0.3s;
                    " onmouseover="this.style.color='#0ea5e9'" onmouseout="this.style.color='#38bdf8'">
                        Manage Transactions
                    </a>
                </li>
                <li>
                    <a href="add_book.php" style="
                        text-decoration: none;
                        color: #38bdf8;
                        font-weight: bold;
                        transition: color 0.3s;
                    " onmouseover="this.style.color='#0ea5e9'" onmouseout="this.style.color='#38bdf8'">
                        Add New Book
                    </a>
                </li>
            </ul>
        </div>
    <?php else: ?>
        <p style="text-align: center; font-size: 16px; color: #e2e8f0;">
            Use the navigation menu above to view available books.
        </p>
    <?php endif; ?>

</div>


<footer>
    <p>&copy; 2025 Library Management System</p>
</footer>

</body>
</html>
