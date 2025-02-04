<?php

session_start();
require_once "db.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['role']!=='employee')
{
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id']) || empty($_GET['id']))
{
    header("Location: my_requests.php?error=no_id");
    exit();
}

$user_id=$_SESSION['user']['id'];
$request_id=$_GET['id'];

$stmt=$pdo->prepare("SELECT * FROM vacation_requests WHERE id=? AND user_id=? AND status='pending'");
$stmt->execute([$request_id,$user_id]);
$request=$stmt->fetch();

if(!$request)
{
    header("Location: my_requests.php?error=not_found");
    exit();
}

$delete_s = $pdo->prepare("DELETE FROM vacation_requests WHERE id=?");
$delete_s->execute([$request_id]);
header("Location: my_requests.php?success=deleted");
exit();

?>