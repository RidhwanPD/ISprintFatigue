<?php
session_start();
require_once __DIR__ . '/../../Controllers/CleaningServiceController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
    die("Invalid service ID.");
}

$jobId = $_GET['job_id'];
$cleanerId = $_GET['cleaner_id'] ?? null;

$controller = new CleaningServiceController();
$success = $controller->incrementShortlistCount($jobId);

$msg = $success ? 'shortlisted' : 'error';
header("Location: view_cleaner_services.php?cleaner_id=$cleanerId&msg=$msg");
exit;
