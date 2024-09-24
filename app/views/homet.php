<?php require_once 'app/views/partials/navbar.php'?>


<?php
// Include necessary files
require_once 'app/Controllers/PostsController.php';

// Create a new PostController instance
$postController = new PostController($pdo);

// Fetch posts for each category
$technologyPosts = $postController->getPostsByCategory(1, 5);
$businessPosts = $postController->getPostsByCategory(2, 5);
$entertainmentPosts = $postController->getPostsByCategory(3, 5);
$healthPosts = $postController->getPostsByCategory(4, 5);
$politicsPosts = $postController->getPostsByCategory(5, 5);
// Fetch the various types of posts
$breakingNews = $postController->getBreakingNews(5);
$mostRecentNews = $postController->getMostRecentNews(5);
$trendingNews = $postController->getTrendingNews(5);

?>

<!-- Breaking News Section -->
<section id="breaking-news">
    <h2>Breaking News</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($breakingNews as $post): ?>
            <div class="bg-red-100 p-4 rounded shadow">
                <img src="assets/images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-48 object-cover rounded mb-4">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="post/<?= htmlspecialchars($post['posts_id']) ?>" onclick="incrementPostViews(<?= htmlspecialchars($post['posts_id']) ?>)"><?= htmlspecialchars($post['title']) ?></a>
                </h2>
                <p class="text-gray-700"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Most Recent News Section -->
<section id="recent-news">
    <h2>Most Recent News</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($mostRecentNews as $post): ?>
            <div class="bg-white p-4 rounded shadow">
                <img src="assets/images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-48 object-cover rounded mb-4">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="post/<?= htmlspecialchars($post['posts_id']) ?>" onclick="incrementPostViews(<?= htmlspecialchars($post['posts_id']) ?>)"><?= htmlspecialchars($post['title']) ?></a>
                </h2>
                <p class="text-gray-700"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Trending News Section -->
<section id="trending-news">
    <h2>Trending News</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($trendingNews as $post): ?>
            <div class="bg-yellow-100 p-4 rounded shadow">
                <img src="assets/images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-48 object-cover rounded mb-4">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="post/<?= htmlspecialchars($post['posts_id']) ?>" onclick="incrementPostViews(<?= htmlspecialchars($post['posts_id']) ?>)"><?= htmlspecialchars($post['title']) ?></a>
                </h2>
                <p class="text-gray-700"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Increment Post Views Script -->


<!-- Display Technology Posts -->
<section id="technology">
    <h2>Technology</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($technologyPosts as $post): ?>
            <div class="bg-white p-4 rounded shadow">
                <img src="assets/images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-48 object-cover rounded mb-4">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="post/<?= htmlspecialchars($post['posts_id']) ?>"><?= htmlspecialchars($post['title']) ?></a>
                </h2>
                <p class="text-gray-700"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Display Business Posts -->
<section id="business">
    <h2>Business</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($businessPosts as $post): ?>
            <div class="bg-white p-4 rounded shadow">
                <img src="assets/images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-48 object-cover rounded mb-4">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="post/<?= htmlspecialchars($post['posts_id']) ?>"><?= htmlspecialchars($post['title']) ?></a>
                </h2>
                <p class="text-gray-700"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Similarly for Entertainment, Health, and Politics -->

<section id="entertainment">
    <h2>Entertainment</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($entertainmentPosts as $post): ?>
            <div class="bg-white p-4 rounded shadow">
                <img src="assets/images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-48 object-cover rounded mb-4">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="post/<?= htmlspecialchars($post['posts_id']) ?>"><?= htmlspecialchars($post['title']) ?></a>
                </h2>
                <p class="text-gray-700"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="health">
    <h2>Health</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($healthPosts as $post): ?>
            <div class="bg-white p-4 rounded shadow">
                <img src="assets/images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-48 object-cover rounded mb-4">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="post/<?= htmlspecialchars($post['posts_id']) ?>"><?= htmlspecialchars($post['title']) ?></a>
                </h2>
                <p class="text-gray-700"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="politics">
    <h2>Politics</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($politicsPosts as $post): ?>
            <div class="bg-white p-4 rounded shadow">
                <img src="assets/images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-48 object-cover rounded mb-4">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="post/<?= htmlspecialchars($post['posts_id']) ?>"><?= htmlspecialchars($post['title']) ?></a>
                </h2>
                <p class="text-gray-700"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- <script>
function incrementPostViews(postId) {
    fetch(`Trending?post_id=${postId}`);
}
</script> -->
