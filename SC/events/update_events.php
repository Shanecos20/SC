<!DOCTYPE html>
<html>

<head>
    <title>Database Information</title>
    <link rel="stylesheet" type="text/css" href="../style/data_display_style.css">
</head>

<body>
    <h1>Event Insert</h1>
    <div class="container">

        <?php
        include('../db_connect.php'); // Include database connection
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $event_id = $_POST['event_id_update'];
            $event_name = $_POST['event_name_update'];
            $venue_id = $_POST['venue_id_update']; 
            $event_date = $_POST['event_date_update'];

            $stmt = $conn->prepare("UPDATE Events SET event_name = ?, event_date = ?, venue_id = ? WHERE event_id = ?"); // Prepare SQL update statement
        
            $stmt->bind_param("ssii", $event_name, $event_date, $venue_id, $event_id); // Bind parameters
        
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