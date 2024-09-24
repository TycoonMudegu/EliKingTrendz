<?php

require_once 'app/Controllers/PostsController.php';

$postController = new PostController($pdo);

// Fetch the news data from the controller
$data = $postController->getTrendingNews($limit = 5);

// var_dump($data);

?>
<div>
    <h2 class="mb-4 text-xl font-bold dark:text-white">Trending News</h2>
    <div class="space-y-4">
        <?php foreach ($data as $post): ?>
        <a href="post/<?= htmlspecialchars($news['posts_id']) ?>" class="block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
            <div class="flex items-start rounded-lg bg-white p-2 shadow transition-shadow duration-300 hover:shadow-lg dark:bg-gray-800">
                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="mr-4 h-16 w-16 rounded-lg" />
                <div>
                    <h3 class="text font-bold dark:text-white hover:underline "><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo substr($post['content'], 0, 25) ?>...</p>
                    <p class="text-sm text-gray-500 dark:text-gray-500"><?php echo htmlspecialchars($post['created_at']); ?> ago</p>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>