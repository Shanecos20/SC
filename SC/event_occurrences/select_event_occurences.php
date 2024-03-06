<!DOCTYPE html>
<html>

<head>
    <title>Event Occurrence Information</title>
    <link rel="stylesheet" type="text/css" href="../style/data_display_style.css">
</head>

<body>
    <h1>Event Occurrence Information Page</h1>
    <div class="container">
        <!-- Sort buttons -->
        <div class="sort-buttons">
            <button id="sortByEventOccurrenceId" class="sort-button">Sort by Occurrence ID</button>
            <button id="sortByEventId" class="sort-button">Sort by Event ID</button>
            <button id="sortBySequenceNumber" class="sort-button">Sort by Sequence Number</button>
            <button id="sortByDate" class="sort-button">Sort by Date</button>
        </div>

        <!-- Display event occurrence information in a table -->
        <table>
            <thead>
                <tr>
                    <th>Event Occurrence ID</th>
                    <th>Event ID</th>
                    <th>Sequence Number</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../db_connect.php');
                $search = $_GET['search_event_occurrence'];
                $sql = "SELECT event_occurrence_id, event_id, sequence_number, event_occurrence_date 
                        FROM Event_Occurrences WHERE event_id LIKE ?";
                $stmt = $conn->prepare($sql);
                $searchTerm = "%$search%";
                $stmt->bind_param("s", $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["event_occurrence_id"] . "</td>";
                        echo "<td>" . $row["event_id"] . "</td>";
                        echo "<td>" . $row["sequence_number"] . "</td>";
                        echo "<td>" . $row["event_occurrence_date"] . "</td>";
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

            document.getElementById("sortByEventOccurrenceId").addEventListener("click", () => {
                sortTable(rows, 0);
            });
            document.getElementById("sortByEventId").addEventListener("click", () => {
                sortTable(rows, 1);
            });
            document.getElementById("sortBySequenceNumber").addEventListener("click", () => {
                sortTable(rows, 2);
            });
            document.getElementById("sortByDate").addEventListener("click", () => {
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
