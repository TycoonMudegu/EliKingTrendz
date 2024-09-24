<?php

require_once 'app/Model/AuthModel.php';
require_once 'app/emails/emailfunction.php';


class AuthController {
    private $authModel;

    public function __construct($pdo) {
        $this->authModel = new AuthModel($pdo);
    }

    public function emailExists($email) {
        return $this->authModel->emailExists($email);
    }

    // Handle user registration
    public function initiateRegistration($data) {
        $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
        
        $errors = [];
        
        if (empty($email)) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }
        
        if (!empty($errors)) {
            return ['success' => false, 'error' => implode(' ', $errors)];
        }
    
        $verificationCode = $this->generateVerificationCode();
    if ($this->authModel->createVerificationCode($email, $verificationCode)) {
        // Send the verification code via email
        if (!sendVerificationEmail($email, $verificationCode)) {
            return [
                'success' => true,
                'message' => 'A verification email has been sent. Please check your email and enter the verification code to complete registration.',
                'verification_code' => $verificationCode // Return the generated code
            ];
        } else {
            return ['success' => false, 'error' => 'Failed to send verification email.'];
        }
    } else {
        return ['success' => false, 'error' => 'Failed to generate verification code.'];
    }
}

public function verifyCode($data) {
    $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $verificationCode = filter_var($data['verificationCode'] ?? '', FILTER_SANITIZE_STRING);

    // Store user input for returning in the response
    $userInput = [
        'email' => $email,
        'verification_code' => $verificationCode
    ];

    if ($this->authModel->verifyCode($email, $verificationCode)) {
        // Verification was successful, return success without proceeding to complete registration
        return [
            'success' => true,
            'message' => 'Verification successful. Please proceed to complete registration.',
            'user_input' => $userInput, // Return user input
            'verification_success' => true // Indicate that verification was successful
        ];
    } else {
        return [
            'success' => false,
            'error' => 'Invalid or expired verification code.',
            'user_input' => $userInput // Return user input
        ];
    }
}


    

public function completeRegistration($data) {
    $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars(trim($data['username'] ?? ''));
    $password = htmlspecialchars(trim($data['password'] ?? ''));
    $firstName = htmlspecialchars(trim($data['firstName'] ?? ''));
    $lastName = htmlspecialchars(trim($data['lastName'] ?? ''));
    $fullName = htmlspecialchars(trim($firstName . ' ' . $lastName));
    
    $errors = [];
    
    // Validate required fields
    if (empty($email)) {
        $errors[] = 'Email is required.';
    }
    if (empty($username)) {
        $errors[] = 'Username is required.';
    }
    if (empty($password)) {
        $errors[] = 'Password is required.';
    }
    if (empty($firstName)) {
        $errors[] = 'First name is required.';
    }
    if (empty($lastName)) {
        $errors[] = 'Last name is required.';
    }
    
    if (!empty($errors)) {
        return ['success' => false, 'error' => implode(' ', $errors)];
    }

    // Register the user
    $result = $this->authModel->registerUser($username, $password, $email, $firstName, $lastName, $fullName, true);

    if ($result === true) {
        // Delete the verification code after successful registration
        $this->authModel->deleteVerificationCode($email);
        return ['success' => true, 'message' => 'Registration complete. You are now registered.'];
    } else {
        return ['success' => false, 'error' => 'Registration failed: ' . htmlspecialchars($result)];
    }
}


    

    private function generateVerificationCode() {
        return sprintf('%06d', mt_rand(0, 999999)); // Generate a six-digit code
    }
    
    
    

    public function login($data) {
        $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = filter_var($data['password'] ?? '', FILTER_SANITIZE_STRING);
    
        if (empty($email)) {
            return ['success' => false, 'error' => 'Email is missing.'];
        } elseif (empty($password)) {
            return ['success' => false, 'error' => 'Password is missing.'];
        }
    
        // Fetch the user by email
        $user = $this->authModel->getUserByEmail($email);
    
        // Debugging: Print the user array
        error_log(print_r($user, true)); // This will log the user details to the error log
    
        if (is_array($user) && !empty($user)) {
            if (password_verify($password, $user['password'])) {
                // Check if the user is an admin
                $isAdmin = $this->authModel->isUserAdmin($user['user_id']);
                
                // Check if the user is an author
                $isAuthor = $this->authModel->isUserAuthor($user['user_id']);
    
                // Set session variables
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_email'] = $email;
                $_SESSION['user_picture'] = $user['picture'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['is_admin'] = $isAdmin; // Set admin status in session
                $_SESSION['is_author'] = $isAuthor; // Set author status in session
    
                return ['success' => true, 'message' => 'Login successful.'];
            } else {
                return ['success' => false, 'error' => 'Incorrect password.'];
            }
        } else {
            return ['success' => false, 'error' => 'Email not found.'];
        }
    }
    
    
    
}
