<?php
require_once 'includes/db_connect.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? '';

// Fetch saved videos
$stmt = $pdo->prepare("
    SELECT videos.*
    FROM saved_videos
    JOIN videos ON saved_videos.video_id = videos.id
    WHERE saved_videos.user_id = ?
");
$stmt->execute([$user_id]);
$saved = $stmt->fetchAll();
?>

<div class="container">
    <h2>Welcome back, <?= htmlspecialchars($user_name) ?>!</h2>

    <h3>Your Saved Videos</h3>
    <div class="video-grid">
        <?php foreach ($saved as $video): ?>
            <div class="video-card">
                <iframe src="<?= htmlspecialchars($video['url']) ?>" frameborder="0" allowfullscreen></iframe>
                <h4><?= htmlspecialchars($video['title']) ?></h4>
            </div>
        <?php endforeach; ?>
        <?php if (count($saved) === 0): ?>
            <p>You haven't saved any videos yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
