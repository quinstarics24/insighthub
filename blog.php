<?php
require_once 'admin/includes/db.php';

// Fetch all posts (latest first)
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog — InsightHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<section class="container py-5">
    <h1 class="text-center mb-4 fw-bold">Latest Insights</h1>
    <div class="row g-4">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <?php if ($row['image']): ?>
                        <img src="admin/uploads/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="card-text text-muted small mb-2">By <?php echo htmlspecialchars($row['author']); ?> | <?php echo date("M d, Y", strtotime($row['created_at'])); ?></p>
                        <p class="card-text">
                            <?php echo substr(strip_tags($row['content']), 0, 100) . '...'; ?>
                        </p>
                        <a href="post.php?slug=<?php echo $row['slug']; ?>" class="btn btn-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>
