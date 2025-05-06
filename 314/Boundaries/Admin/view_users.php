<?php
session_start();
require_once __DIR__ . '/../../Controllers/UserController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$controller = new UserController();
$keyword = $_GET['search'] ?? '';
$users = $keyword ? $controller->searchUsers($keyword) : $controller->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View All Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
    
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #e0f7fa, #ffffff);
        color: #2c3e50;
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

    .reset-link, nav a.reset-link {
        background-color: #f87171;
        color: white;
        padding: 10px 16px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .reset-link:hover {
        background-color: #ef4444;
    }

    .container {
        max-width: 1100px;
        margin: 40px auto;
        background-color: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    h2 {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 24px;
        text-align: center;
    }

    form {
        display: flex;
        gap: 12px;
        margin-bottom: 30px;
    }

    input[type="text"] {
        flex: 1;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #d1d5db;
        font-size: 16px;
        background-color: #fefefe;
    }

    button {
        background-color: #3b82f6;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #2563eb;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    th, td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #f9fafb;
    }

    .status-active {
        color: #10b981;
        font-weight: 600;
    }

    .status-suspended {
        color: #ef4444;
        font-weight: 600;
    }

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
        font-weight: 600;
        transition: opacity 0.3s;
    }

    .update-btn { background-color: #3b82f6; }
    .update-btn:hover { background-color: #2563eb; }

    .suspend-btn { background-color: #ef4444; }
    .suspend-btn:hover { background-color: #dc2626; }

    .unsuspend-btn { background-color: #10b981; }
    .unsuspend-btn:hover { background-color: #059669; }

    .profile-created { background-color: #f59e0b; }
    .profile-view { background-color: #22c55e; }

    .back-link {
        display: inline-block;
        margin-top: 30px;
        text-decoration: none;
        color: #3b82f6;
        font-weight: 600;
        text-align: center;
        width: 100%;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .container {
            padding: 20px;
        }

        form {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: row;
            flex-wrap: wrap;
        }
    }
    </style>
</head>
<body>

<nav>
    <h1>View All Users</h1>
    <a class="reset-link" href="../logout.php">Logout</a>
</nav>

<div class="container">
    <h2>All Users</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="Search by name, email or role" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Search</button>
        <a href="view_users.php" class="reset-link">Reset</a>
    </form>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= ucfirst($user['role']) ?></td>
                <td class="<?= $user['status'] === 'active' ? 'status-active' : 'status-suspended' ?>">
                    <?= ucfirst($user['status']) ?>
                </td>
				
               <td class="action-buttons">
			   <?php
				$hasProfile = $controller->hasProfile($user['id']);
				$isSuspended = $user['status'] === 'suspended';
				?>

				<?php if ($user['status'] === 'active'): ?>
					<a class="update-btn" style="background-color: brown;" href="update_user.php?id=<?= $user['id'] ?>">Update Account</a>
						<?php if ($user['role'] === 'cleaner'): ?>
					<a class="update-btn" href="update_cleaner_profile.php?id=<?= $user['id'] ?>">Update Profile</a>
					<?php else: ?>
						<a class="update-btn" href="update_user_profile.php?id=<?= $user['id'] ?>">Update Profile</a>
					<?php endif; ?>
					
				<?php else: ?>
					<a class="update-btn" style="background-color: grey; pointer-events: none; cursor: not-allowed; opacity: 0.6;">Update Account Suspended</a>
					<?php if ($user['role'] === 'cleaner'): ?>
						<a class="update-btn" style="background-color: grey; pointer-events: none; cursor: not-allowed; opacity: 0.6;">Update Profile Suspended</a>
					<?php else: ?>
						<a class="update-btn" style="background-color: grey; pointer-events: none; cursor: not-allowed; opacity: 0.6;">Update Profile Suspended</a>
					<?php endif; ?>
				<?php endif; ?>

				<?php if (in_array($user['role'], ['homeowner', 'admin', 'manager'])): ?>
				<?php if (!$hasProfile): ?>
					<a class="profile-created" href="create_user_profile.php?id=<?= $user['id'] ?>">Create Profile</a>
				<?php elseif ($isSuspended): ?>
					<a class="profile-suspended" style="background-color: grey; pointer-events: none; cursor: not-allowed; opacity: 0.6;">View Profile Suspended</a>
				<?php else: ?>
					<a class="profile-view" href="view_user_profile.php?id=<?= $user['id'] ?>">View Profile</a>
				<?php endif; ?>

				<?php elseif ($user['role'] === 'cleaner'): ?>
				<?php if (!$controller->hasCleanerProfile($user['id'])): ?>
					<a class="profile-created" href="create_cleaner_profile.php?id=<?= $user['id'] ?>">Create Profile</a>
				<?php elseif ($isSuspended): ?>
					<a class="profile-suspended" style="background-color: grey; pointer-events: none; cursor: not-allowed; opacity: 0.6;">View Profile Suspended</a>
				<?php else: ?>
					<a class="profile-view" href="view_cleaner_profile.php?id=<?= $user['id'] ?>">View Profile</a>
				<?php endif; ?>
			<?php endif; ?>

				<?php if ($user['status'] === 'active'): ?>
					<a class="suspend-btn" href="suspend_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to suspend this user?')">Suspend</a>
				<?php else: ?>
					<a class="unsuspend-btn" href="unsuspend_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Unsuspend this user?')">Unsuspend</a>
			<?php endif; ?>
			</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
</div>
</body>
</html>
