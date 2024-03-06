<!DOCTYPE html>
<html>

<head>
    <title>Database Information</title>
    <link rel="stylesheet" type="text/css" href="../style/data_display_style.css">
</head>

<body>
    <h1>Event Occurrence Update</h1>
    <div class="container">

        <?php
        include('../db_connect.php'); // Include database connection
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $event_occurrence_id = $_POST['event_occurrence_id_update'];
            $event_id = $_POST['event_id_update'];
            $sequence_number = $_POST['sequence_number_update'];
            $event_occurrence_date = $_POST['event_occurrence_date_update'];

            $stmt = $conn->prepare("UPDATE Event_Occurrences SET event_id = ?, sequence_number = ?, 
                            event_occurrence_date = ? WHERE event_occurrence_id = ?"); // Prepare SQL update statement
            $stmt->bind_param("iisi", $event_id, $sequence_number, $event_occurrence_date, $event_occurrence_id); // Bind parameters
        
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