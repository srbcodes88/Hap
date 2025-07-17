<?php
include('database.php'); // Ensure this file contains your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize user input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $unique_string = $name . time() . rand();
    $user_id = substr(sha1($unique_string), 0, 5); 

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email_query = "SELECT * FROM users WHERE email='$email'";
    $email_result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($email_result) > 0) {
        echo "Email already exists. Please choose another one.";
        exit();
    }

    // Prepare the SQL query to insert the user data
    $sql = "INSERT INTO users (user_id, name, dob, email, phone, password) 
            VALUES ('$user_id', '$name', '$dob', '$email', '$phone', '$hashed_password')";

    // Execute the query and check for errors
    if (mysqli_query($conn, $sql)) {
        echo "Registration successful!";
        header("Location: login.html"); // Redirect to login page after successful registration
        exit();
    } else {
        echo "Error: " . mysqli_error($conn); // Display error message if there's an issue
    }
}
?>
