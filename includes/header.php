<?php
session_start();
require_once 'includes/db_connect.php';

// Get categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
$user_name = $_SESSION['user_name'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scott's Docs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/scotts-docs/assets/css/styles.css">
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <div class="site-title">
            <a href="/scotts-docs/index.php">
                <span class="title-part">SCOTT'S</span> <span class="title-docs">DOCS</span>
            </a>
        </div>

        <form class="search-bar" action="/scotts-docs/search.php" method="GET">
            <input type="text" name="q" placeholder="Search documentaries...">
        </form>

        <div class="header-actions">
            <div class="dropdown">
                <button class="dropdown-btn" onclick="toggleDropdown('categoryDropdown')">Categories ▾</button>
                <div class="dropdown-menu category-menu" id="categoryDropdown">
                    <?php foreach ($categories as $cat): ?>
                        <a href="/scotts-docs/categories.php?id=<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown user-dropdown">
                <?php if ($user_name): ?>
                    <button class="dropdown-btn" onclick="toggleDropdown('userDropdown')">
                        <img src="/scotts-docs/assets/images/user-icon.png" alt="Profile" class="user-icon">
                        Hi <?= htmlspecialchars($user_name) ?> ▾
                    </button>
                    <div class="dropdown-menu" id="userDropdown">
                        <a href="/scotts-docs/dashboard.php">Watch Later</a>
                        <a href="/scotts-docs/logout.php">Log out</a>
                        <a href="#" class="danger">Delete Account</a>
                    </div>
                <?php else: ?>
                    <a href="/scotts-docs/login.php" class="login-link">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
