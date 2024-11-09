<?php
$servername = "localhost";
$username = "id21629520_jeromecantos";
$password = "@lexandeR81703";
$dbname = "id21629520_user_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department = $_POST["department"];
    $to = $_POST["to"];
    $subject = $_POST["subject"];
    $textEntry = $_POST["text_entry"];

    $sql = "INSERT INTO incidents (department, to_names, subject, text_entry) VALUES ('$department', '$to', '$subject', '$textEntry')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message sent!');</script>";
        redirectToHomepage();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function redirectToHomepage() {
    echo "<script>window.location.href = 'menu.html';</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Registry</title>
    <link rel="icon" type="image/x-icon" href="https://i.pinimg.com/originals/83/3d/cb/833dcbdfbb2a466c0bb30e563b6749c0.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="message.css"> <!-- Link to the external CSS file -->

    <!-- Add this script to the head section -->
    <script>
        function validateForm() {
            var department = document.getElementById("department").value;
            var to = document.getElementById("to").value;
            var subject = document.getElementById("subject").value;
            var textEntry = document.getElementById("text_entry").value;

            if (department === "" || to === "" || subject === "" || textEntry === "") {
                alert("Please fill in all fields.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>

<header>
    <h1>Incident Registry</h1>
</header>

<div class="container">

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">

        <div class="row">
            <div class="col-sm-6">
                <label for="department">Department:</label>
                <select name="department" id="department">
                    <option value="1">Police Department</option>
                    <option value="2">Fire Department</option>
                    <option value="3">Hospital Department</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label for="to">To:</label>
                <input type="text" name="to" id="to" placeholder="Insert Names">
            </div>

            <div class="col-sm-6">
                <label for="subject">Subject:</label>
                <input type="text" name="subject" id="subject" placeholder="Insert Subject">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label for="text_entry">Text Entry:</label>
                <textarea name="text_entry" id="text_entry" rows="10"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <a href="menu.html" class="btn btn-default">Cancel</a>
            </div>

            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </div>

    </form>

</div>

</body>

</html>
