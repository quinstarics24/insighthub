<?php
require_once '../includes/db.php';
require_once '../includes/admin_auth.php';
require_admin();

$errors = [];
$success = '';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header('Location: manage_posts.php');
    exit;
}

// Fetch the post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    header('Location: manage_posts.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $slug = strtolower(str_replace(' ', '-', $title));
    $content = htmlspecialchars($_POST['content']);
    $author = htmlspecialchars($_POST['author']);

    // Handle image upload
    $image = $post['image'];
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $target = '../uploads/' . $image_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image = $image_name;
        } else {
            $errors[] = 'Failed to upload image.';
        }
    }

    if (!$errors) {
        $stmt = $conn->prepare("UPDATE posts SET title=?, slug=?, content=?, image=?, author=? WHERE id=?");
        $stmt->bind_param('sssssi', $title, $slug, $content, $image, $author, $id);
        if ($stmt->execute()) {
            $success = 'Post updated successfully!';
            $post = ['title'=>$title,'slug'=>$slug,'content'=>$content,'image'=>$image,'author'=>$author];
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
<title>Edit Post — Admin</title>
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
            <h2 class="mb-4">Edit Post</h2>

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
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($post['author']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="6" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Image</label><br>
                    <?php if ($post['image']): ?>
                        <img src="../uploads/<?php echo $post['image']; ?>" width="150" class="mb-2"><br>
                    <?php endif; ?>
                    <label class="form-label">Change Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Update Post</button>
                <a href="manage_posts.php" class="btn btn-secondary">Back</a>
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
