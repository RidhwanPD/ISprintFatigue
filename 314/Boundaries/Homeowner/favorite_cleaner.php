<?php
session_start();
require_once __DIR__ . '/../../Controllers/FavoriteController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../login.php");
    exit;
}

$homeownerId = $_SESSION['user']['id'];
$cleanerId = $_GET['cleaner_id'] ?? null;

if (!$cleanerId) {
    die("Cleaner ID is required.");
}

$controller = new FavoriteController();
$result = $controller->addFavorite($homeownerId, $cleanerId);

if ($result === 'exists') {
    header("Location: view_cleaners.php?msg=exists");
} elseif ($result === 'success') {
    header("Location: view_cleaners.php?msg=added");
} else {
    header("Location: view_cleaners.php?msg=error");
}
exit;
