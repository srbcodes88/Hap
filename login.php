<?php
session_start();  // Start the session

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $input_password = $_POST['login_password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', 'MySQLSrB123*8', 'hap_database');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the hashed password and user_id from the database
    $stmt = $conn->prepare("SELECT password, user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($password, $user_id);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    // Correctly verify the password
    if (password_verify($input_password, $password)) {
        // Set the session variable for user_id
        $_SESSION['user_id'] = $user_id;

        // Redirect to the main page
        header("Location: index.html");
        exit();
    } else {
        $error_message = "Incorrect Password.";
    }
}

// Include the form HTML
include 'login.html';
?>
