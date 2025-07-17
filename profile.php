<?php
session_start(); // Start the session

include('database.php'); // Ensure this file contains your database connection

// Check if form data was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Fetch user from the database based on email
    $sql = "SELECT user_id, name, email, password FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variable
            $_SESSION['user_id'] = $user['user_id']; // Store the user ID in the session
        } else {
            // Incorrect password
            echo "Invalid credentials!";
        }
    } else {
        // User not found
        echo "User not found!";
    }
} 

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user information from the database
$sql = "SELECT name, email, phone, dob FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "Unable to fetch user information.";
    exit();
}

include 'profile.html'
?>

