<?php
class AdminModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fetch the total number of posts (formerly articles)
    public function getTotalPosts() {
        $query = "SELECT COUNT(*) as total_posts FROM posts";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_posts'];
    }

    // Fetch the total number of views from the posts table
    public function getTotalViews() {
        $query = "SELECT SUM(views_count) as total_views FROM posts";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_views'];
    }

    // Fetch the number of new subscribers from the users table where `created_at` is today
    public function getNewSubscribers() {
        $query = "SELECT COUNT(*) as total_subscribers FROM users WHERE DATE(created_at) = CURDATE()";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_subscribers'];
    }

    // Fetch the number of new comments where the creation date is today
    public function getNewComments() {
        $query = "SELECT COUNT(*) as total_comments FROM comments WHERE DATE(created_at) = CURDATE()";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_comments'];
    }

// Fetch the most recent 20 posts with their status, category name, and author name
public function getRecentPosts($limit, $offset) {
    $query = "SELECT p.title, CONCAT(u.first_name, ' ', u.last_name) as author, c.name as category, p.views_count, p.status
              FROM posts p
              JOIN authors a ON p.author_id = a.author_id  -- Join the authors table
              JOIN users u ON a.user_id = u.user_id      -- Join the users table via author
              JOIN categories c ON p.category_id = c.category_id
              ORDER BY p.created_at DESC
              LIMIT :limit OFFSET :offset";
    
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}
