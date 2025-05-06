<?php
session_start();
require_once __DIR__ . '/../../Controllers/CleaningServiceController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'cleaner') {
    header("Location: login.php");
    exit;
}

$controller = new CleaningServiceController();
$cleanerId = $_SESSION['user']['id'];

$keyword = $_GET['search'] ?? '';
if ($keyword) {
    $services = $controller->searchServicesByTitle($cleanerId, $keyword);
} else {
    
    $services = $controller->getServicesByCleaner($cleanerId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cleaning Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)),
            url('../img/view_my_services.jpg') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            color: #1f2937;
        }
        nav {
            background-color: #0f172a;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container {
            max-width: 1100px;
            margin: 40px auto;
            background-color: rgba(255, 255, 255, 0.75);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        h2 { font-size: 28px; font-weight: 600; margin-bottom: 24px; }
        form { display: flex; gap: 12px; margin-bottom: 30px; }
        input[type="text"] {
            flex: 1;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            font-size: 16px;
        }
        button, .reset-link {
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        button { background-color: #3b82f6; color: white; }
        button:hover { background-color: #2563eb; }
        .reset-link {
            background-color: #f87171;
            color: white;
            text-decoration: none;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        tr:nth-child(even) { background-color: #f1f5f9; }
        .status-offered { color: #15803d; font-weight: 600; }
        .status-suspended { color: #b91c1c; font-weight: 600; }
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .action-buttons a, .action-buttons span {
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 14px;
            text-align: center;
            color: white;
            text-decoration: none;
        }
        .update-btn { background-color: #3b82f6; }
        .suspend-btn { background-color: #ef4444; }
        .unsuspend-btn { background-color: #10b981; }
        .back-link {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            color: #3b82f6;
            font-weight: 600;
        }
    </style>
</head>
<body>

<nav>
    <h1>My Services</h1>
    <a class="reset-link" href="../logout.php">Logout</a>
</nav>

<div class="container">
    <h2>My Cleaning Services</h2>

    <form method="GET">
        <input type="text" name="search" placeholder="Search by title, description or category" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Search</button>
        <a class="reset-link" href="view_my_services.php">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Job ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
				<th>Price($)</th>
				<th>Views</th>
				<th>Shortlisted</th>
                <th>Status</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
		
           <?php if (!empty($services) && count($services) > 0): ?>
                <?php foreach ($services as $job): ?>
                    <tr>
                        <td><?= $job['job_id'] ?></td>
                        <td><?= htmlspecialchars($job['title']) ?></td>
                        <td><?= htmlspecialchars($job['description']) ?></td>
                        <td><?= htmlspecialchars($job['category_name']) ?></td>
						<td><?= htmlspecialchars($job['price']) ?></td>
						<td><?= htmlspecialchars($job['views']) ?></td>
						<td><?= htmlspecialchars($job['shortlisted']) ?></td>
                        <td>
                            <span class="<?= $job['status'] === 'offered' ? 'status-offered' : 'status-suspended' ?>">
                                <?= ucfirst($job['status']) ?>
                            </span>
                        </td>
                        <td class="action-buttons" style="text-align: center;">
                            <a class="update-btn" href="update_service.php?id=<?= $job['job_id'] ?>">Update</a>
                            <?php if ($job['status'] === 'offered'): ?>
                                <a class="suspend-btn" href="suspend_service.php?id=<?= $job['job_id'] ?>" onclick="return confirm('Suspend this service?')">Suspend</a>
                            <?php else: ?>
                                <a class="unsuspend-btn" href="unsuspend_service.php?id=<?= $job['job_id'] ?>" onclick="return confirm('Unsuspend this service?')">Unsuspend</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No services found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a class="back-link" href="cleaner_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
