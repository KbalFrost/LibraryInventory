<?php
include('database_connection.php');

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: admin_login.php");
    exit();
}

// Retrieve user data from the database
$sql = "SELECT * FROM USER";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $allUsers = [];
    while ($row = $result->fetch_assoc()) {
        $allUsers[] = $row;
    }
} else {
    $allUsers = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>User Management - Library Inventory System</title>
</head>

<body>
    <div class="container">
        <h1>Library Inventory System</h1>
        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
        <h3>User Management</h3>

        <div id="clock"></div>
        
        <div class="filter-buttons">
            <button id="newUserButton" onclick="openNewUserDialog()">New User</button>
        </div>
        
        <table id="userTable">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Favorite Book</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($allUsers as $user) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['phone_number']) . "</td>";
                    echo "<td>" . $user['favorite_book'] . "</td>";
                    echo "<td>";
                    echo "<button onclick='editUser(\"" . $user['username'] . "\", \"" . $user['full_name'] . "\", \"" . $user['email'] . "\", \"" . $user['phone_number'] . "\", \"" . $user['favorite_book'] . "\")'>Edit</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div id="newUserDialog" class="dialog">
            <form id="newUserForm">
                <label for="newUsername">Username:</label>
                <input type="text" id="newUsername" name="newUsername" required>

                <label for="newFullName">Full Name:</label>
                <input type="text" id="newFullName" name="newFullName" required>

                <label for="newEmail">Email:</label>
                <input type="text" id="newEmail" name="newEmail">

                <label for="newPhoneNumber">Phone Number:</label>
                <input type="text" id="newPhoneNumber" name="newPhoneNumber">

                <label for="newFavoriteBook">Favorite Book:</label>
                <input type="text" id="newFavoriteBook" name="newFavoriteBook">

                <label for="newPassword">Password:</label>
                <input type="password" id="newPassword" name="newPassword" required>

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>

                <button type="button" onclick="closeNewUserDialog()">Close</button>
                <button type="button" onclick="saveNewUser()">Save</button>
            </form>
        </div>
                
        <div id="editUserDialog" class="dialog">
            <form id="editUserForm">
                <label for="editUsername">Username:</label>
                <input type="text" id="editUsername" name="editUsername" readonly>

                <label for="editFullName">Full Name:</label>
                <input type="text" id="editFullName" name="editFullName" required>

                <label for="editEmail">Email:</label>
                <input type="text" id="editEmail" name="editEmail">

                <label for="editPhoneNumber">Phone Number:</label>
                <input type="text" id="editPhoneNumber" name="editPhoneNumber">

                <label for="editFavoriteBook">Favorite Book:</label>
                <input type="text" id="editFavoriteBook" name="editFavoriteBook">

                <button type="button" onclick="closeEditUserDialog()">Close</button>
                <button type="button" onclick="saveEditUser()">Save</button>
                <button type="button" onclick="confirmDeleteUser()">Delete</button>
            </form>
        </div>

        <h1></h1>
        <button onclick="location.href='admin_dashboard.php'" class="back-button">Back</button>

        <script src="clock.js"></script>
        <script src="user.js"></script>
    </div>
</body>

</html>
