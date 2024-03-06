<?php
include('../db_connect.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to delete all entries
$sql = "DELETE FROM db_modifications";

if ($conn->query($sql) === TRUE) {
    echo "All history entries deleted successfully";
    header("Location: ../eventsmgm.php"); 
} else {
    echo "Error deleting history: " . $conn->error;
}

$conn->close();
?>
