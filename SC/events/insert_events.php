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
            $event_id = $conn->real_escape_string($_POST['event_id']); 
            $event_name = $conn->real_escape_string($_POST['event_name']);
            $venue_id = $conn->real_escape_string($_POST['venue_id']);
            $event_date = $conn->real_escape_string($_POST['event_date']);

            $sql = "INSERT INTO Events (event_id, event_name, venue_id, event_date) VALUES ('$event_id','$event_name', '$venue_id', '$event_date')"; // SQL query to insert into Events
        
            if ($conn->query($sql) === TRUE) {
                echo '<div class="message-container">New record created successfully</div>'; // Successful record creation
            } else {
                echo '<div class="message-container">Error: ' . $sql . "<br>" . $conn->error . '</div>'; // Error message
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