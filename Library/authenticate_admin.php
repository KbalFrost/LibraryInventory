<?php
session_start();

include('database_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $enteredUsername = filter_var($_POST["username"]);
    $enteredPassword = filter_var($_POST["password"]);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT user_id, username, password, user_role FROM USER WHERE username = ?");
    $stmt->bind_param("s", $enteredUsername);
    $stmt->execute();
    $stmt->bind_result($user_id, $username, $hashedPassword, $user_role);
    $stmt->fetch();
    $stmt->close();

    // Verify password
    if (password_verify($enteredPassword, $hashedPassword)) {
        // Authentication successful
        $_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $username;
        $_SESSION['user_role'] = $user_role;

        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Authentication failed
        header("Location: admin_login.php?error=1");
        exit();
    }
} else {
    // Redirect to login page if accessed directly
    header("Location: admin_login.php");
    exit();
}
?>
