<?php
session_start();

// Database connection
$servername = "localhost";  // Change if your DB is hosted elsewhere
$username = "root";         // Default XAMPP username
$password = "";             // Default XAMPP password (empty)
$database = "test";         // Change to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Prepare SQL statement to fetch user details
$stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Verify the hashed password
    if (password_verify($password, $hashed_password)) {
        $_SESSION['email'] = $email; // Start user session
        echo "<script>alert('Login successful!'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Invalid password!'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('User not found! Please check your email.'); window.location.href='login.html';</script>";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
