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
include 'config/db.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the book by ID
    $sql = "DELETE FROM books WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to view_books page
        header("Location: view_books.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid book ID.";
}
?>
