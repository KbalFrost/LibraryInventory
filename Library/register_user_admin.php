<?php
include('database_connection.php');

// Get data from the AJAX request
$newUsername = $_POST['newUsername'];
$newFullName = $_POST['newFullName'];
$newEmail = $_POST['newEmail'];
$newPhoneNumber = $_POST['newPhoneNumber'];
$newFavoriteBook = $_POST['newFavoriteBook'];
$newPassword = $_POST['newPassword'];
$userRole = "user";

// Use password hashing for authentication security
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Insert new user data into the database
$sql = "INSERT INTO USER (username, full_name, email, phone_number, favorite_book, password, user_role) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $newUsername, $newFullName, $newEmail, $newPhoneNumber, $newFavoriteBook, $hashedPassword, $userRole);
$stmt->execute();
$stmt->close();

$conn->close();

echo "New user registered successfully!";
?>
