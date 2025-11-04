<?php
require_once '../includes/db.php';
require_once 'includes/admin_auth.php';
require_admin();

// Fetch all messages
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Messages — Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    display: flex;
    min-height: 100vh;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}

.sidebar {
    width: 250px;
    background: #343a40;
    color: #fff;
    padding: 1rem;
    position: fixed;
    top: 0;
    bottom: 0;
}

.sidebar a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 0.5rem 0;
}

.sidebar a:hover {
    background: #495057;
}

.main-content {
    margin-left: 250px;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background: #f4f6f9;
}

main {
    flex: 1;
    padding: 2rem;
}

footer {
    background: #343a40;
    color: #fff;
    text-align: center;
    padding: 1rem;
    border-top: 2px solid #007bff;
}
</style>
</head>
<body>

<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
<main>
    <div class="container">
        <h2 class="mb-4">Contact Messages</h2>

        <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Sent At</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>No messages yet.</p>
        <?php endif; ?>
    </div>
</main>

<footer>
    &copy; <?php echo date("Y"); ?> InsightHub Admin Panel. All rights reserved.
</footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
