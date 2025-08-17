<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];
    $action = $_POST['action'];

    // Validate action
    if ($action === 'issued') {
        // Directly insert issue record
        $stmt = $conn->prepare("INSERT INTO transactions (user_id, book_id, action) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $book_id, $action);

        if ($stmt->execute()) {
            header("Location: view_books.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

    } elseif ($action === 'returned') {
        // Check if the book has been issued and not yet returned
        $checkStmt = $conn->prepare("
            SELECT COUNT(*) 
            FROM transactions 
            WHERE user_id = ? AND book_id = ? AND action = 'issued'
            AND NOT EXISTS (
                SELECT 1 FROM transactions 
                WHERE user_id = ? AND book_id = ? AND action = 'returned'
            )
        ");
        $checkStmt->bind_param("iiii", $user_id, $book_id, $user_id, $book_id);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            // Allow return
            $stmt = $conn->prepare("INSERT INTO transactions (user_id, book_id, action) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user_id, $book_id, $action);

            if ($stmt->execute()) {
                header("Location: view_books.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Book not issued, cannot return.";
        }
    } else {
        echo "Invalid action.";
    }
} else {
    echo "Invalid request method.";
}
?>
