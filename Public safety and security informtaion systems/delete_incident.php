<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_data']) || !$_SESSION['user_data']['is_admin']) {
    header("Location: login.php"); // Redirect to the login page if not logged in or not an admin
    exit();
}

$servername = "localhost";
$username = "id21629520_jeromecantos";
$password = "@lexandeR81703";
$dbname = "id21629520_user_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $incidentId = $_POST['incident_id'];

    // Perform deletion
    $deleteSql = "DELETE FROM incidents WHERE id = $incidentId";

    if ($conn->query($deleteSql) === TRUE) {
        $confirmationMessage = "Incident deleted successfully!";
    } else {
        $confirmationMessage = "Error deleting incident: " . $conn->error;
    }
} else {
    $confirmationMessage = "Invalid request";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inbox</title>
    <link rel="icon" type="image/x-icon" href="https://i.pinimg.com/originals/83/3d/cb/833dcbdfbb2a466c0bb30e563b6749c0.jpg">
    <link rel="stylesheet" type="text/css" href="inbox.css"> <!-- Your existing CSS file -->
</head>

<body>

<header>
    <h1>Admin Inbox</h1>
</header>

<nav>
    <a href="admin.php" class="home">Home</a>
    <a href="inbox.php">Inbox</a>
    <a href="index.php" class="logout">Logout</a>
</nav>

<div class="container">
    <?php
    if (isset($confirmationMessage)) {
        echo "<div class='confirmation'>$confirmationMessage</div>";
    }
    ?>

    <!-- rest of your content... -->

</div>

</body>

</html>
