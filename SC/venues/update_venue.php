<!DOCTYPE html>
<html>

<head>
    <title>Database Information</title>
    <link rel="stylesheet" type="text/css" href="../style/data_display_style.css">
</head>

<body>
    <h1>Venue Update</h1>
    <div class="container">

        <?php
        include('../db_connect.php'); // Include database connection
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $venue_id = $_POST['venue_id_update'];
            $venue_name = $_POST['venue_name_update'];
            $venue_location = $_POST['venue_location_update'];

            $stmt = $conn->prepare("UPDATE Venues SET venue_name = ?, venue_location = ? WHERE venue_id = ?"); // Prepare SQL update statement
        
            $stmt->bind_param("ssi", $venue_name, $venue_location, $venue_id); // Bind parameters
        
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