<?php
session_start();
require_once __DIR__ . '/../../Controllers/UserController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "No user ID specified.";
    exit;
}

$id = $_GET['id'];

$controller = new UserController();
$controller->suspendUser($id);

header("Location: view_users.php");
exit;
