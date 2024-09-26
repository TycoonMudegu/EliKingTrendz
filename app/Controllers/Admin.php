<?php
require_once 'app/config/dbconfig.php'; // Include your PDO connection
require_once 'app/Controllers/AdminController.php';

$adminController = new AdminController ($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load_table') {
    $currentPage = isset($_POST['page']) ? (int)$_POST['page'] : 1;


    $result = $adminController->getRecentArticlesWithPagination($currentPage);

    // Return the data as JSON for the AJAX call
    echo json_encode($result);
}

