<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_data']) || !$_SESSION['user_data']['is_admin']) {
    header("Location: login.php"); // Redirect to the login page if not logged in or not an admin
    exit();
}

// Establish a database connection
$servername = "localhost";
$username = "id21629520_jeromecantos";
$password = "@lexandeR81703";
$dbname = "id21629520_user_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM incidents";
$result = $conn->query($sql);

// Your admin page content goes here
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="icon" type="image/x-icon" href="https://i.pinimg.com/originals/83/3d/cb/833dcbdfbb2a466c0bb30e563b6749c0.jpg">
</head>

<body>

<header>
    <h1>Admin Dashboard</h1>
</header>

<nav>
    <a href="inbox.php">Inbox</a>
    <a href="index.php" class="logout">Logout</a>
</nav>

<div class="container">
    <div class="dashboard-section">
        <h2>Welcome, Admin!</h2>
        <p>Explore the various features of your admin dashboard.</p>
        <!-- Add more content, charts, or modules as needed -->
    </div>
</div>

<?php
// Close the database connection
$conn->close();
?>

</body>

</html>
