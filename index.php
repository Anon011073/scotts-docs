<?php
require_once 'includes/db_connect.php';
include 'includes/header.php';

// Fetch categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

// Fetch videos (limit 12 for now)
$videos = $pdo->query("
    SELECT videos.*, categories.name AS category_name
    FROM videos
    LEFT JOIN categories ON videos.category_id = categories.id
    ORDER BY videos.created_at DESC
    LIMIT 12
")->fetchAll();
?>

<div class="container">
  


<!-- Video Grid -->
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
</div>

</div>

<?php include 'includes/footer.php'; ?>
