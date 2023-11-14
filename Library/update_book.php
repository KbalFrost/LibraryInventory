<?php
include('database_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the AJAX request
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $version = $_POST['version'];
    $shelf = $_POST['shelf'];
    $quantity = $_POST['quantity'];

    $conn->begin_transaction();

    // Update the book information in the BOOK table
    $sqlBook = "UPDATE BOOK SET title = ?, author = ?, publisher = ?, version = ?, shelf = ? WHERE ISBN_num = ?";
    $stmtBook = $conn->prepare($sqlBook);
    $stmtBook->bind_param("ssssss", $title, $author, $publisher, $version, $shelf, $isbn);
    $stmtBook->execute();

    // Update the quantity in the AVAILABILITY table
    $sqlAvailability = "UPDATE AVAILABILITY SET quantity = ? WHERE book_entry_num = (SELECT entry_num FROM BOOK WHERE ISBN_num = ?)";
    $stmtAvailability = $conn->prepare($sqlAvailability);
    $stmtAvailability->bind_param("is", $quantity, $isbn);
    $stmtAvailability->execute();

    $conn->commit();
    $stmtBook->close();
    $stmtAvailability->close();
    $conn->close();

    echo "Book information updated successfully!";
}
?>
