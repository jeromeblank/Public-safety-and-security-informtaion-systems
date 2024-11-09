<?php
$servername = "localhost";
$username = "id21629520_jeromecantos";
$password = "@lexandeR81703";
$dbname = "id21629520_user_database";
$redirectUrl = "menu.html";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loginMessage = $registerMessage = "";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Check if the provided credentials are for the admin
        if ($username === "admin1" && $password === "admin81703") {
            $_SESSION['user_data'] = ['is_admin' => true];
            header("Location: admin.php");
            exit();
        }

        // If not admin, proceed with regular user login
        $userData = validateLogin($username, $password);
        if ($userData) {
            $_SESSION['user_data'] = $userData; // Save the user data to the session
            if ($userData['is_admin']) {
                header("Location: admin.php");
            } else {
                $loginMessage = "<p>Welcome, {$userData['username']}!</p>";
                $_SESSION['user_id'] = $userData['id'];
                header("Location: $redirectUrl");
            }
            exit();
        } else {
            $loginMessage = "<p>Invalid username or password. Please try again.</p>";
        }
    }

    if (isset($_POST["register"])) {
        $newUsername = $_POST["newUsername"];
        $newPassword = $_POST["newPassword"];

        if (registerUser($newUsername, $newPassword)) {
            // Registration successful, redirect to login form
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $registerMessage = "<p>Error registering user. Please try again.</p>";
        }
    }
}

$conn->close();

function validateLogin($username, $password) {
    global $conn;
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            return $row;
        }
    }
    return false;
}

function registerUser($newUsername, $newPassword) {
    global $conn;
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES ('$newUsername', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['registration_success'] = true;
        return true;
    } else {
        // Add error handling
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <link rel="icon" type="image/x-icon" href="https://i.pinimg.com/originals/83/3d/cb/833dcbdfbb2a466c0bb30e563b6749c0.jpg">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

<header>
    <div class="header-title">
        <h1>Public Safety and Security Information System</h1>
    </div>
</header>

<div class="background-container">

    <!-- Login Form -->
    <div class="form-container login-form" id="loginForm">
        <h2>Login</h2>
        <?php echo $loginMessage; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>

    <!-- Registration Form -->
    <div class="form-container register-form" id="registerForm" style="display: none;">
        <h2>Register</h2>
        <?php
        if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
            echo "<p>Registration successful! You can now log in.</p>";
            unset($_SESSION['registration_success']); // Clear the session variable
        } else {
            echo $registerMessage;
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="newUsername">New Username:</label>
            <input type="text" name="newUsername" required>
            <label for="newPassword">New Password:</label>
            <input type="password" name="newPassword" required>
            <button type="submit" name="register">Register</button>
        </form>
    </div>

    <!-- Register Button -->
    <button class="toggle-register-form-btn" onclick="toggleRegisterForm()">Create Account</button>

</div>

<script>
    // JavaScript function to toggle between login and registration forms
    function toggleRegisterForm() {
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        if (loginForm.style.display !== 'none') {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        } else {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
        }
    }
</script>

</body>

</html>
