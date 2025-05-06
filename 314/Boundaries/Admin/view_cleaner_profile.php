<?php
session_start();
require_once __DIR__ . '/../../Controllers/CleanerProfileController.php';
require_once __DIR__ . '/../../Controllers/CleaningServiceController.php';
require_once __DIR__ . '/../../Controllers/ServiceCategoryController.php';
require_once __DIR__ . '/../../Entities/User.php';

if (!isset($_SESSION['user']) || 
   ($_SESSION['user']['role'] !== 'homeowner' && $_SESSION['user']['role'] !== 'admin')) {
    header("Location: ../../Boundaries/login.php");
    exit;
}

$cleanerId = $_GET['id'] ?? null;
if (!$cleanerId) {
    echo "Cleaner ID is required.";
    exit;
}

$cleanerController = new CleanerProfileController();
$serviceController = new CleaningServiceController();
$services = $serviceController->getServicesByCleaner($cleanerId);
$categoryController = new ServiceCategoryController();
$userEntity = new User();

$user = $userEntity->getUserById($cleanerId);
$cleanerName = $user ? htmlspecialchars($user['name']) : 'Unknown';

$profile = $cleanerController->getCleanerProfileByUserId($cleanerId);
$categoryName = '';

if ($profile && !empty($profile['expertise'])) {
    $category = $categoryController->getCategoryById($profile['expertise']);
    $categoryName = $category ? $category['name'] : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Cleaner Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
            font-family: 'Inter', sans-serif;
            color: #333;
            min-height: 100vh;
        }

        nav {
            background-color: #1a252f;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        nav h1 {
            font-size: 24px;
        }

        nav a.logout-link {
            color: #f39c12;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        nav a.logout-link:hover {
            color: #e67e22;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        h2 {
            font-size: 28px;
            margin-bottom: 28px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 16px;
            background-color: #f5f5f5;
        }

        .error {
            color: red;
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #326aad;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }
		
        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            nav {
                flex-direction: column;
                align-items: flex-start;
            }
        }
			
    </style>
</head>
<body>
    <div class="container">
        <h2>Cleaner Profile: <?= $cleanerName ?></h2>

        <?php if ($profile): ?>
        <label>User Name:</label>
        <input type="text" value="<?= htmlspecialchars($user['name']) ?>" readonly>

        <label>User ID:</label>
        <input type="text" value="<?= $user['id'] ?>" readonly>

        <label>Phone:</label>
        <input type="text" value="<?= htmlspecialchars($profile['phone']) ?>" readonly>

        <label>Address:</label>
        <input type="text" value="<?= htmlspecialchars($profile['address']) ?>" readonly>

        <label>Experience:</label>
        <input type="text" value="<?= htmlspecialchars($profile['experience']) ?>" readonly>

        <label>Expertise:</label>
        <input type="text" value="<?= htmlspecialchars($categoryName) ?>" readonly>

        <label>Preferred Cleaning Time:</label>
        <input type="text" value="<?= htmlspecialchars($profile['preferred_cleaning_time']) ?>" readonly>

        <label>Cleaning Frequency:</label>
        <input type="text" value="<?= htmlspecialchars($profile['cleaning_frequency']) ?>" readonly>

        <label>Language Preference:</label>
        <input type="text" value="<?= htmlspecialchars($profile['language_preference']) ?>" readonly>

        <label>Status:</label>
        <input type="text" value="<?= htmlspecialchars($profile['status']) ?>" readonly>
		
		<?php if (!empty($services)): ?>
			<div class="services-section">
				<h3>Services Offered by This Cleaner:</h3>
				<ul>
					<?php foreach ($services as $service): ?>
						<li><strong><?= htmlspecialchars($service['title']) ?></strong></li>
					<?php endforeach; ?>
				</ul>

        <?php if ($_SESSION['user']['role'] === 'homeowner'): ?>
            <a class="view-btn" href="../Homeowner/view_cleaner_services.php?cleaner_id=<?= $cleanerId ?>">View Services</a>
        <?php endif; ?>
			</div>
		<?php else: ?>
			<div class="services-section">
				<h3>Services Offered by This Cleaner:</h3>
				<p style="color: #888; font-style: italic;">No services available yet.</p>
			</div>
		<?php endif; ?>
		
        <?php else: ?>
            <p>No profile data available for this cleaner.</p>
        <?php endif; ?>

        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <a href="../Admin/view_users.php" class="back-link">Back to User List</a>
        <?php else: ?>
            <a href="../Homeowner/view_cleaners.php" class="back-link">Back to Cleaner List</a>
        <?php endif; ?>
    </div>
</body>
</html>
