<!DOCTYPE html>
<html>

<head>
    <title>Database Information</title>
    <link rel="stylesheet" type="text/css" href="../style/data_display_style.css">
</head>

<body>
    <h1>Event Delete</h1>
    <div class="container">

        <?php
        include('../db_connect.php'); // Include database connection
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $event_id = $_POST['event_id_delete']; // Get event ID from form
        
            $stmt = $conn->prepare("DELETE FROM Events WHERE event_id = ?"); // Prepare SQL delete statement
            $stmt->bind_param("i", $event_id); // Bind parameter
        
            if ($stmt->execute()) {
                echo "Record deleted successfully"; // Successful deletion
            } else {
                echo "Error deleting record: " . $conn->error; // Error message
            }

            $stmt->close(); // Close the statement
        }

        $conn->close(); // Close the database connection
        ?>
        </tbody>
        </table>

        <!-- Add a button to return to the main page -->
        <a href="../eventsmgm.php" class="return-button">Return to Main Page</a>
    </div>
</body>

</html>