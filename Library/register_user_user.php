<?php
include('database_connection.php');

// Function to sanitize user input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate email format
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Process registration form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $newUsername = sanitizeInput($_POST["new-username"]);
    $newPassword = sanitizeInput($_POST["new-password"]);
    $confirmPassword = sanitizeInput($_POST["confirm-password"]);
    $fullName = sanitizeInput($_POST["full-name"]);
    $email = sanitizeInput($_POST["email"]);
    $phoneNumber = sanitizeInput($_POST["phone-number"]);
    $favoriteBook = sanitizeInput($_POST["favorite-book"]);
    $userRole = "user";

    // Validate user inputs
    if (empty($newUsername) || empty($newPassword) || empty($confirmPassword) || empty($fullName)) {
        echo "Please fill in all required fields.";
    } elseif ($newPassword !== $confirmPassword) {
        echo "Passwords do not match.";
    } elseif (!empty($email) && !isValidEmail($email)) {
        echo "Invalid email format.";
    } else {
        // Use password hashing for authentication security
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO USER (username, password, full_name, email, phone_number, favorite_book, user_role) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
        if ($stmt === false) {
            die("Error: " . $conn->error);
        }
    
        $stmt->bind_param("sssssss", $newUsername, $hashedPassword, $fullName, $email, $phoneNumber, $favoriteBook, $userRole);

        // Use echo displaying message for error handling
        if ($stmt->execute()) {
            echo "<script>alert('User registered successfully!'); window.location.href='user_login.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
    }
}

$conn->close();
?>
