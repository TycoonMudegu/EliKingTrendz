<?php
class AdminModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalPosts() {
        $query = "SELECT COUNT(*) as total_posts FROM posts";
        return $this->fetchSingleValue($query, 'total_posts');
    }

    public function getTotalViews() {
        $query = "SELECT COALESCE(SUM(views_count), 0) as total_views FROM posts";
        return $this->fetchSingleValue($query, 'total_views');
    }

    public function getNewSubscribers() {
        $query = "SELECT COUNT(*) as total_subscribers FROM users WHERE DATE(created_at) = CURDATE()";
        return $this->fetchSingleValue($query, 'total_subscribers');
    }

    public function getNewComments() {
        $query = "SELECT COUNT(*) as total_comments FROM comments WHERE DATE(created_at) = CURDATE()";
        return $this->fetchSingleValue($query, 'total_comments');
    }

    public function getRecentPosts($limit, $offset) {
        $query = "SELECT p.title, u.full_name as author, c.name as category, p.views_count, p.status
                  FROM posts p
                  JOIN authors a ON p.author_id = a.author_id
                  JOIN users u ON a.user_id = u.user_id
                  JOIN categories c ON p.category_id = c.category_id
                  ORDER BY p.created_at DESC
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryReadership() {
        $query = "SELECT c.name, COALESCE(SUM(p.views_count), 0) as readership_count
                  FROM categories c
                  LEFT JOIN posts p ON c.category_id = p.category_id
                  GROUP BY c.name";
        return $this->fetchAll($query);
    }

    public function getViewsOverTime() {
        $query = "SELECT DATE(p.created_at) as date, COALESCE(SUM(p.views_count), 0) as total_views 
                  FROM posts p
                  GROUP BY DATE(p.created_at)
                  ORDER BY DATE(p.created_at)";
        return $this->fetchAll($query);
    }

    public function getArticles($search, $category, $author, $status, $page = 1, $limit = 10) {
        // Base SQL query for selecting the articles
        $sql = "SELECT p.posts_id, p.title, p.content, p.views_count, p.status, p.created_at, 
                       c.name AS category_name, u.full_name AS author_name 
                FROM posts p
                JOIN categories c ON p.category_id = c.category_id
                JOIN authors a ON p.author_id = a.author_id
                JOIN users u ON a.user_id = u.user_id
                WHERE 1=1";
        
        $params = [];
    
        // Add search filter
        if (!empty($search)) {
            $sql .= " AND p.title LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }
        
        // Add category filter
        if (!empty($category) && $category !== 'All Categories') {
            $sql .= " AND c.name = :category";
            $params[':category'] = $category;
        }
    
        // Add author filter
        if (!empty($author) && $author !== 'All Authors') {
            $sql .= " AND u.full_name = :author";
            $params[':author'] = $author;
        }
    
        // Add status filter
        if (!empty($status) && $status !== 'All Statuses') {
            $sql .= " AND p.status = :status";
            $params[':status'] = $status;
        }
    
        // Query to count total entries (without LIMIT and OFFSET)
        $countSql = "SELECT COUNT(*) 
                     FROM posts p
                     JOIN categories c ON p.category_id = c.category_id
                     JOIN authors a ON p.author_id = a.author_id
                     JOIN users u ON a.user_id = u.user_id
                     WHERE 1=1";
    
        // Add the same filters to the count query
        if (!empty($search)) {
            $countSql .= " AND p.title LIKE :search";
        }
        if (!empty($category) && $category !== 'All Categories') {
            $countSql .= " AND c.name = :category";
        }
        if (!empty($author) && $author !== 'All Authors') {
            $countSql .= " AND u.full_name = :author";
        }
        if (!empty($status) && $status !== 'All Statuses') {
            $countSql .= " AND p.status = :status";
        }
    
        // Fetch total entries
        $countStmt = $this->pdo->prepare($countSql);
        foreach ($params as $key => &$val) {
            $countStmt->bindValue($key, $val, is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $countStmt->execute();
        $totalEntries = $countStmt->fetchColumn();
    
        // Set pagination offset
        $offset = ($page - 1) * $limit;
    
        // Add sorting and pagination to main SQL query
        $sql .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;
    
        // Execute the main query
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => &$val) {
            $stmt->bindValue($key, $val, is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Calculate total pages
        $totalPages = ceil($totalEntries / $limit);
    
        // Return the result with articles, pagination, and filters
        return [
            'data' => $articles,
            'pagination' => [
                'current_page' => $page,
                'last_page' => $totalPages,
                'per_page' => $limit,
                'total' => $totalEntries,
            ],
            'filters' => [
                'categories' => $this->getCategories(),
                'authors' => $this->getAuthors(),
                'statuses' => $this->getStatuses(),
            ],
        ];
    }

    private function fetchSingleValue($query, $key = null, $params = []) {
        $stmt = $this->pdo->prepare($query);
        foreach ($params as $param => &$value) {
            $stmt->bindValue($param, $value);
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $key ? ($result[$key] ?? null) : ($result[0] ?? null);
    }

    private function fetchAll($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        foreach ($params as $param => &$value) {
            $stmt->bindValue($param, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getCategories() {
        $query = "SELECT name FROM categories";
        $categories = $this->fetchAll($query);
        return array_merge(['All Categories'], array_column($categories, 'name'));
    }

    private function getAuthors() {
        $query = "SELECT DISTINCT u.full_name FROM users u JOIN authors a ON u.user_id = a.user_id";
        $authors = $this->fetchAll($query);
        return array_merge(['All Authors'], array_column($authors, 'full_name'));
    }

    private function getStatuses() {
        $query = "SELECT DISTINCT status FROM posts";
        $statuses = $this->fetchAll($query);
        return array_merge(['All Statuses'], array_column($statuses, 'status'));
    }

    // // Return the result variable
    // return $result;
}