<?php
require_once 'includes/db_connect.php';
include 'includes/header.php';

$query = $_GET['q'] ?? '';

if (!$query) {
    echo "<p>Please enter a search term.</p>";
    include 'includes/footer.php';
    exit;
}

// Search videos
$stmt = $pdo->prepare("
    SELECT * FROM videos 
    WHERE title LIKE ? OR description LIKE ?
    ORDER BY created_at DESC
");
$searchTerm = '%' . $query . '%';
$stmt->execute([$searchTerm, $searchTerm]);
$videos = $stmt->fetchAll();
?>

<div class="container">
    <h2>Search Results for: <em><?= htmlspecialchars($query) ?></em></h2>

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
            <p>No results found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
