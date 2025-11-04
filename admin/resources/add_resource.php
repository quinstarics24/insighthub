<?php
require_once '../includes/db.php';
require_once '../includes/admin_auth.php';
require_admin();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $link = trim($_POST['link'] ?? '');

    // Validation
    if (!$title) $errors[] = 'Title is required.';
    if (!$description) $errors[] = 'Description is required.';

    // Handle file upload
    $file = '';
    if (!empty($_FILES['file']['name'])) {
        $allowedExt = ['pdf','docx','doc','jpg','png','zip'];
        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt)) {
            $errors[] = 'Invalid file type.';
        } else {
            $file = time() . '_' . basename($_FILES['file']['name']);
            $targetDir = 'uploads/';
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetDir . $file)) {
                $errors[] = 'Failed to upload file.';
            }
        }
    }

    // Generate unique slug
    function generateSlug($title, $conn) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $originalSlug = $slug;
        $i = 1;
        while ($conn->query("SELECT id FROM resources WHERE slug='$slug'")->num_rows > 0) {
            $slug = $originalSlug . '-' . $i;
            $i++;
        }
        return $slug;
    }

    $slug = generateSlug($title, $conn);

    // Insert into DB
    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO resources (title, slug, description, file, link) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $title, $slug, $description, $file, $link);
        if ($stmt->execute()) {
            $success = 'Resource added successfully!';
        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Resource — Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* General page layout */
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
    margin-left: 250px; /* space for sidebar */
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

/* Optional form/card styling */
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
            <h2 class="mb-4">Add New Resource</h2>

            <!-- Display errors/success -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <!-- Form -->
            <form method="post" enctype="multipart/form-data" class="card p-4 bg-white">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">File (optional)</label>
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">External Link (optional)</label>
                    <input type="url" name="link" class="form-control" value="<?php echo htmlspecialchars($_POST['link'] ?? ''); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Add Resource</button>
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
