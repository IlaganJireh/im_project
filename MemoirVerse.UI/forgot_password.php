<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/forgot_password.css">
    <title>Forgot Password</title>
</head>

<body>
    <div class="container">
        <div class="welcome-section">
            <h1>Welcome to MemoirVerse!</h1>
            <p>Kindly submit the email address you used for registration
                to reset your password.</p>
        </div>

        <div class="forgot-password-section">
            <h2>Forget Password</h2>
            <form action="request_reset.php" method="POST">
                <input type="email" name="email" 
                    placeholder="Enter your email" required>
                <button type="submit">Request Password Reset</button>
            </form>
        </div>
    </div>
</body>

</html>