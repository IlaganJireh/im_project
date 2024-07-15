<?php
require 'db_conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You need to log in first.'); window.location.href = 'login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["entry"]) && !empty($_POST["entry"])) {
        $entry = mysqli_real_escape_string($conn, $_POST["entry"]);
        $userId = $_SESSION['user_id'];
        $entryDate = date('Y-m-d H:i:s');
        $sql = "INSERT INTO diary_entries (user_id, entry, entry_date) VALUES ('$userId', '$entry', '$entryDate')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Diary entry saved successfully');</script>";
        } else {
            echo "<script>alert('Error: Could not save diary entry.');</script>";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Diary</title>
    <link rel="stylesheet" href="./style/main_page.css" />
</head>
<body>
    <div class="container">
      <aside class="sidebar">
        <div class="profile">
            <img src="profile.jpg" alt="Profile Picture">
            <span>Memories</span>
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Mood Tracker</a></li>
                <li><a href="to_do_list.html">To do List</a></li>
            </ul>
        </nav>
    </aside>

        <div class="main">
            <div class="content">
                <div class="sorting-buttons">
                    <button id="sort_newest" class="sort-button">Sort by Newest</button>
                    <button id="sort_oldest" class="sort-button">Sort by Oldest</button>
                </div>

                <div class="writing-box">
                    <form id="entry_form" action="main-page.php" method="post" enctype="multipart/form-data">
                        <textarea id="entry_input" name="entry" class="writing-input" placeholder="Start Writing Your Thoughts" required></textarea>
                        <input type="file" id="entry_image" name="entry_image" accept="image/*">
                        <button type="submit" class="save-entry-button">Save Entry</button>
                    </form>
                </div>

                <div id="entries_container"></div>
            </div>
        </div>
    </div>
    <script src="./script/main_page.js"></script>
</body>
</html>