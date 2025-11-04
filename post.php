<?php
require_once 'admin/includes/db.php';

// Get slug from URL
$slug = $_GET['slug'] ?? '';

if (!$slug) {
    header('Location: blog.php');
    exit;
}

// Fetch the post safely
$stmt = $conn->prepare("SELECT * FROM posts WHERE slug = ?");
$stmt->bind_param('s', $slug);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Post not found
    header('Location: blog.php');
    exit;
}

$post = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> — InsightHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Ensure footer sticks to bottom */
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto; /* Grow to fill space */
        }
        footer {
            flex-shrink: 0; /* Prevent shrinking */
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="container py-5">
    <h1 class="fw-bold mb-3"><?php echo htmlspecialchars($post['title']); ?></h1>
    <p class="text-muted">
        <?php if (!empty($post['author'])): ?>
            By <?php echo htmlspecialchars($post['author']); ?> |
        <?php endif; ?>
        <?php echo date("F j, Y", strtotime($post['created_at'])); ?>
    </p>

    <?php if (!empty($post['image'])): ?>
        <img src="admin/uploads/<?php echo htmlspecialchars($post['image']); ?>" class="img-fluid rounded mb-4" alt="<?php echo htmlspecialchars($post['title']); ?>">
    <?php endif; ?>

    <div class="post-content fs-5">
        <?php echo nl2br($post['content']); ?>
    </div>

    <a href="blog.php" class="btn btn-outline-primary mt-4">← Back to Blog</a>
</main>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
