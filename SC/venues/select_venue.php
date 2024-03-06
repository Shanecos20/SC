<!DOCTYPE html>
<html>

<head>
    <title>Venue Information</title>
    <link rel="stylesheet" type="text/css" href="../style/data_display_style.css">
</head>

<body>
    <h1>Venue Information Page</h1>
    <div class="container">
        <!-- Display venue information in a table -->
        <div class="sort-buttons">
    <button id="sortById" class="sort-button">Sort by ID</button>
    <button id="sortByName" class="sort-button">Sort by Name</button>
    <button id="sortByLocation" class="sort-button">Sort by Location</button>
</div>


        <table>
            <thead>
                <tr>
                    <th>Venue ID</th>
                    <th>Name</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../db_connect.php'); // Include database connection
                
                $search = $_GET['search_venue']; // Get search input from form
                
                $sql = "SELECT venue_id, venue_name, venue_location FROM Venues WHERE venue_name LIKE ?"; // SQL query to search Venues
                $stmt = $conn->prepare($sql); // Prepare SQL statement
                $searchTerm = "%$search%"; // Prepare search term
                $stmt->bind_param("s", $searchTerm); // Bind search parameter
                $stmt->execute(); // Execute the query
                
                $result = $stmt->get_result(); // Get query result
                
                if ($result->num_rows > 0) { // Check if there are results
                    while ($row = $result->fetch_assoc()) { // Iterate through results and display data
                        echo "<tr>";
                        echo "<td>" . $row["venue_id"] . "</td>";
                        echo "<td>" . $row["venue_name"] . "</td>";
                        echo "<td>" . $row["venue_location"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No results found</td></tr>"; // No results found
                }

                $conn->close(); // Close the database connection
                ?>
            </tbody>
        </table>

        <a href="../eventsmgm.php" class="return-button">Return to Main Page</a>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tableBody = document.querySelector("tbody");
        const rows = Array.from(tableBody.querySelectorAll("tr"));

        document.getElementById("sortById").addEventListener("click", () => {
            sortTable(rows, 0); // Sort by ID (column 0)
        });

        document.getElementById("sortByName").addEventListener("click", () => {
            sortTable(rows, 1); // Sort by Name (column 1)
        });

        document.getElementById("sortByLocation").addEventListener("click", () => {
            sortTable(rows, 2); // Sort by Location (column 3)
        });

        function sortTable(rows, columnIndex) {
            rows.sort((a, b) => {
                const textA = a.cells[columnIndex] ? a.cells[columnIndex].textContent.trim() : "";
                const textB = b.cells[columnIndex] ? b.cells[columnIndex].textContent.trim() : "";
                return textA.localeCompare(textB);
            });

            tableBody.innerHTML = "";

            rows.forEach((row) => {
                tableBody.appendChild(row);
            });
        }
    });
</script>

</body>

</html>