<?php
require_once '../includes/db.php';
require_once '../includes/admin_auth.php';
require_admin();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $author = trim($_POST['author'] ?? '');

    if (!$title) $errors[] = 'Title is required.';
    if (!$content) $errors[] = 'Content is required.';
    if (!$author) $errors[] = 'Author is required.';

    // Handle image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $allowedExt = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt)) {
            $errors[] = 'Invalid image type. Allowed: jpg, jpeg, png, gif.';
        } else {
            $image = time() . '_' . basename($_FILES['image']['name']);
            $targetDir = 'uploads/';
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $image)) {
                $errors[] = 'Failed to upload image.';
            }
        }
    }

    // Generate unique slug
    function generateSlug($title, $conn) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $originalSlug = $slug;
        $i = 1;
        while ($conn->query("SELECT id FROM posts WHERE slug='$slug'")->num_rows > 0) {
            $slug = $originalSlug . '-' . $i;
            $i++;
        }
        return $slug;
    }

    $slug = generateSlug($title, $conn);

    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO posts (title, slug, content, author, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $title, $slug, $content, $author, $image);
        if ($stmt->execute()) {
            $success = 'Post added successfully!';
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
<title>Add New Post — Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
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
</style>
</head>
<body>

<?php include '../includes/sidebar.php'; ?>

<div class="main-content">
    <main>
        <div class="container">
            <h2 class="mb-4">Add New Post</h2>

            <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <ul><?php foreach ($errors as $e) echo "<li>$e</li>"; ?></ul>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input type="text" name="author" class="form-control" required value="<?php echo htmlspecialchars($_POST['author'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="6" required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Featured Image (optional)</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Add Post</button>
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
