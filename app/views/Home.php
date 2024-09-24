
<?php require_once 'app/views/partials/navbar.php';
require_once 'app/Model/PostsModel.php'; // Ensure the path is correct based on your directory structure

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
$breakingNews = $postController->getBreakingNews(3);
$mostRecentNews = $postController->getMostRecentNews(6);
$trendingNews = $postController->getTrendingNews(5);

function truncateContent($content, $length = 180) {
  if (mb_strlen($content) > $length) {
      return mb_substr($content, 0, $length) . '...';
  }
  return $content;
}

// var_dump(value: $breakingNews);
?>

<style>
    #news-carousel .carousel-inner {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    #news-carousel .carousel-item {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    #news-carousel .carousel-item.active {
        display: block;
        position: relative;
    }


    .bg-opacity-80 {
        background-opacity: 0.8;
    }

    @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient {
            animation: gradientShift 3s ease infinite;
        }
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }
        .playfair {
            font-family: 'Playfair Display', serif;
        }
        .news-item {
            transition: all 0.3s ease;
        }
        .news-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .news-item:hover h1,
        .news-item:hover h2,
        .news-item:hover h3 {
            text-decoration: underline;
        }

        #newsletter-modal {
    display: none; /* Hidden by default */
        }

        #newsletter-modal.show {
            display: flex; /* Show modal */
        }


</style>


<section class="bg-gray-200 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-200 font-PTserif">
<main class="mx-auto px-4 py-4 w-full">
    <section class="mb-8 w-full">
        <div class="mb-8 w-full" style="height: auto; min-height: 400px;">
            <!-- Main Featured Story (Carousel) -->
            <div class="lg:col-span-2 w-full" id="news-carousel">
                <div class="carousel-inner">
                    <?php if (!empty($breakingNews)): ?>
                        <?php foreach ($breakingNews as $index => $newsItem): ?>
                            <div class="carousel-item relative bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden news-item h-64 lg:h-[70vh] w-full <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img class="w-full h-full object-cover max-h-[70vh]" src="<?php echo htmlspecialchars($newsItem['image']); ?>" alt="Featured story image">
                                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent">
                                    <div class="absolute bottom-0 left-0 p-4 max-w-3xl">
                                        <span class="inline-block bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded mb-2">Breaking News</span>
                                        <h1 class="text-lg md:text-xl lg:text-3xl font-bold text-white playfair mb-2">
                                            <?php echo htmlspecialchars($newsItem['title']); ?>
                                        </h1>
                                        <p class="text-xs md:text-sm lg:text-md text-gray-200 mb-2 line-clamp-2">
                                            <?php echo htmlspecialchars(truncateContent($newsItem['content'])); ?>
                                        </p>
                                        <a href="post/<?php echo htmlspecialchars($newsItem['posts_id']); ?>" class="text-white hover:text-blue-200 text-sm font-medium mt-2 inline-flex items-center">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Carousel Controls -->
                <button id="prevBtn" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full">‹</button>
                <button id="nextBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full">›</button>
            </div>
        </div>
    </section>
</main>





    

<section>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">LATEST</h1>
        <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
            <?php foreach ($mostRecentNews as $post): ?>
                <a href="post/<?= htmlspecialchars($post['posts_id']) ?>" 
                   onclick="incrementPostViews(<?= htmlspecialchars($post['posts_id']) ?>)"
                   class="flex-none w-64 group">
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden shadow-md transition-all duration-300 ease-in-out hover:shadow-lg">
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" 
                             alt="<?php echo htmlspecialchars(substr($post['title'], 0, 5)); ?>" 
                             class="w-full h-32 object-cover">
                        <div class="p-4">
                            <h2 class="text-sm font-semibold mb-2 group-hover:underline group-hover:text-blue-500 transition-all duration-300">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </h2>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>



