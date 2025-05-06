<?php
session_start();
require_once __DIR__ . '/../../Controllers/ServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "No category ID provided.";
    exit;
}

$categoryId = $_GET['id'];

$controller = new ServiceCategoryController();
$success = $controller->unsuspendCategory($categoryId);

if ($success) {
    header("Location: view_service_categories.php?msg=unsuspended");
} else {
    echo "Failed to unsuspend the category.";
}
?>
