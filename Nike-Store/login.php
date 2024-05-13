<?php
$host = "localhost";
$user = "root";
$password = ""; 
$db = "test12"; // Ensure this database exists

session_start();
$conn = mysqli_connect($host, $user, $password, $db);

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION["username"] = $username;
        $_SESSION["usertype"] = $row["usertype"];

        if ($row["usertype"] == "user") {
            header("Location: index.html"); // Redirect to a user-specific page
        } elseif ($row["usertype"] == "admin") {
            header("Location: adminhome.php"); // Redirect to the admin page
        }
    } else {
        echo "Username or password incorrect";
    }
}
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-form">
        <h1>Login Form</h1>
        <form action="login.php" method="POST">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
</body>
</html>
