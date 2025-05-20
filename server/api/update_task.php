<?php

require_once '../config/database.php';

header("Content-Type: application/json");

// Lire le corps brut de la requête
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);



$id = trim($data['id']);
$done = $data['done'];

try {
    $db = new Database();
    $pdo = $db->getConnection();

    // Supprimer la tâche
    $query = "UPDATE task SET done=:done WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":done", $done, PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "id" => $id]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Tâche non trouvée"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur base de données : " . $e->getMessage()]);
}
?>
