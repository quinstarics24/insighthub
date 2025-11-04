<?php
session_start();
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/admin_auth.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Hardcoded admin credentials for now
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_user'] = $username;
        header('Location: index.php'); exit;
    } else {
        $errors[] = "Invalid username or password.";
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>InsightHub Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f6f8fb">
<div class="container" style="max-width:480px;margin-top:10vh">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">Admin Login</h4>

            <?php if($errors): ?>
                <div class="alert alert-danger">
                    <?php foreach($errors as $e) echo "<div>$e</div>"; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input name="username" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" required>
                </div>

                <button class="btn btn-dark" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
