<?php
include 'db.php';

$id = $_GET['id'];

$query = "DELETE FROM pet WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);

header('Location: index.php');
exit;
?>
