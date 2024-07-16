<?php
require 'db_conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You need to log in first.'); window.location.href = 'login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemoirVerse</title>
    <link rel="stylesheet" href="./style/entry_style.css">
</head>
<body>
    <header>
        <div class="header-left">
            <div class="user-profile">
                <img src="profile.jpg" alt="Profile Picture" class="profile-pic">
                <span class="user-info">Jane Doe</span>
            </div>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="#">Diary</a></li>
                <li><a href="#">To do list</a></li>
                <li><a href="#">Chart</a></li>
            </ul>
            <div class="logout-logo">
                <a href="logout.php" class="logout-button">Log Out</a>
            </div>
            <img src="./assets/memoir-logo.png" alt="Logo" class="logo">
        </nav>
    </header>
    <main>
        <section class="diary-section">
            <h2>My Diary</h2>
            <form id="entry_form" class="diary-entry" enctype="multipart/form-data">
                <textarea id="entry_input" name="entry" placeholder="Start Writing Your Thoughts"></textarea>
                <input type="file" id="entry_image" name="entry_image" accept="image/*">
            </form>
            <div class="sort-buttons">
                <button id="sort_newest" class="diary-button">Sort by Newest</button>
                <button id="sort_oldest" class="diary-button">Sort by Oldest</button>
            </div>
            <div id="entries_container"></div>
        </section>
        <section class="mood-tracker">
            <h2>How are you feeling today?</h2>
            <div class="mood-icons">
                <a href="#" class="mood-icon" data-mood="happy"><img src="path_to_happy_icon" alt="Happy"></a>
                <a href="#" class="mood-icon" data-mood="content"><img src="path_to_content_icon" alt="Content"></a>
                <a href="#" class="mood-icon" data-mood="neutral"><img src="path_to_neutral_icon" alt="Neutral"></a>
                <a href="#" class="mood-icon" data-mood="sad"><img src="path_to_sad_icon" alt="Sad"></a>
                <a href="#" class="mood-icon" data-mood="angry"><img src="path_to_angry_icon" alt="Angry"></a>
            </div>
            <p class="motivational-quote">Select a mood to see a motivational quote.</p>
            <button id="submitCombinedButton" class="diary-button">Submit</button>
            <div id="mood_entries"></div>
        </section>
    </main>
    <script src="./script/entry_script.js"></script>
</body>
</html>
