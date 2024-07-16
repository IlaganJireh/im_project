<?php
require 'db_conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['entry'])) {
        $entry = $_POST['entry'];
        $entry_date = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO diary_entries (user_id, entry, entry_date) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $entry, $entry_date);

        header('Content-Type: application/json');

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Diary entry saved successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save diary entry.']);
        }

        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sortOrder = isset($_GET['sort']) && $_GET['sort'] == 'oldest' ? 'ASC' : 'DESC';

    $stmt = $conn->prepare("SELECT * FROM diary_entries WHERE user_id = ? ORDER BY entry_date $sortOrder");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $diary_entries = [];
    while ($row = $result->fetch_assoc()) {
        $diary_entries[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($diary_entries);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT['entry_id']) && isset($_PUT['entry'])) {
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
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (isset($_DELETE['entry_id'])) {
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
}
?>
