<?php
session_start();
require_once __DIR__ . '/../../Controllers/CleaningServiceController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'cleaner') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "No service ID provided.";
    exit;
}

$jobId = $_GET['id'];
$controller = new CleaningServiceController();
$controller->unsuspendService($jobId);

header("Location: view_my_services.php");
exit;
?>
