<?php
session_start();

// Get the current URI
$uri = $_SERVER['REQUEST_URI'];

// Extract the path before the query string
$path = parse_url($uri, PHP_URL_PATH);

// Define the base directory
$baseDir = '/eblog';

// Remove base directory from the path
$path = str_replace($baseDir, '', $path);

// Define routes
$routes = [
    '/' => 'app/views/Home.php',
    '/Home' => 'app/views/Home.php',
    '/Signup' => 'app/views/signin.php',
    '/Auth' => 'app/Controllers/Auth.php',

    '/Post' => 'app/views/posts.php',
    '/Category/([a-zA-Z0-9_-]+)' => 'app/views/category.php', // Dynamic category route

    '/post/Trending' => 'app/Controllers/incrementViews.php',

    '/AuthorProfile' => 'app/views/authordash.php',
    '/Stories' => 'app/views/stories.php',
    '/Write' => 'app/views/writepost.php',
    '/PostProcess' => 'app/Controllers/Postinput.php',
    '/Author' => 'app/Controllers/Authorinput.php',

    '/AdminDash' => 'app/views/admin/admindash..php',





    '/Logout' => 'app/Controllers/logout.php',

    '/test' => 'app/emails/emailtest.php',

    // Define a pattern for dynamic routes
    '/post/([0-9]+)' => 'app/views/posts.php', // Example dynamic route
];

// Route matching
$found = false;
foreach ($routes as $pattern => $file) {
    // Check if the pattern is a dynamic route
    if (strpos($pattern, '(') !== false) {
        // Convert pattern to regex
        $regex = str_replace('/', '\/', $pattern);
        // Escape special characters in the regex and ensure proper delimiters
        $regex = '/^' . $regex . '$/';
        
        if (preg_match($regex, $path, $matches)) {
            // Remove baseDir from the matches
            array_shift($matches);
            // Pass parameters to the PHP file if needed
            require_once $file;
            $found = true;
            break;
        }
    } else {
        // Static route matching
        if ($path == $pattern) {
            require_once $file;
            $found = true;
            break;
        }
    }
}

if (!$found) {
    // If no route matches, include the 404 page
    require_once 'app/views/partials/404.php';
}
