<?php
require_once 'app/config/dbconfig.php'; // Include your PDO connection
require_once 'app/Controllers/AdminController.php';

$adminController = new AdminController($pdo);

// Handle table loading (pagination for articles)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'load_table') {
        $currentPage = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $result = $adminController->getRecentArticlesWithPagination($currentPage);

        // Return the data as JSON for the AJAX call
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    // Handle chart data loading
    if ($action === 'load_chart_data') {
        // Call the controller to fetch chart data
        $chartData = $adminController->loadChartData();

        // Return the data as JSON
        header('Content-Type: application/json');
        echo json_encode($chartData);
        exit;
    }

    // Handle additional action for loading table data for articles
    if ($action === 'load_table_data_articles') {
        $adminController->loadTableDataArticles();
        exit;
    }

    // Handle invalid request
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request', 'data' => $_POST]);
} else {
    // Handle non-POST request
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
