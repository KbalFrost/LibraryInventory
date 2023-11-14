<?php
include('database_connection.php');

// Get data from the AJAX request
$isbn = $_POST['isbn'];

$conn->begin_transaction();

// Delete the book information in the AVAILABILITY table
$sqlAvailability = "DELETE FROM AVAILABILITY WHERE book_entry_num = (SELECT entry_num FROM BOOK WHERE ISBN_num = ?)";
$stmtAvailability = $conn->prepare($sqlAvailability);
$stmtAvailability->bind_param("s", $isbn);
$stmtAvailability->execute();

// Delete the book information in the BOOK table
$sqlBook = "DELETE FROM BOOK WHERE ISBN_num = ?";
$stmtBook = $conn->prepare($sqlBook);
$stmtBook->bind_param("s", $isbn);
$stmtBook->execute();

$conn->commit();
$stmtBook->close();
$stmtAvailability->close();
$conn->close();

echo "Book information updated successfully!";
?>
