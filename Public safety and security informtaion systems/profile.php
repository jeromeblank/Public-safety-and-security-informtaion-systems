<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

$userData = $_SESSION['user_data'];

$servername = "localhost";
$username = "id21629520_jeromecantos";
$password = "@lexandeR81703";
$dbname = "id21629520_user_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission for updating the username and deleting the account
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_username'])) {
        // Handle updating the username
        $newUsername = filter_input(INPUT_POST, 'new_username', FILTER_SANITIZE_STRING);

        // Add validation logic as needed

        $userData['username'] = $newUsername;

        $userId = $_SESSION['user_id'];
        $updateSql = "UPDATE users SET username = '$newUsername' WHERE id = $userId";

        if ($conn->query($updateSql) === TRUE) {
            // Username updated successfully in the database
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating username: " . $conn->error;
        }
    } elseif (isset($_POST['delete_account'])) {
        // Handle deleting the account
        $userId = $_SESSION['user_id'];
        $deleteSql = "DELETE FROM users WHERE id = $userId";

        if ($conn->query($deleteSql) === TRUE) {
            // Account deleted successfully from the database
            // Destroy the session and redirect to index.php
            session_destroy();
            header("Location: index.php");
            exit();
        } else {
            echo "Error deleting account: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="icon" type="image/x-icon" href="https://i.pinimg.com/originals/83/3d/cb/833dcbdfbb2a466c0bb30e563b6749c0.jpg">
    <link rel="stylesheet" type="text/css" href="profile.css"> <!-- Add your CSS file if needed -->
</head>

<body>

<header>
    <div class="logo">
        <img src="https://i.pinimg.com/originals/83/3d/cb/833dcbdfbb2a466c0bb30e563b6749c0.jpg" alt="Logo">
    </div>
    <div class="title">
        <h1>User Profile</h1>
    </div>
</header>

<nav>
    <a href="reportcrime.php">Report Crime</a>
    <a href="#">About us</a>
    <a href="Directory.html">Directory</a>
    <a href="profile.php">User Profile</a>
</nav>

<div class="content-container">
    <h2>Welcome, <?php echo $userData['username']; ?>!</h2>

    <!-- Form for updating the username -->
    <form method="post" action="">
        <label for="new_username">Update Username:</label>
        <input type="text" id="new_username" name="new_username" required>
        <input type="submit" name="update_username" value="Update Username">
    </form>

    <!-- Form for deleting the account -->
    <form method="post" action="">
        <input type="submit" name="delete_account" value="Delete Account" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
    </form>

    <button onclick="logout()">Logout</button>
    <button onclick="redirectToHomepage()">Go to Homepage</button>
</div>

<footer>
    <p>Public Safety and Security Information Systems ™</p>
</footer>

<!-- JavaScript to handle redirection and logout -->
<script>
    function redirectToHomepage() {
        window.location.href = "menu.html";
    }

    function logout() {
        window.location.href = "index.php";
    }
</script>

</body>

</html>
