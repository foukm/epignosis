<?php

session_start();
require_once "db.php";

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

$id=$_GET['id'];

$pdo->beginTransaction();

$stmt=$pdo->prepare("DELETE FROM vacation_requests WHERE user_id=?");
$stmt->execute([$id]);

$stmt=$pdo->prepare("DELETE FROM users WHERE id=?");
$stmt->execute([$id]);
$pdo->commit();

header("Location: users.php");
exit();

?>
