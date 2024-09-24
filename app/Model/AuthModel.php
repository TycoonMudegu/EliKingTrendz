<?php

class AuthModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function createVerificationCode($email, $code) {
        // Insert or update the verification code for the email
        $stmt = $this->pdo->prepare("INSERT INTO verification_codes (email, code) VALUES (?, ?) ON DUPLICATE KEY UPDATE code = VALUES(code), created_at = CURRENT_TIMESTAMP");
        return $stmt->execute([$email, $code]);
    }

    public function verifyCode($email, $code) {
        // Fetch the code for the given email
        $stmt = $this->pdo->prepare("SELECT code FROM verification_codes WHERE email = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$email]);
        $storedCode = $stmt->fetchColumn();
        return $storedCode === $code;
    }

    public function deleteVerificationCode($email) {
        // Delete the verification code for the given email after successful verification
        $stmt = $this->pdo->prepare("DELETE FROM verification_codes WHERE email = ?");
        return $stmt->execute([$email]);
    }

    public function updateUserVerificationStatus($email) {
        // Get user ID by email
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $userId = $stmt->fetchColumn();
        
        if ($userId) {
            $stmt = $this->pdo->prepare("UPDATE users SET email_verified = 1 WHERE user_id = ?");
            return $stmt->execute([$userId]);
        }
        
        return false;
    }

    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Method to register a new user
    public function registerUser($username, $password, $email, $firstName, $lastName, $fullName, $verifiedEmail = 1) {
        try {
            $sql = "INSERT INTO users (username, password, email, first_name, last_name, full_name, verifiedEmail) VALUES (:username, :password, :email, :firstName, :lastName, :fullName, :verifiedEmail)";
            $stmt = $this->pdo->prepare($sql);

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Bind parameters
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':verifiedEmail', $verifiedEmail);

            // Execute the statement
            if ($stmt->execute()) {
                return true; // Registration successful
            } else {
                return $stmt->errorInfo()[2]; // Return error message
            }
        } catch (PDOException $e) {
            return $e->getMessage(); // Return PDO error message
        }
    }

    public function isUserAdmin($userId) {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM admins WHERE user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchColumn() > 0; // Returns true if user is found in admin table
    }
    
    public function isUserAuthor($userId) {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM authors WHERE user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchColumn() > 0; // Returns true if user is found in authors table
    }
    

    // Method to get user by email
    public function getUserByEmail($email) {
        // Prepare SQL query
        $sql = "SELECT * FROM users WHERE email = :email";
        
        // Prepare statement
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch the user
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user;
    }
    
}
