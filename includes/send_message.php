<?php
// Make sure $conn is included
require_once __DIR__ . '/db.php'; // correct path relative to this file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];

    if (!$name) $errors[] = "Name is required.";
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (!$subject) $errors[] = "Subject is required.";
    if (!$message) $errors[] = "Message is required.";

    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        if ($stmt->execute()) {
            header("Location: ../contact.php?success=1");
            exit;
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
    }

    if ($errors) {
        header("Location: ../contact.php?error=" . urlencode(implode(", ", $errors)));
        exit;
    }
}
?>
