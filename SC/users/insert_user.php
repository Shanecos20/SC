<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "eventsmgm"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user input from form
$user = $_POST['username'];
$plainTextPassword = $_POST['password'];

// Hash the password
$hashedPassword = password_hash($plainTextPassword, PASSWORD_DEFAULT);

// SQL query to insert the new user
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";

// Prepare and bind
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $hashedPassword);

// Execute the query
if ($stmt->execute() === TRUE) {
    echo "New record created successfully";
    // Optionally, redirect to the login page after successful registration
    header("Location: ../auth/login.php");
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