<section class="mb-8 mt-8 border border-gray-600">
            <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-2 text-center border">
                <p class="text-xs text-gray-500 dark:text-gray-400">Advertisement</p>
                <!-- Replace this div with your actual Google Ads code -->
                <div class="bg-white dark:bg-gray-600 h-16 flex items-center justify-center">
                    <p class="text-gray-400 dark:text-gray-500">Google Ads Placeholder</p>
                </div>
            </div>
        </section>

    

  <section>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden p-4 my-4">
        <!-- Category Title -->
        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-3 uppercase tracking-wide relative inline-block">
            Politics
            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform scale-x-0 transition-transform duration-300 origin-left group-hover:scale-x-100"></span>
        </h2>
    
        <!-- Main Story -->
        <?php if (!empty($politicsPosts)): ?>
            <?php $mainPost = array_shift($politicsPosts); // Get the first post for the main story ?>
            <div class="flex mb-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg shadow-md overflow-hidden">
                <img src="<?php echo htmlspecialchars($mainPost['image']); ?>" alt="<?php echo htmlspecialchars(substr($mainPost['title'], 0, 5)); ?>" class="w-1/3 object-cover">
                <div class="p-4 flex flex-col justify-between w-2/3">
                    <div>
                        <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($mainPost['title']); ?></h3>
                        <p class="text-sm text-gray-100"><?php echo htmlspecialchars(truncateContent($mainPost['content'])); ?></p>
                    </div>
                    <a href="post/<?php echo htmlspecialchars($mainPost['posts_id']); ?>" class="text-white hover:text-blue-200 text-sm font-medium mt-2 inline-flex items-center">
                        Read full story
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
    
            <!-- Small Stories with Images -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                <?php foreach ($politicsPosts as $post): ?>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded shadow-sm hover:shadow-md transition-shadow group">
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars(substr($post['title'], 0, 5)); ?>" class="w-full h-24 object-cover rounded-t">
                        <div class="p-2">
                          <a href="post/<?= htmlspecialchars($post['posts_id']) ?>" 
                             onclick="incrementPostViews(<?= htmlspecialchars($post['posts_id']) ?>)"
                            <h4 class="font-medium text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 text-sm">
                                <?php echo htmlspecialchars($post['title']); ?>
                                <span class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-blue-600 dark:bg-blue-400"></span>
                            </h4>
                            </a>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1"><?php echo truncateContent($post['content']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    
            <!-- Read More Button -->
            <div class="text-center">
                <a href="#" class="inline-block px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-blue-700 transition-colors duration-300 transform hover:scale-105">
                    More Politics News
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 dark:text-gray-400">No political news available at the moment.</p>
        <?php endif; ?>
    </div>
</section>


