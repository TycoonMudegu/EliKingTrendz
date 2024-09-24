<?php
class AuthorModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fetch user details by ID
    public function getAuthorById($userId) {
        $stmt = $this->pdo->prepare("SELECT username, email, picture, instagram, twitter, facebook FROM users WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]); // Use the same placeholder name
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    

    // Update user details
    public function updateUser($id, $username, $website, $bio, $github, $twitter, $instagram) {
        $stmt = $this->pdo->prepare("UPDATE users SET username = :username, website = :website, bio = :bio, github = :github, twitter = :twitter, instagram = :instagram WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'username' => $username,
            'website' => $website,
            'bio' => $bio,
            'github' => $github,
            'twitter' => $twitter,
            'instagram' => $instagram
        ]);
    }
}
