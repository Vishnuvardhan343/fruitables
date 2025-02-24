<?php
// Database connection settings
$servername = "localhost";  // Change if your server differs
$username = "root";         // Default in XAMPP
$password = "";             // Default password is empty in XAMPP
$database = "test";   // Replace with your actual database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "<script>alert('An account with this email already exists!'); window.history.back();</script>";
        exit;
    }

    // Insert new user into the database
    $insertQuery = "INSERT INTO users (name, email, phone, address, password) 
                    VALUES ('$name', '$email', '$phone', '$address', '$hashed_password')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('Signup successful! Please login.'); window.location.href='login.html';</script>";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>
