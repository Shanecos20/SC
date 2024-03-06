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
        include('../db_connect.php'); // Include database connection
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $competitor_id = $_POST['competitor_id_update'];
            $competitor_name = $_POST['competitor_name_update'];
            $industry = $_POST['industry_update'];
            $event_id = $_POST['event_id_update']; // Competitors linked to events
        
            $stmt = $conn->prepare("UPDATE Competitors SET competitor_name = ?, industry = ?, event_id = ? WHERE competitor_id = ?"); // Prepare SQL update statement
        
            $stmt->bind_param("ssii", $competitor_name, $industry, $event_id, $competitor_id); // Bind parameters
        
            if ($stmt->execute()) {
                echo "Record updated successfully"; // Successful update
            } else {
                echo "Error updating record: " . $conn->error; // Error message
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