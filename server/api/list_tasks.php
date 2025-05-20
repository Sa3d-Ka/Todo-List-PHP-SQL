<?php
require_once '../config/database.php';

header('Content-Type: application/json');

$db = new Database();
$pdo = $db->getConnection();

$query = "SELECT * FROM task";
$stmt = $pdo->prepare($query);
$stmt->execute();

$tasks = [];

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tasks[] = $row;
    }
}

echo json_encode($tasks);
