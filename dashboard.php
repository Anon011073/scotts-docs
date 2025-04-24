<?php
session_start();
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
    <?php
session_start();
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
    <?php
require_once 'includes/db_connect.php';
session_start();
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
    <h1>Scott's Docs</h1>

    <!-- Search -->
    <form method="GET" action="search.php" class="search-bar">
        <input type="text" name="q" placeholder="Search documentaries...">
        <button type="submit">Search</button>
    </form>

    <!-- Categories -->
    <div class="categories">
        <h3>Browse Categories</h3>
        <?php foreach ($categories as $cat): ?>
            <a href="categories.php?id=<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></a>
        <?php endforeach; ?>
    </div>

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
