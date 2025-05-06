<?php
session_start();
require_once __DIR__ . '/../../Controllers/FavoriteController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['cleaner_id'])) {
    echo "Missing cleaner ID.";
    exit;
}

$homeownerId = $_SESSION['user']['id'];
$cleanerId = intval($_GET['cleaner_id']);

$controller = new FavoriteController();
$result = $controller->removeFavorite($homeownerId, $cleanerId);

$msg = $result === 'removed' ? 'removed' : 'error';
header("Location: view_favorites.php?msg=$msg");
exit;
