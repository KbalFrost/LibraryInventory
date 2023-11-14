<?php
// unauthorized.php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Error</title>
</head>
<body>

<div class="container">
    <h1>Access Denied</h1>
    <p>Error accessing the page.</p>
    <p><a href="index.php">Home</a></p>
</div>

</body>
</html>