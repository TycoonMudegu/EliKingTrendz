<?php require_once 'app/views/partials/navbar.php';

$url = isset($_GET['url']) ? trim($_GET['url']) : '';

$postId = '';

// Parse the URL to extract post ID
if (isset($_GET['url']) && preg_match('/^post\/([0-9]+)$/', $_GET['url'], $matches)) {
  $postId = (int) $matches[1]; // Extract and cast to integer for safety
  
  // echo "Post ID found.";
} else {
  // Handle invalid URLs or show a 404 page
  // echo "Post ID not found.";
}

// Create a new PostController instance
$postController = new PostController($pdo);

// Fetch the news data from the controller
$data = $postController->viewPost($postId);

// Original date string from $data
$dateString = $data['published_at'];

// Create a DateTime object from the string
$date = new DateTime($dateString);

// Format the date
$formattedDate = $date->format('l, j F Y');
// // Debugging output
// var_dump($data['image']);
?>


<div class="bg-gray-200 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-200 font-PTserif p-4 md:p-12">

  <nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
      <li class="inline-flex items-center">
        <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
          <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
          </svg>
          Home
        </a>
      </li>
      <li>
        <div class="flex items-center">
          <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>
          <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Politics</a>
        </div>
      </li>
      <li aria-current="page">
        <div class="flex items-center">
          <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>
          <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">World</span>
        </div>
      </li>
    </ol>
  </nav>

  <div class="grid grid-cols-12 gap-3">
    <!-- Main Article -->
    <div class="col-span-12 lg:col-span-8 overflow-auto">
    <?php if ($data): ?>

      <div class="relative mb-4">
      <img src="<?php htmlspecialchars($data['image']); ?>" alt="News Article Image" class="h-auto w-full rounded-lg shadow-md" />
      <span class="absolute bottom-2 left-2 rounded-md bg-gray-800 px-2 py-1 text-sm text-white">Image by John Doe </span>
      </div>
      <h1 class="mb-4 mt-2 text-2xl md:text-4xl font-bold"><?= htmlspecialchars($data['title']); ?></h2>
      </h1>
      <div class="flex flex-wrap justify-between border-t border-gray-300 dark:border-gray-600 pt-4 mb-4 text-sm">
        <p class="mb-2 text-gray-600 dark:text-gray-400">Written by 
          <a href="#" class="font-bold text-blue-500 hover:underline dark:text-blue-400"><?= htmlspecialchars($data['author_name']); ?></a> 
          on <span class="font-bold"><?= htmlspecialchars($formattedDate); ?></span>
        </p>
          <!-- Upvotes -->
          <div class="flex items-center">
            <button class="focus:outline-none flex items-center hover:text-blue-500 dark:hover:text-blue-400">
              <i class="fas fa-thumbs-up mr-2"></i> 
              <span class="font-semibold">142 Upvotes</span>
            </button>
          </div>
          <!-- Share Icon -->
          <div class="flex items-center">
            <button class="focus:outline-none flex items-center hover:text-blue-500 dark:hover:text-blue-400">
              <i class="fas fa-share mr-2"></i>
              <span class="font-semibold">Share</span>
            </button>
          </div>
          <!-- Comment Icon -->
          <div class="flex items-center">
            <button class="focus:outline-none flex items-center hover:text-blue-500 dark:hover:text-blue-400">
              <i class="far fa-comment mr-2"></i>
              <span class="font-semibold">Leave a Comment</span>
            </button>
          </div>
      </div>

      <div class="border-t border-gray-300 dark:border-gray-600 mt-4"></div>
        <article class="prose lg:prose-xl text-gray-800 dark:text-gray-200 leading-relaxed mb-8 dark:prose-strong:text-gray-100 dark:prose-headings:text-gray-100">
            <?php
                // Echo the article content from the database
                echo $data['content'];
            ?>
        </article>




        <div class="border-t border-gray-300 dark:border-gray-600 pt-6 mt-6 bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4 dark:text-white">About the Author</h2>
            <div class="flex items-center">
                <img src="<?= htmlspecialchars($data['picture']); ?>" alt="Author Image" class="w-20 h-20 rounded-full mr-6 shadow-lg border-4 border-blue-500 dark:border-blue-400 transition-transform duration-300 transform hover:scale-105">
                <div>
                <h3 class="font-bold text-lg dark:text-white mb-1"><?= htmlspecialchars($data['author_name']); ?></h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4"><?= htmlspecialchars($data['author_bio']); ?></p>
                <div class="flex items-center space-x-4 mb-4">
                    <a href="#" class="text-gray-500 hover:text-blue-500">
                    <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-600">
                    <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-pink-500">
                    <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-700">
                    <i class="fab fa-linkedin text-xl"></i>
                    </a>
                </div>
                <button class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-semibold py-2 px-6 rounded-full shadow-lg transition-transform duration-300 transform hover:scale-105">
                    Follow
                </button>
                </div>
            </div>
            </div>
            <?php else: ?>
    <p>No posts available or invalid post ID.</p>
    <?php endif; ?>

    </div>

    <!-- Sidebar -->
    <div class="col-span-4 sticky top-4 h-screen overflow-auto lg:block hidden">
        <!-- latest news -->
        <div class="mb-4 rounded-lg bg-gradient-to-br from-green-50 to-white p-4 shadow-lg dark:from-green-900 dark:to-gray-700">
          <?php include_once 'app/views/components/latestnews.php'?>
        </div>

      <div class="mb-4 rounded-lg bg-gray-200 p-4 shadow-md dark:bg-gray-700">
        <h2 class="mb-2 text-xl font-bold dark:text-white">Advertisement</h2>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800">
          <img src="/api/placeholder/300/250" alt="Advertisement" class="h-auto w-full" />
        </div>
      </div>  

      <!-- recomended for you news -->

      <div class="mb-4 rounded-lg bg-gradient-to-br from-blue-50 to-white p-4 shadow-lg dark:from-blue-900 dark:to-gray-700">
      <?php include_once 'app/views/components/recomendedforyou.php'?>

      </div>

      <div class="mb-4 rounded-lg bg-gray-200 p-4 shadow-md dark:bg-gray-700">
        <h2 class="mb-2 text-xl font-bold dark:text-white">Advertisement</h2>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800">
          <img src="/api/placeholder/300/250" alt="Advertisement" class="h-auto w-full" />
        </div>
      </div>

      <!-- trending news -->
      <div class="mb-4 rounded-lg bg-gradient-to-br from-red-50 to-white p-4 shadow-lg dark:from-red-900 dark:to-gray-700">
      <?php include_once 'app/views/components/trendingnews.php'?>
      </div>

      <div class="mb-4 rounded-lg bg-gray-200 p-4 shadow-md dark:bg-gray-700">
        <h2 class="mb-2 text-xl font-bold dark:text-white">Advertisement</h2>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800">
          <img src="/api/placeholder/300/250" alt="Advertisement" class="h-auto w-full" />
        </div>
      </div>
    </div>
    <!-- mobile sidebar -->
    <div class="grid grid-cols-1 gap-6 mt-6 lg:hidden">
    <!-- Latest News -->
    <div class="mb-4 rounded-lg bg-gradient-to-br from-green-50 to-white p-4 shadow-lg dark:from-green-900 dark:to-gray-700">
        <?php include_once 'app/views/components/latestnews.php'; ?>
    </div>

    <!-- Advertisement Section -->
    <div class="mb-4 rounded-lg bg-gray-200 p-4 shadow-md dark:bg-gray-700 flex flex-col">
        <h2 class="mb-2 text-xl font-bold dark:text-white">Advertisement</h2>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800">
            <img src="/api/placeholder/300/250" alt="Advertisement" class="h-auto w-full object-cover" />
        </div>
    </div>

    <!-- Recommended For You News -->
    <div class="mb-4 rounded-lg bg-gradient-to-br from-blue-50 to-white p-4 shadow-lg dark:from-blue-900 dark:to-gray-700">
        <?php include_once 'app/views/components/recomendedforyou.php'; ?>
    </div>

    <!-- Trending News -->
    <div class="mb-4 rounded-lg bg-gradient-to-br from-red-50 to-white p-4 shadow-lg dark:from-red-900 dark:to-gray-700">
        <?php include_once 'app/views/components/trendingnews.php'; ?>
    </div>
</div>

    <!-- end -->
  </div>
</div>

<?php include 'app/views/partials/footer.php'; ?>




      <!-- trending news -->
      





