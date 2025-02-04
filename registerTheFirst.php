<?php
require_once "db.php";

$username = "admin";
$email = "admin@example.com";
$employee_code = "1234567";
$password = password_hash("password123", PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, email, employee_code, password) VALUES (?, ?, ?, ?)");
$stmt->execute([$username, $email, $employee_code, $password]);

echo "✅ Ο χρήστης δημιουργήθηκε!";
?>
