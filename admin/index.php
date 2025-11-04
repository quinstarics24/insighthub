<?php
require_once 'includes/db.php';
require_once 'includes/admin_auth.php';
require_admin();

// Fetch stats
$post_count = $conn->query("SELECT COUNT(*) as total FROM posts")->fetch_assoc()['total'];
$resource_count = $conn->query("SELECT COUNT(*) as total FROM resources")->fetch_assoc()['total'];
$message_count = $conn->query("SELECT COUNT(*) as total FROM messages")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — InsightHub</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    html, body {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        flex-direction: row;
    }

    /* Sidebar width is 250px */
    .main-content {
        margin-left: 250px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex: 1;
        padding: 2rem;
        background: #f4f6f9;
    }

    footer {
        background: #343a40;
        color: #fff;
        text-align: center;
        padding: 1rem;
        border-top: 2px solid #007bff;
    }

    .card {
        border-radius: 0.75rem;
        transition: transform 0.2s;
        text-align: center;
    }

    .card:hover {
        transform: translateY(-5px);
    }
</style>
</head>
<body>

<!-- Sidebar -->
<?php include 'includes/sidebar.php'; ?>

<!-- Main content -->
<div class="main-content">
    <main>
        <h2 class="fw-bold mb-4">Welcome, Admin 👋</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <h5>Total Posts</h5>
                    <p class="display-6"><?php echo $post_count; ?></p>
                    <a href="posts/manage_posts.php" class="btn btn-outline-primary btn-sm">Manage Posts</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <h5>Total Resources</h5>
                    <p class="display-6"><?php echo $resource_count; ?></p>
                    <a href="resources/view_resources.php" class="btn btn-outline-primary btn-sm">Manage Resources</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <h5>Total Messages</h5>
                    <p class="display-6"><?php echo $message_count; ?></p>
                    <a href="messages.php" class="btn btn-outline-primary btn-sm">View Messages</a>
                </div>
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
