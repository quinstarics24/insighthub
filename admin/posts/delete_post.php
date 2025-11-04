<?php
require_once '../includes/db.php';
require_once '../includes/admin_auth.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);

if ($id) {
    // Optionally, fetch image to delete it
    $stmt = $conn->prepare("SELECT image FROM posts WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if ($res && $res['image'] && file_exists('../uploads/'.$res['image'])) {
        unlink('../uploads/'.$res['image']);
    }

    $stmt = $conn->prepare("DELETE FROM posts WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

header('Location: manage_posts.php');
exit;
