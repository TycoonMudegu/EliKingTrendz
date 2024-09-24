<?php 
require_once 'app/views/head.php';
require_once 'app/config/dbconfig.php';
// Include necessary files
require_once 'app/Controllers/PostsController.php';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$userPicture = $isLoggedIn ? $_SESSION['user_picture'] : '';
$fullName = $isLoggedIn ? $_SESSION['full_name'] : '';
$isAdmin = $isLoggedIn ? $_SESSION['is_admin'] : false;
$isAuthor = $isLoggedIn ? $_SESSION['is_author'] : false;
$isUser = $isLoggedIn && !$isAdmin && !$isAuthor;
// Create a new PostController instance
$postController = new PostController($pdo);

$categories = $postController->getCategories();

function encodeId($id) {
    return base64_encode($id);
}

?>

    <style>
        .search-input {
            border-bottom: 2px solid #cbd5e0;
            transition: border-color 0.3s ease;
        }
        .search-input:focus {
            outline: none;
            border-color: #4a5568;
        }
        .dark .search-input {
            border-color: #4a5568;
        }
        .dark .search-input:focus {
            border-color: #cbd5e0;
        }
    </style>
   <div class="bg-white dark:bg-black shadow-md font-PTserif">
   <header class="bg-white dark:bg-gray-800 shadow-md">
        <!-- Top bar with logo and user actions -->
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="Home">
                    <h1 class="logo text-2xl md:text-3xl font-bold text-orange-400">Elikingtrends</h1>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <button id="theme-toggle" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="bx bx-sun text-lg md:text-xl" id="theme-toggle-icon"></i>
                </button>
                <button id="search-toggle" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="bx bx-search text-lg md:text-xl"></i>
                </button>
                <?php if ($isLoggedIn): ?>
                    <div x-data="{ open: false }" class="relative inline-block text-left">
                        <button @click="open = !open" class="flex items-center border border-gray-300 rounded-full p-1 text-gray-700 hover:text-white hover:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-800 transition duration-200">
                            <img src="<?php echo htmlspecialchars($userPicture); ?>" alt="<?php echo htmlspecialchars($fullName); ?>" class="w-8 h-8 rounded-full">
                            <span><?php echo htmlspecialchars($fullName); ?></span>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg z-50">
                            <ul class="py-1 text-gray-700 dark:text-gray-300">
                                <?php if ($isAdmin): ?>
                                    <li><a href="AdminDash" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Admin Dashboard</a></li>
                                <?php endif; ?>
                                <?php if ($isAuthor): ?>
                                    <li><a href="AuthorProfile" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Author Profile</a></li>
                                    <li><a href="Stories" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">My Posts</a></li>
                                <?php endif; ?>
                                <?php if ($isUser): ?>
                                    <li><a href="user_dashboard.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</a></li>
                                <?php endif; ?>
                                <li><a href="Logout" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="Signup" class="inline-block">
                        <button class="flex items-center space-x-2 border border-gray-300 rounded px-4 py-2 text-gray-700 hover:text-white hover:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-800 transition duration-200">
                            <span>Log In</span>
                            <i class="bx bx-log-in text-sm"></i>
                        </button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Main navigation -->
        <nav class="bg-gray-800 dark:bg-gray-700 sticky top-0 z-30">
                <div class="container mx-auto px-4">
                    <ul class="flex flex-wrap justify-center space-x-2 md:space-x-8 py-2 md:py-3 md:justify-between">
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="Category/<?php echo urlencode($category['name']); ?>" class="text-white text-sm md:text-base hover:text-gray-300 hover:underline">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="#" class="text-white text-sm md:text-base">No categories found</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
    </header>

    <!-- Search bar (hidden by default) -->
    <div id="search-bar" class="hidden bg-white dark:bg-black py-4 transition-all duration-300 mt-2">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <input type="text" placeholder="What do you want to read..." class="search-input flex-grow bg-transparent text-gray-700 dark:text-gray-300 text-base md:text-lg px-2 py-1">
                <button id="search-cancel" class="ml-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <i class="bx bx-x h-6 w-6"></i>
                </button>
            </div>
        </div>
    </div>
</div>





        <!-- <hr> -->
    <!-- Search bar -->
    <!-- <div id="search-bar" class="hidden bg-white dark:bg-black py-4 transition-all duration-300 mt-2">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <input type="text" placeholder="What do you want to read..." class="search-input flex-grow bg-transparent text-gray-700 dark:text-gray-300 text-lg px-2 py-1">
                <button id="search-cancel" class="ml-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <i class="fas fa-times h-6 w-6"></i>
                </button>
            </div>
        </div>
    </div> -->

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleIcon = document.getElementById('theme-toggle-icon');
        const searchToggleBtn = document.getElementById('search-toggle');
        const searchBar = document.getElementById('search-bar');
        const searchCancelBtn = document.getElementById('search-cancel');

        // Function to set the theme
        function setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                themeToggleIcon.classList.remove('bx-sun');
                themeToggleIcon.classList.add('bx-moon');
            } else {
                document.documentElement.classList.remove('dark');
                themeToggleIcon.classList.remove('bx-moon');
                themeToggleIcon.classList.add('bx-sun');
            }
            localStorage.setItem('color-theme', theme);
        }

        // Check for saved theme preference or prefer-color-scheme
        const savedTheme = localStorage.getItem('color-theme');
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

        if (savedTheme) {
            setTheme(savedTheme);
        } else if (prefersDarkScheme.matches) {
            setTheme('dark');
        } else {
            setTheme('light');
        }

        // Toggle theme when button is clicked
        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            setTheme(currentTheme === 'dark' ? 'light' : 'dark');
        });

        // Toggle search bar
        searchToggleBtn.addEventListener('click', () => {
            searchBar.classList.toggle('hidden');
            searchBar.querySelector('input').focus();
        });

        // Hide search bar when cancel button is clicked
        searchCancelBtn.addEventListener('click', () => {
            searchBar.classList.add('hidden');
        });

        document.getElementById("profileMenuButton").addEventListener("click", function() {
            var menu = document.getElementById("profileMenu");
            menu.classList.toggle("show");
        });

    </script>




