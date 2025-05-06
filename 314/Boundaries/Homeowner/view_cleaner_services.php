<?php
session_start();
require_once __DIR__ . '/../../Controllers/CleaningServiceController.php';
require_once __DIR__ . '/../../Controllers/CleanerProfileController.php';
require_once __DIR__ . '/../../Entities/User.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../Boundaries/login.php");
    exit;
}

$cleanerId = $_GET['cleaner_id'] ?? null;
if (!$cleanerId) {
    echo "Cleaner ID is required.";
    exit;
}

$serviceController = new CleaningServiceController();
$profileController = new CleanerProfileController();

$userEntity = new User();
$user = $userEntity->getUserById($cleanerId);
$cleanerName = $user ? htmlspecialchars($user['name']) : 'Unknown';

$services = $serviceController->getServicesByCleaner($cleanerId);

foreach ($services as $service) {
    $serviceController->incrementViewCount($service['job_id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $cleanerName ?>Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        
        body {
            background: url('../img/dog.jpg') no-repeat center center;
			background-size: cover;
			color: #1e293b;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
			max-width: 1000px;
			margin: 40px auto;
			padding: 24px;
			background-color: rgba(255, 255, 255, 0.25); /* more transparent */
			border-radius: 16px;
			backdrop-filter: blur(10px); /* frosted glass effect */
			-webkit-backdrop-filter: blur(10px); /* for Safari */
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
			border: 1px solid rgba(255, 255, 255, 0.3);
		}


        h2 {
            text-align: center;
            font-size: 28px;
            color: #1e3a8a;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 16px 20px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-size: 15px;
        }

        th {
            background-color: #f1f5f9;
            color: #334155;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .favorite-btn {
            padding: 10px 16px;
            background-color: #6366f1;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .favorite-btn:hover {
            background-color: #4f46e5;
        }

        .disabled-btn {
            background-color: #9ca3af;
            color: white;
            padding: 10px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: not-allowed;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-weight: 600;
            color: #6366f1;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                background-color: #fff;
                margin-bottom: 12px;
                border-radius: 12px;
                padding: 16px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            }

            td {
                border: none;
                padding: 10px 0;
                font-size: 14px;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #6b7280;
                display: block;
                margin-bottom: 4px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🧹 Services by <?= $cleanerName ?></h2>

    <?php if ($services): ?>
        <table>
            <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Views</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td data-label="Title"><?= htmlspecialchars($service['title']) ?></td>
                    <td data-label="Description"><?= htmlspecialchars($service['description']) ?></td>
                    <td data-label="Category"><?= htmlspecialchars($service['category_name']) ?></td>
                    <td data-label="Price">$<?= number_format($service['price'], 2) ?></td>
                    <td data-label="Views"><?= $service['views'] ?></td>
                    <td data-label="Action">
                        <?php if ($service['shortlisted'] > 0): ?>
                            <span class="disabled-btn">Shortlisted</span>
                        <?php else: ?>
                            <a class="favorite-btn"
                               href="shortlist_service.php?job_id=<?= $service['job_id'] ?>&cleaner_id=<?= $cleanerId ?>"
                               onclick="return confirm('Shortlist this service?');">
                                Shortlist
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center; color:#6b7280;">No services available.</p>
    <?php endif; ?>

    <a href="view_cleaners.php" class="back-link">Back to Cleaner List</a>
</div>

</body>
</html>
