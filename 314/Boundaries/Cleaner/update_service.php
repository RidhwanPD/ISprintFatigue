<?php
session_start();
require_once __DIR__ . '/../../Controllers/CleaningServiceController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'cleaner') {
    header("Location: login.php");
    exit;
}

$controller = new CleaningServiceController();

if (!isset($_GET['id'])) {
    echo "No job ID specified.";
    exit;
}

$jobId = $_GET['id'];
$service = $controller->getServiceById($jobId);

require_once __DIR__ . '/../../Controllers/ServiceCategoryController.php';

$categoryController = new ServiceCategoryController();
$categories = $categoryController->getAllCategories();

$currentCategoryName = '';
foreach ($categories as $cat) {
    if ($cat['category_id'] == $service['category_id']) {
        $currentCategoryName = $cat['name'];
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTitle = $_POST['title'];
    $newDescription = $_POST['description'];
	$categoryId = $_POST['category_id'];
	$newPrice = $_POST['price'];


    $controller->updateService($jobId, $newTitle, $newDescription, $categoryId, $newPrice);
	header("Location: view_my_services.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Cleaning Service</title>
    <style>
        :root {
            --primary-color: #2C7A7B;
            --secondary-color: #319795;
            --bg-light: #F7FAFC;
            --text-color: #2D3748;
            --white: #ffffff;
            --gray: #E2E8F0;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --border-radius: 10px;
        }

        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

      body {
            margin: 0;
            background-color: var(--bg-light);
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: var(--primary-color);
            font-size: 28px;
            margin-bottom: 30px;
        }

        .container {
            background-color: var(--white);
            padding: 30px 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 600px;
        }

        label {
            display: block;
            font-weight: bold;
            color: var(--text-color);
            margin-top: 18px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            margin-top: 8px;
            border: 1px solid var(--gray);
            border-radius: 6px;
            background-color: #fff;
            font-size: 1em;
        }

        input[readonly],
        textarea[readonly] {
            background-color: #f1f1f1;
            color: #666;
        }

        input:focus,
        textarea:focus {
            border-color: var(--secondary-color);
            outline: none;
        }

        .button {
            margin-top: 25px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: var(--secondary-color);
        }

        a.back-link {
            display: inline-block;
            margin-top: 25px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        a.back-link:hover {
            text-decoration: underline;
        }

        .fieldset {
            border: 1px solid var(--gray);
            padding: 20px;
            border-radius: 8px;
            background-color: #fefefe;
            margin-bottom: 30px;
        }

        .legend {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        @media (max-width: 600px) {
            body {
                padding: 20px;
            }
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <h2>Update Cleaning Service: Job <?= $service['job_id'] ?></h2>

		<div class="container">
			<div class="fieldset">
			<div class="legend">Current Info</div>

			<label>Current Category:</label>
			<input type="text" value="<?= htmlspecialchars($currentCategoryName) ?>" readonly>

			<label>Current Title:</label>
			<input type="text" value="<?= htmlspecialchars($service['title']) ?>" readonly>
	
			<label>Current Description:</label>
			<textarea readonly rows="5"><?= htmlspecialchars($service['description']) ?></textarea>
			
			<label>Current Price:</label>
			<input type="text" value="<?= htmlspecialchars($service['price']) ?>" readonly>
			
			
		</div>

        <form method="POST">
            <div class="fieldset">
            <div class="legend">New Information</div>
				
			<label>New Category:</label>
				<select name="category_id" required>
					<option value="">--Select a Category--</option>
					<?php foreach ($categories as $cat): ?>
					<option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
					<?php endforeach; ?>
				</select>

                <label>New Title:</label>
                <input type="text" name="title" required>

                <label>New Description:</label>
                <textarea name="description" rows="5" required></textarea>
				
				<label for="price">New Price:</label>
				<input type="text" id="price" name="price" required>

                <button class="button" type="submit">Save Changes</button>
            </div>
        </form>

        <a class="back-link" href="view_my_services.php">Back to My Services</a>
    </div>

</body>
</html>



