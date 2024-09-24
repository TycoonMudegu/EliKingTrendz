<?php
// PostProcess.php
include 'app/config/dbconfig.php';
require_once 'app/Controllers/PostsController.php';

$postController = new PostController($pdo);

// Get the raw POST data and decode it (since it's being sent as JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Get the raw POST data and files
$action = $_POST['action'] ?? '';
// $action = $data['action'] ?? '';
$title = $data['title'] ?? '';
$categoryId = $data['category'] ?? '';
$content = $data['content'] ?? '';
$postId = $data['id'] ?? null; // Retrieve the post ID if present
$postid = $_POST['post_id'] ?? null; // Retrieve the post ID if present
$userid = $data['userid'] ?? null;

// Set default values for image and isBreaking
$image = null; // Default value for image
$isBreaking = 0; // Default value for isBreaking

// Set the content type for JSON response
header('Content-Type: application/json');

// Process the image upload if action is 'publish' and image is provided
if ($action === 'publish' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'eblog/app/assets/images/postsuploads/'; // Use relative path
    $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $imageName = uniqid() . '.' . $imageFileType;
    $imagePath = $uploadDir . $imageName;

    // Check if the directory exists; if not, try to create it
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            // echo json_encode(['error' => 'Failed to create the upload directory.', 'path' => $uploadDir]);
            exit;
        } else {
            // echo json_encode(['success' => 'Upload directory created successfully.', 'path' => $uploadDir]);
        }
    }

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check === false) {
        echo json_encode(['error' => 'File is not an image.']);
        exit;
    }

    // Check file size (limit to 5MB)
    if ($_FILES['image']['size'] > 5000000) {
        echo json_encode(['error' => 'Sorry, your file is too large.']);
        exit;
    }

    // Allow certain file formats
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo json_encode(['error' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
        exit;
    }

    // Attempt to move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $image = $imagePath; // Set the image path to be used later
    } else {
        echo json_encode(['error' => 'Sorry, there was an error uploading your file.']);
        exit;
    }
} else {
    $image = ''; // No image upload in other actions
}

// Prepare the result variable for consistency
$result = [];

// Pass the directory path along with other data to the model
switch ($action) {
    case 'create':
    case 'update':
        // Validate required fields
        if (empty($title) || empty($content)) {
            echo json_encode(['error' => 'Title and content are required.']);
            exit;
        }

        if ($postId) {
            // If postId is present, update the post
            $result = $postController->updatePost($postId, $userid, $title, $content, $image, $categoryId, $isBreaking);
        } else {
            // If no postId, create a new post
            $result = $postController->createPost($title, $content, $image, $categoryId, $isBreaking);
        }
        break;

    case 'publish':
        // Validate required fields
        if (empty($postid)) {
            echo json_encode(['error' => 'Post ID is required for publishing.']);
            exit;
        }

        // Publish the post with the image path and directory
        $result = $postController->publishPost($postid, $image, $uploadDir);
        break;

    case 'unpublish':
        // Validate required fields
        if (empty($postid)) {
            echo json_encode(['error' => 'Post ID is required for unpublishing.']);
            exit;
        }

        // Unpublish the post
        $result = $postController->unpublishPost($postid);
        break;

    default:
        echo json_encode(['error' => 'Invalid action.', 'received_action' => $action]);
        exit;
}

// Output the result as JSON
echo json_encode($result);
