<?php
require_once 'admin/includes/db.php';
$result = $conn->query("SELECT * FROM resources ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resources — InsightHub</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

<?php include 'includes/header.php'; ?>

<main class="flex-grow-1">
  <section class="container py-5">
      <h1 class="text-center mb-4 fw-bold">Resources</h1>
      <div class="row g-4">
          <?php while($row = $result->fetch_assoc()): ?>
              <div class="col-md-4">
                  <div class="card h-100 shadow-sm border-0">
                      <div class="card-body">
                          <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                          <p class="card-text"><?php echo substr(strip_tags($row['description']), 0, 120) . '...'; ?></p>
                          <?php if ($row['file']): ?>
                              <a href="admin/resources/uploads/<?php echo htmlspecialchars($row['file']); ?>" target="_blank" class="btn btn-primary btn-sm">Download</a>
                          <?php elseif ($row['link']): ?>
                              <a href="<?php echo htmlspecialchars($row['link']); ?>" target="_blank" class="btn btn-primary btn-sm">Visit</a>
                          <?php endif; ?>
                      </div>
                  </div>
              </div>
          <?php endwhile; ?>
      </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
