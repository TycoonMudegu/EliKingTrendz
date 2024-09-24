<?php
require_once 'app/Controllers/PostsController.php';
require_once 'app/config/dbconfig.php'; // Include your database connection

// Create the post controller
$postController = new PostController($pdo);

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Get the raw POST data (JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Ensure postId is provided and valid
if (!isset($data['postId']) || !is_numeric($data['postId'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid post ID.']);
    exit;
}

$postId = (int) $data['postId'];

try {
    // Call the controller's method to increment post views
    $postController->incrementPostViews($postId);
    echo json_encode(['success' => true, 'message' => 'View counted successfully.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . htmlspecialchars($e->getMessage())]);
}
