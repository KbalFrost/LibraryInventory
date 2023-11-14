<?php
include('database_connection.php');

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: admin_login.php");
    exit();
}

// Function to get book data based on availability status
function getBooks($status) {
    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT ISBN_num, title, author, publisher, version, shelf, quantity, status FROM BOOK INNER JOIN AVAILABILITY ON BOOK.entry_num = AVAILABILITY.book_entry_num";

    // Add WHERE clause based on availability status
    if ($status === 'available' || $status === 'unavailable') {
        $query .= " WHERE status = '" . $status . "'";
    }

    $result = $conn->query($query);

    $books = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }

    $conn->close();

    return $books;
}

// Get all books initially (no filter)
$allBooks = getBooks('all');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Book Management - Library Inventory System</title>
</head>
<body>
    <div class="book-container">
        <h1>Library Inventory System</h1>
        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
        <h3>Book Management</h3>
        
        <div id="clock"></div>

        <div class="two-sides">
            <div class="left-side">
                <h4>New Book Registration</h4>

                <form id="registrationForm" onsubmit="return saveBook()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="isbn">ISBN Number:</label>
                            <input type="text" id="isbn" name="isbn" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" id="title" name="title" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="author">Author:</label>
                            <input type="text" id="author" name="author" required>
                        </div>
                        <div class="form-group">
                            <label for="publisher">Publisher:</label>
                            <input type="text" id="publisher" name="publisher">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="version">Version:</label>
                            <input type="text" id="version" name="version">
                        </div>
                        <div class="form-group">
                            <label for="shelf">Shelf:</label>
                            <input type="text" id="shelf" name="shelf">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="availability">Availability:</label>
                            <select id="availability" name="availability" required>
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit">Save</button>
                </form>
            </div>
            
            <div class="right-side">
                <h4>Book Information</h4>

                <div class="filter-buttons">
                    <button onclick="openSearchDialog()">Search</button>
                    <button onclick="showAvailableBooks()">Available</button>
                    <button onclick="showUnavailableBooks()">Unavailable</button>
                    <button onclick="refreshBookTable()()">Refresh</button>
                </div>

                <table id="bookTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ISBN Number</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="bookRow">
                        <?php
                        foreach ($allBooks as $book) {
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
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="searchDialog" class="dialog">
                <form id="searchForm">
                    <label for="searchTerm">Search Book:</label>
                    <input type="text" id="searchTerm" name="searchTerm" placeholder="Enter book name or ISBN number">
                    <button type="button" onclick="searchBooks()">Search</button>
                    <button type="button" onclick="closeSearchDialog()">Close</button>
                </form>
            </div>
            
            <div id="editDialog" class="dialog">
                <form id="editForm">
                    <label for="editIsbn">ISBN Number:</label>
                    <input type="text" id="editIsbn" name="editIsbn" readonly>

                    <label for="editTitle">Title:</label>
                    <input type="text" id="editTitle" name="editTitle" required>

                    <label for="editAuthor">Author:</label>
                    <input type="text" id="editAuthor" name="editAuthor" required>

                    <label for="editPublisher">Publisher:</label>
                    <input type="text" id="editPublisher" name="editPublisher">

                    <label for="editVersion">Version:</label>
                    <input type="text" id="editVersion" name="editVersion">

                    <label for="editShelf">Shelf:</label>
                    <input type="text" id="editShelf" name="editShelf">

                    <label for="editQuantity">Quantity:</label>
                    <input type="number" id="editQuantity" name="editQuantity" required>

                    <button type="button" onclick="closeEditDialog()">Close</button>
                    <button type="button" onclick="saveEdit()">Save</button>
                    <button type="button" onclick="confirmDelete()">Delete</button>
                </form>
            </div>
        </div>
        
        <button onclick="location.href='admin_dashboard.php'" class="back-button">Back</button>
    </div>

    <script src="clock.js"></script>
    <script src="book.js"></script>
</body>
</html>
