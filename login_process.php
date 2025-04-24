<?php
session_start();
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        exit('No user found with this email.');
    }

    if (!$user['email_verified']) {
        exit('Please verify your email before logging in.');
    }

    if (!password_verify($password, $user['password_hash'])) {
        exit('Incorrect password.');
    }

    // Login success → set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];

    header('Location: dashboard.php');
    exit;
}
?>
