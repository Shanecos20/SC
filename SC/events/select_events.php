<!DOCTYPE html>
<html>

<head>
    <title>Events Information</title>
    <link rel="stylesheet" type="text/css" href="../style/data_display_style.css">
</head>

<body>
    <h1>Events Information Page</h1>
    <div class="container">
        <!-- Sort buttons -->
        <div class="sort-buttons">
            <button id="sortByEventId" class="sort-button">Sort by Event ID</button>
            <button id="sortByName" class="sort-button">Sort by Name</button>
            <button id="sortByDate" class="sort-button">Sort by Date</button>
            <button id="sortByVenueId" class="sort-button">Sort by Venue ID</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Venue ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../db_connect.php');
                $search = $_GET['search_event'];
                $sql = "SELECT event_id, event_name, event_date, venue_id FROM Events WHERE event_name LIKE ?";
                $stmt = $conn->prepare($sql);
                $searchTerm = "%$search%";
                $stmt->bind_param("s", $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["event_id"] . "</td>";
                        echo "<td>" . $row["event_name"] . "</td>";
                        echo "<td>" . $row["event_date"] . "</td>";
                        echo "<td>" . $row["venue_id"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No results found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <a href="../eventsmgm.php" class="return-button">Return to Main Page</a>
    </div>

    <script>
        
        document.addEventListener("DOMContentLoaded", function () {
            const tableBody = document.querySelector("tbody");
            const rows = Array.from(tableBody.querySelectorAll("tr"));

            document.getElementById("sortByEventId").addEventListener("click", () => {
                sortTable(rows, 0);
            });
            document.getElementById("sortByName").addEventListener("click", () => {
                sortTable(rows, 1);
            });
            document.getElementById("sortByDate").addEventListener("click", () => {
                sortTable(rows, 2);
            });
            document.getElementById("sortByVenueId").addEventListener("click", () => {
                sortTable(rows, 3);
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
