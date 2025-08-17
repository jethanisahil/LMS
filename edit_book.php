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
include 'includes/header.php';
include 'config/db.php';

// Get book ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing book data
    $sql = "SELECT * FROM books WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found.";
        include 'includes/footer.php';
        exit();
    }
} else {
    echo "Invalid book ID.";
    include 'includes/footer.php';
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title  = $_POST['title'];
    $author = $_POST['author'];
    $genre  = $_POST['genre'];
    $year   = $_POST['year'];

    $update = "UPDATE books SET 
                title='$title', 
                author='$author', 
                genre='$genre', 
                year='$year' 
               WHERE id=$id";

    if ($conn->query($update) === TRUE) {
        header("Location: view_books.php");
        exit();
    } else {
        echo "Error updating book: " . $conn->error;
    }
}
?>

<h2>Edit Book</h2>

<form method="POST" action="">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?= $book['title']; ?>" required><br><br>

    <label>Author:</label><br>
    <input type="text" name="author" value="<?= $book['author']; ?>" required><br><br>

    <label>Genre:</label><br>
    <input type="text" name="genre" value="<?= $book['genre']; ?>"><br><br>

    <label>Year:</label><br>
    <input type="number" name="year" value="<?= $book['year']; ?>"><br><br>

    <input type="submit" value="Update Book">
</form>

<?php include 'includes/footer.php'; ?>
