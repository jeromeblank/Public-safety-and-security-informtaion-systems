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

// Assuming you have already added the 'status' column to your incidents table
$sql = "SELECT * FROM incidents";
$result = $conn->query($sql);

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Inbox</title>
        <link rel="icon" type="image/x-icon" href="https://i.pinimg.com/originals/83/3d/cb/833dcbdfbb2a466c0bb30e563b6749c0.jpg">
        <link rel="stylesheet" type="text/css" href="inbox.css"> <!-- Add your CSS file for styling -->
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
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Department</th>
                <th>To</th>
                <th>Subject</th>
                <th>Text Entry</th>
                <th>Status</th> <!-- New column for status -->
                <th>Action</th> <!-- New column for delete button -->
            </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['department'] . "</td>";
                    echo "<td>" . $row['to_names'] . "</td>";
                    echo "<td>" . $row['subject'] . "</td>";
                    echo "<td>" . $row['text_entry'] . "</td>";

                    // Form for updating the status
                    echo "<td>";
                    echo "<form action='update_status.php' method='post'>";
                    echo "<input type='hidden' name='incident_id' value='{$row['id']}'>";
                    echo "<select name='status'>";
                    echo "<option value='Open' " . ($row['status'] == 'Open' ? 'selected' : '') . ">Open</option>";
                    echo "<option value='Solved' " . ($row['status'] == 'Solved' ? 'selected' : '') . ">Solved</option>";
                    echo "<option value='Ongoing' " . ($row['status'] == 'Ongoing' ? 'selected' : '') . ">Ongoing</option>";
                    echo "</select>";
                    echo "<input type='submit' value='Update'>";
                    echo "</form>";
                    echo "</td>";

                    // Delete button
                    echo "<td>";
                    echo "<form action='delete_incident.php' method='post'>";
                    echo "<input type='hidden' name='incident_id' value='{$row['id']}'>";
                    echo "<input type='submit' value='Delete'>";
                    echo "</form>";
                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No incidents found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    </body>

    </html>

<?php
$conn->close();
?>