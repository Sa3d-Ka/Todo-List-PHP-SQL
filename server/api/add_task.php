<?php

require_once '../config/database.php';
header("Content-Type: application/json");

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!isset($data['title']) || trim($data['title']) === "") {
    http_response_code(400);
    echo json_encode(["error" => "Task title is required."]);
    exit;
}

$title = trim($data['title']);

try {
    $db = new Database();
    $pdo = $db->getConnection();

    $query = "INSERT INTO task (title) VALUES (:title)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->execute();

    // Get the ID of the inserted task
    $id = $pdo->lastInsertId();

    // Respond with the task as JSON
    echo json_encode([
        "id" => $id,
        "title" => $title
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
