<?php require_once 'app/views/partials/navbar.php';

// Initialize the controller
require_once 'app/Controllers/PostsController.php';

$url = isset($_GET['url']) ? trim($_GET['url']) : '';

// Parse the URL to extract category
if (preg_match('/^Category\/([a-zA-Z0-9_-]+)$/', $url, $matches)) {
    $categoryName = htmlspecialchars(trim($matches[1]));
    
    // echo "Category found.";
} else {
    // Handle invalid URLs or show a 404 page
    // echo "Category not found.";
}

// Create a new PostController instance
$postController = new PostController($pdo);

// Fetch the news data from the controller
$data = $postController->showCategoryNews($categoryName);

$mainNews = $data['mainNews'];
$moreNews = $data['moreNews'];
$categoryName = $data['categoryName'];

?>

<section class="bg-gray-200 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-200 font-PTserif p-8">

    <div class="container mx-auto py-4 px-6">
        <div class="grid grid-cols-12 gap-6">
            <!-- Main Content -->
            <div class="col-span-12 lg:col-span-8">
    <!-- Main Article -->
    <?php if ($mainNews): ?>
    <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md">
        <div class="flex flex-col md:flex-row">
            <img src="<?= htmlspecialchars($mainNews['image']) ?>" alt="Main Article Image" class="w-full md:w-1/3 h-auto object-cover">
            <div class="p-6">
                <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($mainNews['title']) ?></h1>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Written by <a href="#" class="font-bold text-blue-500 hover:underline"><?= htmlspecialchars($mainNews['author_name']) ?></a> 
                    on <span class="font-bold"><?= date('F j, Y', strtotime($mainNews['created_at'])) ?></span>
                </p>
                <p class="mb-4"><?= htmlspecialchars(substr($mainNews['content'], 0, 200)) ?>...</p>
                <a href="post/<?= htmlspecialchars($mainNews['posts_id']) ?>" class="text-blue-500 hover:underline">Read more</a>
            </div>
        </div>
    </div>
    <?php else: ?>
    <p>No news available in this category.</p>
    <?php endif; ?>

    <!-- More News Articles -->
    <div>
        <h2 class="text-2xl font-bold mb-4">More News in <?= htmlspecialchars($categoryName) ?></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($moreNews)): ?>
                <?php foreach ($moreNews as $news): ?>
                <a href="post/<?= htmlspecialchars($news['posts_id']) ?>" class="block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
                    <div class="flex">
                        <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars(substr($news['title'],0, 5)) ?>" class="w-24 h-24 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold mb-1"><?= htmlspecialchars($news['title']) ?></h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-2"><?= htmlspecialchars(substr($news['content'], 0, 50)) ?>...</p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No more news available in this category.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

            
            <!-- Sidebar -->
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-md">
                    <h2 class="text-xl font-bold mb-4">Recommended For You</h2>
                    <!-- Recommended Article 1 -->
                    <div class="flex items-start mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <img src="/api/placeholder/100/100" alt="Recommended Article 1" class="w-16 h-16 rounded-lg mr-4 object-cover">
                        <div>
                            <h3 class="font-bold mb-1">Recommended Article Title 1</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">Short description of the article...</p>
                            <p class="text-gray-500 text-sm">2 hours ago</p>
                        </div>
                    </div>
                    <!-- Recommended Article 2 -->
                    <div class="flex items-start mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <img src="/api/placeholder/100/100" alt="Recommended Article 2" class="w-16 h-16 rounded-lg mr-4 object-cover">
                        <div>
                            <h3 class="font-bold mb-1">Recommended Article Title 2</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">Short description of the article...</p>
                            <p class="text-gray-500 text-sm">4 hours ago</p>
                        </div>
                    </div>
                    <!-- Add more recommended articles as needed -->
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-md">
                    <h2 class="text-xl font-bold mb-4">Advertisement</h2>
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden">
                        <img src="/api/placeholder/300/250" alt="Advertisement" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<?php include 'app/views/partials/footer.php'; ?>


