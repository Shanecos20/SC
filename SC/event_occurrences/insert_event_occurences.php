<!DOCTYPE html>
<html>

<head>
    <title>Database Information</title>
    <link rel="stylesheet" type="text/css" href="../style/data_display_style.css">
</head>

<body>
    <h1>Event Occurrence Insert</h1>
    <div class="container">

        <?php
        include('../db_connect.php'); // Include database connection
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $event_occurrence_id = $conn->real_escape_string($_POST['event_occurrence_id']); 
            $event_id = $conn->real_escape_string($_POST['event_id']);
            $sequence_number = $conn->real_escape_string($_POST['sequence_number']);
            $event_occurrence_date = $conn->real_escape_string($_POST['event_occurrence_date']);

            $sql = "INSERT INTO Event_Occurrences (event_occurrence_id, event_id, sequence_number, event_occurrence_date) 
            VALUES ('$event_occurrence_id', '$event_id', '$sequence_number', '$event_occurrence_date')"; // SQL query to insert into Event_Occurrences
        
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully"; // Successful record creation
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error; // Error message
            }
        }

        $conn->close(); // Close the database connection
        ?>
        </tbody>
        </table>

        <a href="../eventsmgm.php" class="return-button">Return to Main Page</a>
    </div>
</body>

</html>