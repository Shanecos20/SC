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
            $competitor_id = $conn->real_escape_string($_POST['competitor_id']); // Get and sanitize input
            $competitor_name = $conn->real_escape_string($_POST['competitor_name']);
            $industry = $conn->real_escape_string($_POST['industry']);
            $event_id = $conn->real_escape_string($_POST['event_id']); // Assume competitors are linked to events
        
            $sql = "INSERT INTO Competitors (competitor_id, competitor_name, industry, event_id) VALUES ('$competitor_id', '$competitor_name', '$industry', '$event_id')"; // SQL query to insert into Competitors
        
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