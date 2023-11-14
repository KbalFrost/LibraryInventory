<?php
session_start();
include('database_connection.php');

// Use page session for authorization
// Check if the user is logged in, if not, redirect to user_login.php
if (!isset($_SESSION["user_id"])) {
    header("Location: user_login.php");
    exit();
}

// Check the user's role for RBAC
if ($_SESSION['user_role'] !== 'user') {
    // Redirect to an unauthorized page or show an error message
    header("Location: unauthorized.php");
    exit();
}

// Retrieve availability information for all books
$result = $conn->query("SELECT b.title, b.ISBN_num, b.shelf, a.quantity FROM BOOK b
                        INNER JOIN AVAILABILITY a ON b.entry_num = a.book_entry_num
                        WHERE a.status = 'available' AND a.quantity > 0");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard - Library Inventory System</title>
</head>
<body>
    <div class="container">
        <h1>Library Inventory System</h1>
        <!-- Use output encoding to prevent XSS -->
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8'); ?>!</h2>
        <div id="clock"></div>

        <h4>Available Books:</h4>
        <table>
            <tr>
                <th>Title</th>
                <th>ISBN Number</th>
                <th>Shelf</th>
                <th>Quantity</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Use htmlspecialchars for output encoding
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['ISBN_num'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['shelf'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['quantity'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No available books</td></tr>";
            }
            ?>
        </table>

        <h1></h1>
        <button onclick="location.href='logout.php'" class="logout-button">Logout</button>
    </div>

    <script src="clock.js"></script>
</body>
</html>
