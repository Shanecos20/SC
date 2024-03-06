<!DOCTYPE html>
<html>

<head>
    <title>Database Information</title>
    <link rel="stylesheet" type="text/css" href="../style/data_display_style.css">
</head>

<body>
    <h1>Event Occurrence Delete</h1>
    <div class="container">

        <?php
        include('../db_connect.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $competitor_id = $_POST['competitor_id_delete']; // Get competitor ID from the form
        
            $stmt = $conn->prepare("DELETE FROM Competitors WHERE competitor_id = ?"); // Prepare SQL statement
        
            $stmt->bind_param("i", $competitor_id); // Bind parameter
        
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

        <a href="../eventsmgm.php" class="return-button">Return to Main Page</a>
    </div>
</body>

</html>