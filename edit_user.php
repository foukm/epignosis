<?php
session_start();
require_once "db.php";

// Ελέγχουμε αν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Ο χρήστης δεν βρέθηκε!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $new_password = $_POST['new_password']; 

    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?");
        $stmt->execute([$username, $email, $hashed_password, $role, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        $stmt->execute([$username, $email, $role, $id]);
    }

    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Χρήστη</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="edit-form">
        <h2 class="text-center mb-4">Επεξεργασία Χρήστη</h2>
        
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label"><i class="bi bi-person"></i> Username:</label>
                <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><i class="bi bi-envelope"></i> Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label"><i class="bi bi-person-badge"></i> Role:</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="employee" <?= $user['role'] == 'employee' ? 'selected' : '' ?>>Employee</option>
                    <option value="manager" <?= $user['role'] == 'manager' ? 'selected' : '' ?>>Manager</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label"><i class="bi bi-lock"></i> New Password (leave it blank if no change):</label>
                <input type="password" name="new_password" id="new_password" class="form-control">
            </div>

            <button type="submit" class="btn btn-custom w-100 mb-3">Save</button>
        </form>

        <br>
        <a href="users.php" class="back-link d-block text-center">
            <i class="bi bi-arrow-left-circle"></i> Go back
        </a>
    </div>
    
    <?php
        require_once "footer.php";
    ?>
    
</body>
</html>
