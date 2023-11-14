<?php
include('database_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data from the AJAX request
    $isbn = $_POST["isbn"];
    $title = $_POST["title"];
    $author = $_POST["author"];
    $publisher = $_POST["publisher"];
    $version = $_POST["version"];
    $shelf = $_POST["shelf"];
    $quantity = $_POST["quantity"];
    $availability = $_POST["availability"];

    // Use prepared statements to prevent SQL injection
    $query_book = "INSERT INTO BOOK (ISBN_num, title, author, publisher, version, shelf) VALUES (?, ?, ?, ?, ?, ?)";
    $query_availability = "INSERT INTO AVAILABILITY (book_entry_num, status, quantity) VALUES (?, ?, ?)";

    // Initialize prepared statements
    $stmt_book = $conn->prepare($query_book);
    $stmt_availability = $conn->prepare($query_availability);

    if ($stmt_book && $stmt_availability) {
        $stmt_book->bind_param("ssssss", $isbn, $title, $author, $publisher, $version, $shelf);
        $stmt_book->execute();

        // Get the last inserted book entry ID
        $book_entry_num = $stmt_book->insert_id;

        $stmt_availability->bind_param("iss", $book_entry_num, $availability, $quantity);
        $stmt_availability->execute();

        $stmt_book->close();
        $stmt_availability->close();

        echo "Book registered successfully!";
    } else {
        echo "Error registering book!";
    }

    $conn->close();
}
?>
