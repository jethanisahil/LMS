<!-- <?php if ($_SESSION['role'] == 'admin'): ?>
    <td>
        <a href="edit_book.php?id=<?= $row['id']; ?>">Edit</a> | 
        <a href="delete_book.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
    </td>
<?php endif; ?> -->

<?php
include 'includes/header.php';
include 'config/db.php';

// Fetch all books
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<h2>All Books</h2>

<?php if ($result->num_rows > 0): ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Year</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row["id"]; ?></td>
            <td><?= $row["title"]; ?></td>
            <td><?= $row["author"]; ?></td>
            <td><?= $row["genre"]; ?></td>
            <td><?= $row["year"]; ?></td>
        <td>
    <a href="edit_book.php?id=<?= $row['id']; ?>">Edit</a> | 
    <a href="delete_book.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
</td>
    <td>
    <form action="issue_return.php" method="POST" style="display:inline;">
        <input type="hidden" name="book_id" value="<?= $row['id']; ?>">
        <input type="hidden" name="action" value="issued">
        <input type="submit" value="Issue">
    </form>

    <form action="issue_return.php" method="POST" style="display:inline;">
        <input type="hidden" name="book_id" value="<?= $row['id']; ?>">
        <input type="hidden" name="action" value="returned">
        <input type="submit" value="Return">
    </form>
</td>
</tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No books found.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
