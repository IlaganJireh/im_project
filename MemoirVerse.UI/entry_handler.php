<?php
require 'db_conn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entry = $_POST['entry'];
    $mood = $_POST['mood'];
    $user_id = $_SESSION['user_id'];
    $entry_date = date('Y-m-d H:i:s');
    $entry_image = '';

    if (!empty($_FILES['entry_image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["entry_image"]["name"]);
        move_uploaded_file($_FILES["entry_image"]["tmp_name"], $target_file);
        $entry_image = $target_file;
    }

    $stmt = $conn->prepare("INSERT INTO diary_entries (user_id, entry, entry_date, entry_image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $entry, $entry_date, $entry_image);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO moods (user_id, mood, entry_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $mood, $entry_date);

    header('Content-Type: application/json');

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Diary and Mood entry saved successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save entries.']);
    }

    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_SESSION['user_id'];
    $type = $_GET['type'];
    $sortOrder = $_GET['sort'] == 'oldest' ? 'ASC' : 'DESC';

    if ($type == 'diary') {
        $stmt = $conn->prepare("SELECT * FROM diary_entries WHERE user_id = ? ORDER BY entry_date $sortOrder");
        $stmt->bind_param("i", $user_id);
    } else {
        $stmt = $conn->prepare("SELECT * FROM moods WHERE user_id = ? ORDER BY entry_date $sortOrder");
        $stmt->bind_param("i", $user_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $entries = [];
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($entries);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    $entry_id = $_PUT['entry_id'];
    $entry = $_PUT['entry'];

    $stmt = $conn->prepare("UPDATE diary_entries SET entry = ? WHERE id = ?");
    $stmt->bind_param("si", $entry, $entry_id);

    header('Content-Type: application/json');

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Diary entry updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update diary entry.']);
    }

    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $entry_id = $_DELETE['entry_id'];

    $stmt = $conn->prepare("DELETE FROM diary_entries WHERE id = ?");
    $stmt->bind_param("i", $entry_id);

    header('Content-Type: application/json');

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Diary entry deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete diary entry.']);
    }

    exit();
}
?>
