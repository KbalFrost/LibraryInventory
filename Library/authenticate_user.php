<?php
session_start();

include('database_connection.php');

// Function to log messages to a file
function logMessage($message) {
    $logFile = 'log.txt';
    $currentDateTime = date('Y-m-d H:i:s');
    $logMessage = "[$currentDateTime] $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

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

        $logMessage = "Successful login attempt for user: $username";
        logMessage($logMessage);
        
        header("Location: user_dashboard.php");
        exit();
    } else {
        // Authentication failed
        header("Location: user_login.php?error=1");
        exit();
    }
} else {
    // Redirect to login page if accessed directly
    header("Location: user_login.php");
    exit();
}
?>
