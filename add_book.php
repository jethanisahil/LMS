<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Only allow admin
if ($_SESSION['role'] != 'admin') {
    echo "Access denied. Admins only.";
    exit();
}

include 'includes/header.php';
include 'config/db.php';
?>

<?php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];

    // Insert into database
    $sql = "INSERT INTO books (title, author, genre, year) 
            VALUES ('$title', '$author', '$genre', '$year')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Book added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<div style="
    max-width: 600px;
    margin: 50px auto;
    padding: 30px;
    background-color: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
">
    <h2 style="
        text-align: center;
        color: #2c3e50;
        margin-bottom: 30px;
    ">Add a New Book</h2>

    <form method="POST" action="" style="display: flex; flex-direction: column; gap: 20px;">
        <div>
            <label style="font-weight: bold; color: #333;">Title:</label><br>
            <input type="text" name="title" required style="
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 14px;
            ">
        </div>

        <div>
            <label style="font-weight: bold; color: #333;">Author:</label><br>
            <input type="text" name="author" required style="
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 14px;
            ">
        </div>

        <div>
            <label style="font-weight: bold; color: #333;">Genre:</label><br>
            <input type="text" name="genre" style="
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 14px;
            ">
        </div>

        <div>
            <label style="font-weight: bold; color: #333;">Year:</label><br>
            <input type="number" name="year" style="
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 14px;
            ">
        </div>

        <input type="submit" value="Add Book" style="
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        " onmouseover="this.style.backgroundColor='#45a049'" onmouseout="this.style.backgroundColor='#4CAF50'">
    </form>
</div>


<?php include 'includes/footer.php'; ?>