<section class="mb-8 mt-8">
            <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-2 text-center border">
                <p class="text-xs text-gray-500 dark:text-gray-400">Advertisement</p>
                <!-- Replace this div with your actual Google Ads code -->
                <div class="bg-white dark:bg-gray-600 h-16 flex items-center justify-center">
                    <p class="text-gray-400 dark:text-gray-500">Google Ads Placeholder</p>
                </div>
            </div>
        </section>


  <section>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden p-4 my-4">
        <!-- Category Title -->
        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-3 uppercase tracking-wide relative inline-block">
            Business
            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform scale-x-0 transition-transform duration-300 origin-left group-hover:scale-x-100"></span>
        </h2>
    
        <!-- Main Story -->
        <?php if (!empty($businessPosts)): ?>
            <?php $mainPost = array_shift($businessPosts); // Get the first post for the main story ?>
            <div class="flex mb-4 bg-gradient-to-r from-green-500 to-green-900 text-white rounded-lg shadow-md overflow-hidden">
                <img src="<?php echo htmlspecialchars($mainPost['image']); ?>" alt="<?php echo htmlspecialchars(substr($mainPost['title'], 0, 5)); ?>" class="w-1/3 object-cover">
                <div class="p-4 flex flex-col justify-between w-2/3">
                    <div>
                        <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($mainPost['title']); ?></h3>
                        <p class="text-sm text-gray-100"><?php echo truncateContent($mainPost['content']); ?></p>
                    </div>
                    <a href="post/<?php echo htmlspecialchars($mainPost['posts_id']); ?>" class="text-white hover:text-blue-200 text-sm font-medium mt-2 inline-flex items-center">
                        Read full story
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
    
            <!-- Small Stories with Images -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                <?php foreach ($businessPosts as $post): ?>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded shadow-sm hover:shadow-md transition-shadow group">
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars(substr($post['title'], 0, 5)); ?>" class="w-full h-24 object-cover rounded-t">
                        <div class="p-2">
                          <a href="post/<?= htmlspecialchars($post['posts_id']) ?>" 
                             onclick="incrementPostViews(<?= htmlspecialchars($post['posts_id']) ?>)"
                            <h4 class="font-medium text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 text-sm">
                                <?php echo htmlspecialchars($post['title']); ?>
                                <span class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-blue-600 dark:bg-blue-400"></span>
                            </h4>
                            </a>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1"><?php echo truncateContent($post['content']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    
            <!-- Read More Button -->
            <div class="text-center">
                <a href="#" class="inline-block px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-green-700 transition-colors duration-300 transform hover:scale-105">
                    More Busines News
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 dark:text-gray-400">No Busines news available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<section class="mb-8 mt-8">
            <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-2 text-center border">
                <p class="text-xs text-gray-500 dark:text-gray-400">Advertisement</p>
                <!-- Replace this div with your actual Google Ads code -->
                <div class="bg-white dark:bg-gray-600 h-16 flex items-center justify-center">
                    <p class="text-gray-400 dark:text-gray-500">Google Ads Placeholder</p>
                </div>
            </div>
        </section>


  <section>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden p-4 my-4">
        <!-- Category Title -->
        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-3 uppercase tracking-wide relative inline-block">
            Technology
            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform scale-x-0 transition-transform duration-300 origin-left group-hover:scale-x-100"></span>
        </h2>
    
        <!-- Main Story -->
        <?php if (!empty($technologyPosts)): ?>
            <?php $mainPost = array_shift($technologyPosts); // Get the first post for the main story ?>
            <div class="flex mb-4 bg-gradient-to-r from-cyan-500 to-sky-900 text-white rounded-lg shadow-md overflow-hidden">
                <img src="<?php echo htmlspecialchars($mainPost['image']); ?>" alt="<?php echo htmlspecialchars(substr($mainPost['title'], 0, 5)); ?>" class="w-1/3 object-cover">
                <div class="p-4 flex flex-col justify-between w-2/3">
                    <div>
                        <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($mainPost['title']); ?></h3>
                        <p class="text-sm text-gray-100"><?php echo truncateContent($mainPost['content']); ?></p>
                    </div>
                    <a href="post/<?php echo htmlspecialchars($mainPost['posts_id']); ?>" class="text-white hover:text-blue-200 text-sm font-medium mt-2 inline-flex items-center">
                        Read full story
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
    
            <!-- Small Stories with Images -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                <?php foreach ($technologyPosts as $post): ?>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded shadow-sm hover:shadow-md transition-shadow group">
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars(substr($post['title'], 0, 5)); ?>" class="w-full h-24 object-cover rounded-t">
                        <div class="p-2">
                          <a href="post/<?= htmlspecialchars($post['posts_id']) ?>" 
                             onclick="incrementPostViews(<?= htmlspecialchars($post['posts_id']) ?>)"
                            <h4 class="font-medium text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 text-sm">
                                <?php echo htmlspecialchars($post['title']); ?>
                                <span class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-blue-600 dark:bg-blue-400"></span>
                            </h4>
                            </a>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1"><?php echo truncateContent($post['content']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    
            <!-- Read More Button -->
            <div class="text-center">
                <a href="#" class="inline-block px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-sky-700 transition-colors duration-300 transform hover:scale-105">
                    More Technology News
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 dark:text-gray-400">No Technology news available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<section class="mb-8 mt-8">
            <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-2 text-center border">
                <p class="text-xs text-gray-500 dark:text-gray-400">Advertisement</p>
                <!-- Replace this div with your actual Google Ads code -->
                <div class="bg-white dark:bg-gray-600 h-16 flex items-center justify-center">
                    <p class="text-gray-400 dark:text-gray-500">Google Ads Placeholder</p>
                </div>
            </div>
        </section>

  <section>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden p-4 my-4">
        <!-- Category Title -->
        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-3 uppercase tracking-wide relative inline-block">
            Entertainment
            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform scale-x-0 transition-transform duration-300 origin-left group-hover:scale-x-100"></span>
        </h2>
    
        <!-- Main Story -->
        <?php if (!empty($entertainmentPosts)): ?>
            <?php $mainPost = array_shift($entertainmentPosts); // Get the first post for the main story ?>
            <div class="flex mb-4 bg-gradient-to-r from-red-500 to-red-800 text-white rounded-lg shadow-md overflow-hidden">
                <img src="<?php echo htmlspecialchars($mainPost['image']); ?>" alt="<?php echo htmlspecialchars(substr($mainPost['title'], 0, 5)); ?>" class="w-1/3 object-cover">
                <div class="p-4 flex flex-col justify-between w-2/3">
                    <div>
                        <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($mainPost['title']); ?></h3>
                        <p class="text-sm text-gray-100"><?php echo truncateContent($mainPost['content']); ?></p>
                    </div>
                    <a href="post/<?php echo htmlspecialchars($mainPost['posts_id']); ?>" class="text-white hover:text-blue-200 text-sm font-medium mt-2 inline-flex items-center">
                        Read full story
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
    
            <!-- Small Stories with Images -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                <?php foreach ($entertainmentPosts as $post): ?>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded shadow-sm hover:shadow-md transition-shadow group">
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars(substr($post['title'], 0, 5)); ?>" class="w-full h-24 object-cover rounded-t">
                        <div class="p-2">
                          <a href="post/<?= htmlspecialchars($post['posts_id']) ?>" 
                             onclick="incrementPostViews(<?= htmlspecialchars($post['posts_id']) ?>)"
                            <h4 class="font-medium text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 text-sm">
                                <?php echo htmlspecialchars($post['title']); ?>
                                <span class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-blue-600 dark:bg-blue-400"></span>
                            </h4>
                            </a>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1"><?php echo truncateContent($post['content']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    
            <!-- Read More Button -->
            <div class="text-center">
                <a href="#" class="inline-block px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-red-700 transition-colors duration-300 transform hover:scale-105">
                    More Entertainment News
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 dark:text-gray-400">No Entertainment news available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<section class="mb-8 mt-8">
            <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-2 text-center border">
                <p class="text-xs text-gray-500 dark:text-gray-400">Advertisement</p>
                <!-- Replace this div with your actual Google Ads code -->
                <div class="bg-white dark:bg-gray-600 h-16 flex items-center justify-center">
                    <p class="text-gray-400 dark:text-gray-500">Google Ads Placeholder</p>
                </div>
            </div>
        </section>


  <section>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden p-4 my-4">
        <!-- Category Title -->
        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-3 uppercase tracking-wide relative inline-block">
            Science
            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform scale-x-0 transition-transform duration-300 origin-left group-hover:scale-x-100"></span>
        </h2>
    
        <!-- Main Story -->
        <?php if (!empty($healthPosts)): ?>
            <?php $mainPost = array_shift($healthPosts); // Get the first post for the main story ?>
            <div class="flex mb-4 bg-gradient-to-r from-indigo-500 to-purple-900 text-white rounded-lg shadow-md overflow-hidden">
                <img src="<?php echo htmlspecialchars($mainPost['image']); ?>" alt="<?php echo htmlspecialchars(substr($mainPost['title'], 0, 5)); ?>" class="w-1/3 object-cover">
                <div class="p-4 flex flex-col justify-between w-2/3">
                    <div>
                        <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($mainPost['title']); ?></h3>
                        <p class="text-sm text-gray-100"><?php echo htmlspecialchars(truncateContent($mainPost['content'])); ?></p>
                    </div>
                    <a href="post/<?php echo htmlspecialchars($mainPost['posts_id']); ?>" class="text-white hover:text-blue-200 text-sm font-medium mt-2 inline-flex items-center">
                        Read full story
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
    
            <!-- Small Stories with Images -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                <?php foreach ($healthPosts as $post): ?>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded shadow-sm hover:shadow-md transition-shadow group">
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars(substr($post['title'], 0, 5)); ?>" class="w-full h-24 object-cover rounded-t">
                        <div class="p-2">
                          <a href="post/<?= htmlspecialchars($post['posts_id']) ?>" 
                             onclick="incrementPostViews(<?= htmlspecialchars($post['posts_id']) ?>)"
                            <h4 class="font-medium text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 text-sm">
                                <?php echo htmlspecialchars($post['title']); ?>
                                <span class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-0.5 bg-blue-600 dark:bg-blue-400"></span>
                            </h4>
                            </a>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1"><?php echo truncateContent($post['content']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    
            <!-- Read More Button -->
            <div class="text-center">
                <a href="#" class="inline-block px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-green-700 transition-colors duration-300 transform hover:scale-105">
                    More Health News
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 dark:text-gray-400">No Health news available at the moment.</p>
        <?php endif; ?>
    </div>
