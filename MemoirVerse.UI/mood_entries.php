<?php

if (!file_exists('db_conn.php')) {
    die("Database connection file is missing.");
}

include 'db_conn.php';

session_start();

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM moods WHERE user_id = ? ORDER BY entry_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$mood_entries = [];
while ($row = $result->fetch_assoc()) {
    $mood_entries[] = $row;
}

header('Content-Type: application/json');
echo json_encode($mood_entries);
?>
