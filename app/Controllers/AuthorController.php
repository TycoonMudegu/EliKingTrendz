<?php
require_once 'app/Model/AuthorModel.php';

class AuthorController {
    private $authorModel;

    public function __construct($pdo) {
        $this->authorModel = new AuthorModel($pdo);
    }

    // Retrieve user details
    public function getAuthorById($userId) {
        return $this->authorModel->getAuthorById($userId);
    }

    // Update user details
    public function updateUser($id, $username, $website, $bio, $github, $twitter, $instagram) {
        return $this->authorModel->updateUser($id, $username, $website, $bio, $github, $twitter, $instagram);
    }
}
