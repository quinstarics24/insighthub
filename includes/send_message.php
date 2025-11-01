<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // (Optional) — save to database or send an email later

    echo "<script>
        alert('Thank you, $name! Your message has been sent successfully.');
        window.location.href='../contact.php';
    </script>";
    exit;
} else {
    header('Location: ../contact.php');
    exit;
}
?>
