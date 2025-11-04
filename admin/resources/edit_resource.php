<?php
require_once '../includes/db.php';
require_once '../includes/admin_auth.php';
require_admin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: view_resources.php');
    exit;
}

// Fetch resource
$stmt = $conn->prepare("SELECT * FROM resources WHERE id=?");
$stmt->bind_param('i', $id);
$stmt->execute();
$resource = $stmt->get_result()->fetch_assoc();

if (!$resource) {
    header('Location: view_resources.php');
    exit;
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);

    if (!$title) $errors[] = 'Title is required';
    if (!$description) $errors[] = 'Description is required';

    // Handle file upload
    $file = $resource['file'];
    if (!empty($_FILES['file']['name'])) {
        $allowedExt = ['pdf','docx','doc','jpg','png','zip'];
        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt)) $errors[] = 'Invalid file type';
        else {
            $file = time().'_'.basename($_FILES['file']['name']);
            $targetDir = 'uploads/';
            move_uploaded_file($_FILES['file']['tmp_name'], $targetDir.$file);
        }
    }

    if (!$errors) {
        $stmt = $conn->prepare("UPDATE resources SET title=?, description=?, file=?, link=? WHERE id=?");
        $stmt->bind_param('ssssi', $title, $description, $file, $link, $id);
        if ($stmt->execute()) $success = 'Resource updated successfully';
        else $errors[] = 'Database error: '.$stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Resource — Admin</title>
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

/* Form styling */
.card {
    border-radius: 0.75rem;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

<?php include '../includes/sidebar.php'; ?>

<div class="main-content">
    <main>
        <div class="container">
            <h2 class="mb-4">Edit Resource</h2>

            <!-- Errors -->
            <?php if($errors): ?>
            <div class="alert alert-danger">
                <ul><?php foreach($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul>
            </div>
            <?php endif; ?>

            <!-- Success -->
            <?php if($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <!-- Form -->
            <form method="post" enctype="multipart/form-data" class="card p-4 bg-white">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($_POST['title'] ?? $resource['title']); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($_POST['description'] ?? $resource['description']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">File (optional)</label>
                    <input type="file" name="file" class="form-control">
                    <?php if($resource['file']): ?>
                        <small>Current file: <?php echo htmlspecialchars($resource['file']); ?></small>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">External Link (optional)</label>
                    <input type="url" name="link" class="form-control" value="<?php echo htmlspecialchars($_POST['link'] ?? $resource['link']); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Resource</button>
                <a href="view_resources.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> InsightHub Admin Panel. All rights reserved.
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
