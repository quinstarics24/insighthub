<?php
require_once '../includes/db.php';
require_once '../includes/admin_auth.php';
require_admin();

// Fetch all posts
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Posts — Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* General layout */
body {
    margin: 0;
    display: flex;
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
}

/* Sidebar */
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
    border-radius: 4px;
}

.sidebar a:hover {
    background: #495057;
}

/* Main content */
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

/* Footer */
footer {
    background: #343a40;
    color: #fff;
    text-align: center;
    padding: 1rem;
    border-top: 2px solid #007bff;
}

/* Table styling */
.table th, .table td {
    vertical-align: middle;
}
</style>
</head>
<body>

<?php include '../includes/sidebar.php'; ?>

<div class="main-content">
    <main>
        <div class="container">
            <h2 class="mb-4">Manage Posts</h2>
            <a href="add_post.php" class="btn btn-success mb-3">Add New Post</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($post = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $post['id']; ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><?php echo htmlspecialchars($post['author']); ?></td>
                            <td><?php echo $post['created_at']; ?></td>
                            <td>
                                <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> InsightHub Admin Panel. All rights reserved.
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
