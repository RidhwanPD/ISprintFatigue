<?php
session_start();
require_once __DIR__ . '/../Controllers/LoginController.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $loginCtrl = new LoginController();
    $user = $loginCtrl->loginUser($email, $password);

    if ($user) {
        if ($user['status'] === 'suspended') {
            $error = "Account is suspended. Please contact admin.";
        } elseif ($user['role'] === $role) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            switch ($user['role']) {
                case 'admin':
                    header("Location: Admin/admin_dashboard.php");
                    break;
                case 'cleaner':
                    header("Location: Cleaner/cleaner_dashboard.php");
                    break;
                case 'homeowner':
                    header("Location: Homeowner/homeowner_dashboard.php");
                    break;
                case 'manager':
                    header("Location: Manager/manager_dashboard.php");
                    break;
            }
            exit;
        } else {
            $error = "Incorrect role selected.";
        }
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Cleaning Match</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), 
                        url('img/login.jpg') no-repeat center center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: #fff;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            margin-bottom: 30px;
            text-align: center;
            font-size: 24px;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group i {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #3498db;
            font-size: 16px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 12px 12px 40px; /* Add left padding to make room for icon */
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            outline: none;
        }

        .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20fill='%233498db'%20height='20'%20viewBox='0%200%2024%2024'%20width='20'%20xmlns='http://www.w3.org/2000/svg'%3E%3Cpath%20d='M7%2010l5%205%205-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #3498db;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .login-container p {
            font-size: 14px;
            text-align: center;
            margin-top: 20px;
        }

        .login-container a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2><i class="fas fa-broom"></i> Cleaning Match Login</h2>

        <form method="POST" autocomplete="off">
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="form-group">
                <i class="fas fa-user-tag"></i>
                <select name="role" required>
                    <option value="">-- Select Role --</option>
                    <option value="admin">Admin</option>
                    <option value="cleaner">Cleaner</option>
                    <option value="homeowner">Homeowner</option>
                    <option value="manager">Platform Manager</option>
                </select>
            </div>

            <button type="submit">Login</button>
        </form>

        <?php if ($error): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

    </div>
</body>
</html>
