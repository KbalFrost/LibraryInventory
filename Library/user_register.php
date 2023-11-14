<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Registration - Library Inventory System</title>
</head>
<body>
    <div class="container">
        <h1>Library Inventory System</h1>
        <h2>User Registration</h2>
        <div id="clock"></div>

        <form action="register_user_user.php" method="post" class="registration-form" onsubmit="return validateForm()">
            <label for="new-username">New Username:</label>
            <input type="text" id="new-username" name="new-username" required>

            <label for="new-password">New Password:</label>
            <input type="password" id="new-password" name="new-password" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <label for="full-name">Full Name:</label>
            <input type="text" id="full-name" name="full-name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">

            <label for="phone-number">Phone Number:</label>
            <input type="text" id="phone-number" name="phone-number">

            <label for="favorite-book">Favorite Book:</label>
            <input type="text" id="favorite-book" name="favorite-book">

            <button type="submit" class="register-button">Register</button>
        </form>

        <p class="redirect-message">Already a user? <a href="user_login.php">Login here</a> or <a href="index.php">Go back to homepage</a></p>
    </div>

    <script src="clock.js"></script>
    <script src="user_register.js"></script>
</body>
</html>
