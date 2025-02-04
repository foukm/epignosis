<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $employee_code = $_POST['employee_code'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $existingUsername = $stmt->fetchColumn();

    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE employee_code = ?");
    $stmt->execute([$employee_code]);
    $existingEmployee = $stmt->fetchColumn();

    if ($existingUsername > 0) {
        $error_message = "The username is already taken. Please choose another one.";
    } elseif ($existingEmployee > 0) {
        $error_message = "The employee code already exists. Please choose a unique code.";
    } else {
        
        $stmt = $pdo->prepare("INSERT INTO users (name, username, email, employee_code, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $username, $email, $employee_code, $password, $role]);

        header("Location: users.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="user-form">
        <h2 class="text-center mb-4">Create new user</h2>
        
        <form method="POST" id="userForm">
            <div class="mb-3">
                <label for="name" class="form-label"><i class="bi bi-person"></i> Full Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label"><i class="bi bi-person"></i> Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
                <?php if (isset($error_message) && strpos($error_message, "username") !== false) { ?>
                    <div class="text-danger mt-2"><?php echo $error_message; ?></div>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><i class="bi bi-envelope"></i> Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="employee_code" class="form-label"><i class="bi bi-card-list"></i> Employee code:</label>
                <input type="text" name="employee_code" id="employee_code" class="form-control" 
                    pattern="^\d{7}$" maxlength="7" required title="Please enter a 7-digit number">
                <?php if (isset($error_message) && strpos($error_message, "employee code") !== false) { ?>
                    <div class="text-danger mt-2"><?php echo $error_message; ?></div>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label"><i class="bi bi-lock"></i> Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label"><i class="bi bi-person-badge"></i> Role:</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="employee">Employee</option>
                    <option value="manager">Manager</option>
                </select>
            </div>

            <button type="submit" class="btn btn-custom w-100 mb-3" id="submitBtn">Create new user</button>
        </form>

        <br>
        <a href="dashboard.php" class="back-link d-block text-center">
            <i class="bi bi-arrow-left-circle"></i> Go back
        </a>
    </div>

    
</body>
</html>