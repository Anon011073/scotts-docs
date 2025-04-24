<?php
require_once 'includes/db_connect.php';
include 'includes/header.php';

$category_id = $_GET['id'] ?? null;

if (!$category_id) {
    echo "<p>Category not specified.</p>";
    include 'includes/footer.php';
    exit;
}

// Get category name
$stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch();

if (!$category) {
    echo "<p>Category not found.</p>";
    include 'includes/footer.php';
    exit;
}

// Get videos in this category
$stmt = $pdo->prepare("SELECT * FROM videos WHERE category_id = ? ORDER BY created_at DESC");
$stmt->execute([$category_id]);
$videos = $stmt->fetchAll();
?>

<div class="container">
    <h2><?= htmlspecialchars($category['name']) ?> Documentaries</h2>

    <div class="video-grid">
        <?php foreach ($videos as $video): ?>
            <div class="video-card">
                <iframe src="<?= htmlspecialchars($video['url']) ?>" frameborder="0" allowfullscreen></iframe>
                <h4><?= htmlspecialchars($video['title']) ?></h4>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <form method="POST" action="save_video.php">
                        <input type="hidden" name="video_id" value="<?= $video['id'] ?>">
                        <button type="submit">💾 Save</button>
                    </form>
                <?php else: ?>
                    <p><em><a href="login.php">Login</a> to save this video</em></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if (count($videos) === 0): ?>
            <p>No videos in this category yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
