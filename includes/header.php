<?php
session_start();
require_once 'includes/db_connect.php';

// Get categories for dropdown
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
$user_name = $_SESSION['user_name'] ?? null;
?>

<header class="site-header">
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Scott's Docs</title>
    <link rel="stylesheet" href="/scotts-docs/assets/css/styles.css">
    <div class="header-inner">
        <div class="site-title">
            <a href="index.php"><span class="title-part">SCOTT'S</span> <span class="title-docs">DOCS</span></a>
        </div>

        <form class="search-bar" action="search.php" method="GET">
            <input type="text" name="q" placeholder="Search documentaries...">
        </form>

        <div class="header-actions">
            <div class="dropdown">
                <button class="dropdown-btn" onclick="toggleDropdown('categoryDropdown')">Categories ▾</button>
                <div class="dropdown-menu category-menu" id="categoryDropdown">
                    <?php foreach ($categories as $cat): ?>
                        <a href="categories.php?id=<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="dropdown user-dropdown">
                <?php if ($user_name): ?>
                    <button class="dropdown-btn" onclick="toggleDropdown('userDropdown')">
                        <img src="assets/images/user-icon.png" alt="Profile" class="user-icon"> Hi <?= htmlspecialchars($user_name) ?> ▾
                    </button>
                    <div class="dropdown-menu" id="userDropdown">
                        <a href="dashboard.php">Watch Later</a>
                        <a href="logout.php">Log out</a>
                        <a href="#" class="danger">Delete Account</a>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="login-link">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