</section>


 </section>

 <!-- newsletter section -->
<div id="newsletter-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-gray-900 bg-opacity-50">
  <div class="relative mx-auto my-5 max-w-4xl rounded-lg bg-indigo-100 shadow-lg font-PTserif">
  <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2 top-2 h-6 w-6 cursor-pointer" id="close-modal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
  </svg>
  <div class="p-8 md:p-12 lg:px-16">
    <div class="max-w-lg">
      <h2 class="text-2xl font-bold text-indigo-900 md:text-3xl">Subscribe to our newsletter stay ahead</h2>

      <p class="hidden text-indigo-900 sm:mt-4 sm:block">Be the first to get notified when we drop our news.!</p>
    </div>

    <div class="mt-8 max-w-xl">
      <form action="#" class="sm:flex sm:gap-4">
        <div class="sm:flex-1">
          <label for="email" class="sr-only">Email</label>

          <input type="email" placeholder="Email address" class="w-full rounded-md border-indigo-200 bg-white p-3 text-indigo-700 shadow-sm transition focus:border-white focus:outline-none focus:ring focus:ring-indigo-400" />
        </div>

        <button type="submit" class="group mt-4 flex w-full items-center justify-center rounded-md bg-indigo-600 px-5 py-3 text-white transition focus:outline-none focus:ring focus:ring-indigo-400 sm:mt-0 sm:w-auto">
          <span class="text-sm font-medium"> Sign Up </span>

          <svg class="ml-3 h-5 w-5 transition-all group-hover:translate-x-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
          </svg>
        </button>
      </form>
    </div>
  </div>
