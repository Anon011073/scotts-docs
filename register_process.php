<?php
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit('Invalid email format.');
    }

    // Generate hash + token
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(32)); // 64-char token

    // Insert into DB
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, verification_token) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$name, $email, $password_hash, $token]);
    } catch (PDOException $e) {
        exit('Error: ' . $e->getMessage());
    }

    // DEV MODE: Show verification link
    $verify_url = "http://localhost/scotts-docs/verify_email.php?email=" . urlencode($email) . "&token=$token";
    echo "<h2>Registration successful!</h2>";
    echo "<p><strong>Click the link below to verify your email:</strong></p>";
    echo "<a href='$verify_url'>$verify_url</a>";
}
?>
