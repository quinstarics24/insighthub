<?php
require_once '../includes/db.php';
require_once '../includes/admin_auth.php';
require_admin();

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: view_resources.php'); exit; }

// Optionally delete uploaded file
$res = $conn->query("SELECT file FROM resources WHERE id=$id");
if($res && $res->num_rows){
    $row = $res->fetch_assoc();
    if($row['file'] && file_exists('uploads/'.$row['file'])){
        unlink('uploads/'.$row['file']);
    }
}

$conn->query("DELETE FROM resources WHERE id=$id");
header('Location: view_resources.php');
exit;