</div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {

    $(document).ready(function () {
    var currentIndex = 0;
    var totalItems = $('#news-carousel .carousel-item').length;

    function showCarouselItem(index) {
        $('#news-carousel .carousel-item').removeClass('active');
        $('#news-carousel .carousel-item').eq(index).addClass('active');
    }

    // Show the first item by default
    showCarouselItem(currentIndex);

    // Next button click
    $('#nextBtn').on('click', function () {
        currentIndex = (currentIndex + 1) % totalItems;
        showCarouselItem(currentIndex);
    });

    // Previous button click
    $('#prevBtn').on('click', function () {
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        showCarouselItem(currentIndex);
    });

    // Auto-slide every 5 seconds
    setInterval(function () {
        currentIndex = (currentIndex + 1) % totalItems;
        showCarouselItem(currentIndex);
    }, 5000);
});

    // Function to show the modal

    function showNewsletterModal() {
        const modal = document.getElementById('newsletter-modal');
        modal.classList.add('show');
    }

    // Function to hide the modal
    function hideNewsletterModal() {
        const modal = document.getElementById('newsletter-modal');
        modal.classList.remove('show');
    }

    // Set timeout to show modal after 5 seconds
    setTimeout(showNewsletterModal, 10000);

    // Handle close button click
    const closeButton = document.getElementById('close-modal');
    closeButton.addEventListener('click', hideNewsletterModal);

    // Handle form submission
    const form = document.getElementById('newsletter-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        // Handle form submission logic here (e.g., AJAX request)
        alert('Subscription form submitted');
        hideNewsletterModal();
    });
});

</script>



<?php include 'app/views/partials/footer.php'; ?>
