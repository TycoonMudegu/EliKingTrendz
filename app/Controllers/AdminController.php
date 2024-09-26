<?php

require_once 'app/Model/AdminModel.php';

class AdminController {
    private $AdminModel;

    public function __construct($pdo) {
        $this->AdminModel = new AdminModel($pdo);
    }

    public function getDashboardMetrics() {
        $data = [
            'total_posts' => $this->AdminModel->getTotalPosts(),
            'total_views' => $this->AdminModel->getTotalViews(),
            'new_subscribers' => $this->AdminModel->getNewSubscribers(),
            'new_comments' => $this->AdminModel->getNewComments(),
        ];
        return $data;
    }

    public function getRecentArticlesWithPagination($currentPage) {
        $limit = 5; // Number of posts per page
        $offset = ($currentPage - 1) * $limit;
        $totalPosts = $this->AdminModel->getTotalPosts();
        $totalPages = ceil($totalPosts / $limit);

        $posts = $this->AdminModel->getRecentPosts($limit, $offset);

        return [
            'posts' => $posts,
            'total_pages' => $totalPages,
            'current_page' => $currentPage
        ];
    }

}
