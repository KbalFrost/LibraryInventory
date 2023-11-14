<?php
include('database_connection.php');

// Get data from the AJAX request
$username = $_POST['username'];

// Delete the user data from the database
$sql = "DELETE FROM USER WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->close();

$conn->close();

echo "User deleted successfully!";
?>
