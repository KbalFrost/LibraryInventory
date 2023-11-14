<?php
// Logout by destroying the session
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Logout</title>
</head>
<body>

<script>
    // Show a popup message when the page loads
    window.onload = function () {
        alert("You have successfully logged out!");
        window.location.href = "index.php";
    };
</script>

</body>
</html>

