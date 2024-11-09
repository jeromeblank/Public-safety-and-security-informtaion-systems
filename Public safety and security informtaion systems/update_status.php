<?php
// update_status.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have already added the 'status' column to your incidents table
    $servername = "localhost";
    $username = "id21629520_jeromecantos";
    $password = "@lexandeR81703";
    $dbname = "id21629520_user_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $incidentId = $_POST['incident_id'];
    $status = $_POST['status'];

    $sql = "UPDATE incidents SET status='$status' WHERE id=$incidentId";

    if ($conn->query($sql) === TRUE) {
        $confirmationMessage = "Status updated successfully!";
    } else {
        $confirmationMessage = "Error updating status: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirect if accessed directly
    header("Location: admin.php");
    exit();
}
?>

<!-- Rest of your HTML code -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inbox</title>
    <link rel="stylesheet" type="text/css" href="inbox.css"> <!-- Add your CSS file for styling -->
    <style>
        .confirmation {
            color: green; /* Set the color of the confirmation message */
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
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

    <table>

    </table>
</div>

</body>


