<?php

if (!file_exists('db_conn.php')) {
    die("Database connection file is missing.");
}

include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dob = $_POST['dob'];
    $secretCode = $_POST['secretCode'];

    $stmt = $conn->prepare("INSERT INTO users (email, firstName, lastName, password, dob, secret_code) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $email, $firstName, $lastName, $password, $dob, $secretCode);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful.'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Signup failed: " . $stmt->error . "'); window.location.href = 'signup.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MemoirVerse Registration</title>
  <link rel="stylesheet" href="style/signup.css"/>
</head>

<body>
  <div class="container">
    <div class="form-section">
    <form action="signup.php" method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <label for="firstName">First Name:</label>
    <input type="text" name="firstName" id="firstName" required>
    <label for="lastName">Last Name:</label>
    <input type="text" name="lastName" id="lastName" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob" id="dob" required>
    <label for="secretCode">Secret Code:</label>
    <input type="text" name="secretCode" id="secretCode" required>
    <button type="submit">Sign Up</button>
    </button>

    <button type="button" class="submit-btn"
     onclick="window.location.href='login.php'">
    <span class="submit-text">Back to Login</span>
    </button>
</form>
    </div>
    <div class="welcome-section">
      <h1>MemoirVerse Registration</h1>
      <p>Enter your personal details to use all of site features.</p>
    </div>
  </div>
</body>
</html>