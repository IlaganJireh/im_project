<?php
session_start();
require 'db_conn.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not authenticated']);
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT firstName, lastName, user_id FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
    exit();
}

header('Content-Type: application/json');
echo json_encode($user);

$stmt->close();
$conn->close();
?>
