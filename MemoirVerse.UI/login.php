<?php
require 'db_conn.php';
require 'functions.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = sanitize_input($_POST["email"]);
        $password = sanitize_input($_POST["password"]);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['firstName'];
                echo "<script>alert('Login successful'); window.location.href = 'home_page.php';</script>";
                exit();
            }
            } else {
                echo "<script>alert('Invalid password');</script>";
            }
        } else {
            echo "<script>alert('No user found with this email');</script>";
        }

        $stmt->close();
        $conn->close();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemoirVerse Login</title>
    <link rel="stylesheet" href="./style/login.css">
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <h1>Welcome to MemoirVerse!</h1>
            <p>Enter your personal details to use all of site features.</p>
        </div>
        <div class="login-section">
            <h2>Sign in</h2>
            <form id="login_form" action="login.php" method="post">
                <input type="email" id="email" name="email" 
                    placeholder="Email" required>
                <input type="password" id="password" name="password"
                     placeholder="Password" required>
                <button type="submit" class="btn login-btn">Sign in</button>
            </form>
            <p>Forgot your password? Click here! <a href="forgot_password.php">
                Forgot Password</a></p>
            <p>Don't have an account? Create one! <a href="signup.php">
                Register Here</a></p>
        </div>
    </div>
    <script src="./script/login.js"></script>
</body>
</html>
