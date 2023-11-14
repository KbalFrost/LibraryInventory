<?php
session_start();

// Check if the user is already logged in, redirect to user_dashboard.php
if (isset($_SESSION["user_id"])) {
    header("Location: user_dashboard.php");
    exit();
}

// Check if there is an authentication error
$error = isset($_GET["error"]) ? $_GET["error"] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Login - Library Inventory System</title>
</head>
<body>
    <div class="container">
        <h1>Library Inventory System</h1>
        <h2>User Login</h2>
        <div id="clock"></div>

        <?php
        // Display authentication error message for error handling
        if ($error == 1) {
            echo "<p class='error-message'>Invalid username or password.</p>";
        }
        ?>

        <form action="authenticate_user.php" method="post" class="login-form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="login-button">Login</button>
        </form>

        <p class="redirect-message">Not a user yet? <a href="user_register.php">Register here</a> or <a href="index.php">Go back to homepage</a></p>
    </div>

    <script src="clock.js"></script>
</body>
</html>
