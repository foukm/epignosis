<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
       
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Incorrect username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Login</title>
    <style>
       
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-primary">

    <div class="card p-4 shadow-lg" style="width: 350px;">
        <h2 class="text-center mb-4">Login</h2>
        
        <?php if (isset($error)) echo "<div class='alert alert-danger text-center'>$error</div>"; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-gradient w-100">Login</button>
        </form>
    </div>

    
</body>
</html>
