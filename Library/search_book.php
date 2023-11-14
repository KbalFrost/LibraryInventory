<?php
include('database_connection.php');

// Get data from the AJAX request
$searchTerm = $_POST['searchTerm'];

// SQL query to search books by name or ISBN number, and fetch quantity and availability
$sql = "
    SELECT B.*, A.quantity, A.status
    FROM BOOK B
    LEFT JOIN AVAILABILITY A ON B.entry_num = A.book_entry_num
    WHERE B.title LIKE ? OR B.ISBN_num LIKE ?
";
$stmt = $conn->prepare($sql);
$searchTermWithWildcards = '%' . $searchTerm . '%';
$stmt->bind_param("ss", $searchTermWithWildcards, $searchTermWithWildcards);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Display the search results in the book table
while ($book = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>";
    echo "<button onclick='editBook(\"" . $book['ISBN_num'] . "\", \"" . $book['title'] . "\", \"" . $book['author'] . "\", \"" . $book['publisher'] . "\", \"" . $book['version'] . "\", \"" . $book['shelf'] . "\", \"" . $book['quantity'] . "\")'>Edit</button>";
    echo "</td>";
    echo "<td>" . htmlspecialchars($book['ISBN_num']) . "</td>";
    echo "<td>" . htmlspecialchars($book['title']) . "</td>";
    echo "<td>" . htmlspecialchars($book['author']) . "</td>";
    echo "<td>" . htmlspecialchars($book['quantity']) . "</td>";
    echo "<td id='statusCell" . $book['ISBN_num'] . "'>" . $book['status'] . "</td>";
    
    echo "<td>";
    echo "<select id='statusDropdown" . $book['ISBN_num'] . "'>";
    echo "<option value='available'>Available</option>";
    echo "<option value='unavailable'>Unavailable</option>";
    echo "</select>";
    echo "<button onclick='changeStatus(\"" . $book['ISBN_num'] . "\")'>Change</button>";
    echo "</td>";

    echo "</tr>";
}

// Close the database connection
$conn->close();
?>
