<?php

require_once 'app/Controllers/PostsController.php';

$postController = new PostController($pdo);

// Fetch the news data from the controller
$data = $postController->getMostRecentNews($limit = 5);

// var_dump($data);

?>
<div>
    <h2 class="mb-4 text-lg font-bold dark:text-white">Latest News</h2>
    <div class="space-y-2">
        <?php foreach ($data as $post): ?>
        <a href="post/<?= htmlspecialchars($post['posts_id']) ?>" class="block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
            <div class="flex flex-col sm:flex-row items-start p-2 rounded-lg bg-white shadow transition-shadow duration-300 hover:shadow-lg dark:bg-gray-800">
                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars(substr($post['title'], 0, 5)); ?>" class="mb-4 sm:mb-0 sm:mr-4 h-32 w-full sm:w-24 sm:h-24 rounded-lg object-cover" />
                <div class="flex-1">
                    <h3 class=" font-bold dark:text-white hover:underline"><?php echo htmlspecialchars(substr($post['title'], 0, 40)); ?></h3>
                    <p class="text-sm font-thin text-gray-600 dark:text-gray-400"><?php echo substr($post['content'], 0, 15) ?>...</p>
                    <p class="text-[8px] text-gray-500 dark:text-gray-500"><?php echo htmlspecialchars($post['created_at']); ?> ago</p>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
