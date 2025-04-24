<?php
require_once 'includes/db_connect.php';

$email = $_GET['email'] ?? '';
$token = $_GET['token'] ?? '';

if (!$email || !$token) {
    exit('Missing parameters.');
}

// Verify + update
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND verification_token = ?");
$stmt->execute([$email, $token]);
$user = $stmt->fetch();

if ($user) {
    $update = $pdo->prepare("UPDATE users SET email_verified = 1, verification_token = NULL WHERE id = ?");
    $update->execute([$user['id']]);
    echo "<h2>Email verified! You can now log in.</h2>";
} else {
    echo "Invalid or expired verification link.";
}
?>
