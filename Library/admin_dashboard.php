<?php
session_start();
include('database_connection.php');

// Use page session for authorization
// Check if the admin is not logged in, redirect to admin_login.php
if (!isset($_SESSION["user_id"])) {
    header("Location: admin_login.php");
    exit();
}

// Check the user's role for RBAC
if ($_SESSION['user_role'] !== 'admin') {
    // Redirect to an unauthorized page or show an error message
    header("Location: unauthorized.php");
    exit();
}

// Use URL referrer check for admin_dashboard page access security
$referrer = $_SERVER['HTTP_REFERER'];

// List of allowed pages
$allowedPages = array("http://localhost/Library/admin_login.php", "http://localhost/Library/user.php", "http://localhost/Library/book.php");

// Check if the referrer is in the allowed pages
if (!in_array($referrer, $allowedPages)) {
    // Redirect to a secure error page or take appropriate action
    header("Location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard - Library Inventory System</title>
</head>
<body>
    <div class="container">
        <h1>Library Inventory System</h1>
        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
        
        <div id="clock"></div>

        <div class="admin-options">
            <button onclick="location.href='book.php'">Book</button>
            <button onclick="location.href='user.php'">User</button>
            <p></p>
        </div>

        <button onclick="location.href='logout.php'" class="logout-button">Logout</button>
    </div>

    <script src="clock.js"></script>
</body>
</html>
