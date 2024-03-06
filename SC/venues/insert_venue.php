<!DOCTYPE html>
<html>

<head>
    <title>Database Information</title>
    <link rel="stylesheet" type="text/css" href="../style/data_display_style.css">
</head>

<body>
    <h1>Venue Insert</h1>
    <div class="container">

        <?php
        include('../db_connect.php'); // Include database connection
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $venue_id = $conn->real_escape_string($_POST['venue_id']); 
            $venue_name = $conn->real_escape_string($_POST['venue_name']);
            $venue_location = $conn->real_escape_string($_POST['venue_location']);

            $sql = "INSERT INTO Venues (venue_id, venue_name, venue_location) VALUES ('$venue_id','$venue_name', '$venue_location')"; // SQL query to insert into Venues
        
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