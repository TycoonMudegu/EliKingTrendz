<?php
require_once 'app/config/dbconfig.php'; // Include your PDO connection
require_once 'app/Controllers/AuthorController.php';

$controller = new AuthorController ($pdo);

// Determine the action to be performed
$action = isset($_POST['action']) ? $_POST['action'] : null;

// Fetch the user ID from the session
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

switch ($action) {
    case 'getUser':
        // Fetch user details
        if ($userId) {
            $author = $controller->getAuthorById($userId);
            echo json_encode($author);
        } else {
            echo json_encode(['error' => 'User ID not found in session']);
        }
        break;

    case 'updateUser':
        // Update user details
        $data = $_POST;
        if ($userId) {
            $updated = $controller->updateUser(
                $userId, 
                isset($data['username']) ? $data['username'] : null, 
                isset($data['website']) ? $data['website'] : null, 
                isset($data['bio']) ? $data['bio'] : null, 
                isset($data['github']) ? $data['github'] : null, 
                isset($data['twitter']) ? $data['twitter'] : null, 
                isset($data['instagram']) ? $data['instagram'] : null
            );
            echo json_encode(['success' => $updated]);
        } else {
            echo json_encode(['error' => 'User ID not found in session']);
        }
        break;

    default:
        // Handle invalid or missing action
        echo json_encode(['error' => 'Invalid action']);
        break;
}