<?php
session_start();

// Allow only logged-in admins
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';  // Optional: your HTML head/nav
include 'config/db.php';        // Make sure this file exists and connects to DB

// Query transaction records
$sql = "SELECT t.id, u.username, b.title, t.action, t.action_date 
        FROM transactions t
        JOIN users u ON t.user_id = u.id
        JOIN books b ON t.book_id = b.id
        ORDER BY t.action_date DESC";

$result = $conn->query($sql);

// Handle query error
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<h2>Transaction Logs</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Book</th>
        <th>Action</th>
        <th>Date</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= htmlspecialchars($row['username']); ?></td>
        <td><?= htmlspecialchars($row['title']); ?></td>
        <td><?= ucfirst($row['action']); ?></td>
        <td><?= $row['action_date']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
