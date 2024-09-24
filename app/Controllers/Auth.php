<?php
include 'app/config/dbconfig.php';
include 'app/controllers/AuthController.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false, 'message' => ''];

$authController = new AuthController($pdo);

// Check if action is set
if (!isset($data['action'])) {
    $response['message'] = 'Action is required.';
    echo json_encode($response);
    exit;
}

// Handle different actions
switch ($data['action']) {
    case 'checkEmail':
        $email = $data['email'] ?? '';

        if (empty($email)) {
            $response['message'] = 'Email is required.';
        } else {
            if ($authController->emailExists($email)) {
                $response['exists'] = true;
                $response['message'] = 'Email exists.';
            } else {
                // Email not found, proceed to initiate registration
                $registrationResult = $authController->initiateRegistration($data);
                $response = array_merge($response, $registrationResult);
            }
        }
        break;

    case 'verifyCode':
        $verificationResult = $authController->verifyCode($data);
        $response = array_merge($response, $verificationResult);

        break;

    case 'login':
        $loginResult = $authController->login($data);
        $response = array_merge($response, $loginResult);
        break;

    case 'register':
        $registrationResult = $authController->completeRegistration($data);
        $response = array_merge($response, $registrationResult);
        break;

    default:
        $response['message'] = 'Invalid action.';
        break;
}

echo json_encode($response);
