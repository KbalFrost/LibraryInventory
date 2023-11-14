<?php
include('database_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ISBN"]) && isset($_POST["newStatus"])) {
    // Get data from the AJAX request
    $ISBN = $_POST["ISBN"];
    $newStatus = $_POST["newStatus"];

    // Update the status in the database
    $query = "UPDATE AVAILABILITY SET status = ? WHERE book_entry_num = (SELECT entry_num FROM BOOK WHERE ISBN_num = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $newStatus, $ISBN);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>
