<?php require_once 'app/views/head.php'?>

<footer class="bg-gray-900 text-white py-8 dark:bg-black font-PTserif">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- About Section -->
            <div>
                <h2 class="text-lg font-semibold mb-4">About Us</h2>
                <p class="text-gray-400 dark:text-gray-300">Your go-to source for the latest news, insightful articles, and updates on various topics.</p>
            </div>

            <!-- Categories Section -->
            <div>
                <h2 class="text-lg font-semibold mb-4">Categories</h2>
                <ul class="text-gray-400 dark:text-gray-300">
                    <li class="mb-2"><a href="#" class="hover:underline">Politics</a></li>
                    <li class="mb-2"><a href="#" class="hover:underline">Technology</a></li>
                    <li class="mb-2"><a href="#" class="hover:underline">Health</a></li>
                    <li class="mb-2"><a href="#" class="hover:underline">Entertainment</a></li>
                </ul>
            </div>

            <!-- Meet Our Team Section -->
            <div>
                <a href="" >
                    <h2 class="text-lg font-semibold mb-4 hover:undeline">Meet Our Team</h2>
                </a>

            </div>

            <!-- Become an Author & Subscribe Section -->
            <div>
                <h2 class="text-lg font-semibold mb-4">Become an Author</h2>
                <p class="text-gray-400 dark:text-gray-300 mb-4">Join our team and share your insights with our audience. <a href="#" class="text-blue-500 hover:underline dark:text-blue-400">Apply now!</a></p>
                
                <h2 class="text-lg font-semibold mb-4">Subscribe to Our Newsletter</h2>
                <form class="flex items-center">
                    <input type="email" placeholder="Enter your email" class="px-4 py-2 text-gray-800 rounded-l focus:outline-none dark:bg-gray-700 dark:text-white">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <!-- Social Icons -->
        <div class="mt-8 flex justify-center space-x-6">
            <a href="https://t.me/eliking_m" target="_blank"  class="text-gray-400 hover:text-white"><i class="fa-brands fa-telegram"></i></a>
            <!-- <a href="#" class="text-gray-400 hover:text-white"><i class="fa-brands fa-x-twitter"></i></a> -->
            <a href="https://www.instagram.com/eliking_official" target="_blank" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
            <a href="https://www.tiktok.com/@eliking_trendz" target="_blank"  class="text-gray-400 hover:text-white"><i class="fa-brands fa-tiktok"></i></a>
            <a href="https://www.youtube.com/@elikingtrendz" target="_blank"  class="text-gray-400 hover:text-white"><i class="fa-brands fa-youtube"></i></a>

            
        </div>

        <!-- Footer Links -->
        <div class="mt-8 border-t border-gray-700 pt-4">
            <div class="flex justify-between text-gray-400 dark:text-gray-300">
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Terms of Service</a>
                <a href="#" class="hover:underline">Cookie Policy</a>
                <a href="#" class="hover:underline">Sitemap</a>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="mt-8 text-center text-gray-400 dark:text-gray-300">
            <p>&copy; <?php echo date('Y'); ?> Eliking Trendz. All rights reserved.</p>
            <p class="mt-2">Website crafted with ❤️ by <a href="#" class="text-blue-500 hover:underline dark:text-blue-400">The Mudegu Group</a>.</p>
        </div>
    </div>
</footer>

