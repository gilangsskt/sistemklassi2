<?php
session_start();
include "includes/config.php";


// Initialize message variable
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create a prepared statement
    $stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        // User found, start the session and redirect to index.php
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        // User not found, set error message
        $message = "Invalid username or password";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$koneksi->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Klasifikasi</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <div class="login-page">
        <h1>Login</h1>
        <p>Selamat Datang Kembali!!</p>
        <?php
        if ($message === "success") {
            echo "<script>window.location.href = 'index.php';</script>";
        } elseif (!empty($message)) {
            echo "<p class='error-message'>$message</p>";
        }
        ?>
        <form action="login.php" method="post">
            <div class="form-login">
                <label for="username">Username</label>
                <br>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-login">
                <label for="password">Password</label>
                <br>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="bt-form-login">
                <button type="submit">Login</button>
            </div>
        </form>

</body>

</html>