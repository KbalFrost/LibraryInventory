<?php
include('database_connection.php');

// Get data from the AJAX request
$username = $_POST['username'];
$fullName = $_POST['fullName'];
$email = $_POST['email'];
$phoneNumber = $_POST['phoneNumber'];
$favoriteBook = $_POST['favoriteBook'];

// Update the user information in the database
$sql = "UPDATE USER SET full_name = ?, email = ?, phone_number = ?, favorite_book = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $fullName, $email, $phoneNumber, $favoriteBook, $username);
$stmt->execute();
$stmt->close();

$conn->close();

echo "User information updated successfully!";
?>
