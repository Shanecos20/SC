<!DOCTYPE html>

<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit();
}

function fetchModificationHistory()
{
    include_once "db_connect.php";

    $modifications = array();

    $sql = "SELECT * FROM db_modifications ORDER BY timestamp DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($modifications, $row);
        }
    }

    $conn->close();
    return $modifications;
}
?>
<html>

<head>
    <title>Event Management System</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link rel="stylesheet" type="text/css" href="style/data_display_style.css">
    <script src="scripts/script.js"></script>

</head>

<body>



    <form method="post" action="auth/logout.php" class="logout-form">
        <input type="submit" value="Logout" class="logout-button">
    </form>

    <div id="UserMsg">
        <span class="username"> </span><span id="typedUsername" class="username"></span>

        <div id="hiddenUsername" style="display: none;">Welcome
            <?php echo htmlspecialchars($_SESSION['username']); ?>
        </div>
    </div>

    <h1>Event Management System - <span id="datetime"></span></h1>



    <div id="calendar-header"></div>
    <div id="calendar"></div>


    <div class="mod-history-container">
        <h2>Modification History</h2>
        <form action="db_modifications/delete_history.php" method="post">
            <input type="submit" value="Delete All History"
                onclick="return confirm('Are you sure you want to delete all history entries?');">
        </form>




        <?php
        $modifications = fetchModificationHistory(); // Call the function to get modification records.
        if (!empty($modifications)): ?>
            <?php foreach ($modifications as $mod): ?>
                <div class="mod-history-entry">
                    <?php
                    echo htmlspecialchars($mod['timestamp'] . " - " . $mod['modification_type'] . " on " . $mod['table_modified'] . " - " . $mod['modification_details']);
                    ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-modifications">No modifications found.</p>
        <?php endif; ?>
    </div>


    <!-- Section for managing Venues (Table 1) -->
    <div class="table-section" id="table1-section">
        <h2 onclick="toggleSection('table1')">Venues</h2>
        <div class="forms-container" id="table1-forms">
            <!-- Forms for Insert, Search, Update, and Delete operations on Venues -->
            <!-- Insert Venue form -->
            <form action="venues/insert_venue.php" method="post">
                <h3>Insert Venue</h3>
                <label for="venue_id">Venue ID:</label>
                <input type="text" id="venue_id" name="venue_id">

                <label for="venue_name">Venue Name:</label>
                <input type="text" id="venue_name" name="venue_name" required>

                <label for="venue_location">Venue Location:</label>
                <input type="text" id="venue_location" name="venue_location" required>

                <input type="submit" value="Insert">
            </form>

            <!-- Search Venues form -->
            <form action="venues/select_venue.php" method="get">
                <h3>Search Venues</h3>
                <label for="search_venue">Search by Name:</label>
                <input type="text" id="search_venue" name="search_venue">

                <input type="submit" value="Search">
            </form>

            <!-- Update Venue form -->
            <form action="venues/update_venue.php" method="post">
                <h3>Update Venue</h3>

                <label for="venue_id_update">Select Venue:</label>
                <select id="venue_id_update" name="venue_id_update" required>
                    <?php
                    include('db_connect.php'); // Make sure this path is correct
                    $result = $conn->query("SELECT venue_id, venue_name, venue_location FROM Venues");

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["venue_id"] . "'>" . $row["venue_name"] . " - " . $row["venue_location"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No venues available</option>";
                    }
                    $conn->close();
                    ?>
                </select>

                <label for="venue_name_update">New Venue Name:</label>
                <input type="text" id="venue_name_update" name="venue_name_update">

                <label for="venue_location_update">New Venue Location:</label>
                <input type="text" id="venue_location_update" name="venue_location_update">

                <input type="submit" value="Update">
            </form>


            <!-- Delete Venue form -->
            <form action="venues/delete_venue.php" method="post" onsubmit="return confirmDelete()">
                <h3>Delete Venue</h3>
                <label for="venue_id_delete">Venue ID:</label>
                <input type="number" id="venue_id_delete" name="venue_id_delete" required>
                <input type="submit" value="Delete">
            </form>
        </div>
    </div>

    <!-- Section for managing Competitors (Table 2) -->
    <div class="table-section" id="table2-section">
        <h2 onclick="toggleSection('table2')">Competitors</h2>
        <div class="forms-container" id="table2-forms">
            <!-- Forms for Insert, Search, Update, and Delete operations on Competitors -->
            <!-- Insert Competitor form -->
            <form action="competitors/insert_competitors.php" method="post">
                <h3>Insert Competitor</h3>
                <label for="competitor_id">Competitor ID:</label>
                <input type="text" id="competitor_id" name="competitor_id">

                <label for="competitor_name">Competitor Name:</label>
                <input type="text" id="competitor_name" name="competitor_name" required>

                <label for="industry">Industry:</label>
                <input type="text" id="industry" name="industry" required>

                <label for="event_id">Event ID:</label>
                <input type="text" id="event_id" name="event_id">

                <input type="submit" value="Insert">
            </form>

            <!-- Search Competitors form -->
            <form action="competitors/select_competitors.php" method="get">
                <h3>Search Competitors</h3>
                <label for="search_competitor">Search by Name:</label>
                <input type="text" id="search_competitor" name="search_competitor">

                <input type="submit" value="Search">
            </form>

            <!-- Update Competitor form -->
            <form action="competitors/update_competitors.php" method="post">
                <h3>Update Competitor</h3>
                <label for="competitors_id_update">Competitor ID:</label>
                <input type="number" id="competitors_id_update" name="competitors_id_update" required>

                <label for="competitor_name_update">New Competitor Name:</label>
                <input type="text" id="competitor_name_update" name="competitor_name_update">

                <label for="industry_update">New Industry:</label>
                <input type="text" id="industry_update" name="industry_update">

                <label for="event_id_update">Event ID:</label>
                <input type="text" id="event_id_update" name="event_id_update">

                <input type="submit" value="Update">
            </form>

            <!-- Delete Competitor form -->
            <form action="competitors/delete_competitors.php" method="post" onsubmit="return confirmDelete()">
                <h3>Delete Competitor</h3>
                <label for="competitor_id_delete">Competitor ID:</label>
                <input type="number" id="competitor_id_delete" name="competitor_id_delete" required>
                <input type="submit" value="Delete">
            </form>
        </div>
    </div>

    <!-- Section for managing Events (Table 3) -->
    <div class="table-section" id="table3-section">
        <h2 onclick="toggleSection('table3')">Events</h2>
        <div class="forms-container" id="table3-forms">
            <!-- Forms for Insert, Search, Update, and Delete operations on Events -->
            <!-- Insert Event form -->
            <form action="events/insert_events.php" method="post">
                <h3>Insert Event</h3>
                <label for="event_id">Event ID:</label>
                <input type="text" id="event_id" name="event_id">

                <label for="event_name">Event Name:</label>
                <input type="text" id="event_name" name="event_name" required>

                <label for="event_date">Event Date:</label>
                <input type="date" id="event_date" name="event_date" required>

                <label for="venue_id">Venue ID:</label>
                <input type="text" id="venue_id" name="venue_id" required>

                <input type="submit" value="Insert">
            </form>

            <!-- Search Events form -->
            <form action="events/select_events.php" method="get">
                <h3>Search Events</h3>
                <label for="search_event">Search by Name:</label>
                <input type="text" id="search_event" name="search_event">

                <input type="submit" value="Search">
            </form>

            <!-- Update Event form -->
            <form action="events/update_events.php" method="post">
                <h3>Update Event</h3>
                <label for="event_id_update">Event ID:</label>
                <input type="number" id="event_id_update" name="event_id_update" required>

                <label for="event_name_update">New Event Name:</label>
                <input type="text" id="event_name_update" name="event_name_update">

                <label for="event_date_update">New Event Date:</label>
                <input type="date" id="event_date_update" name="event_date_update" required>

                <label for="venue_id_update">Venue ID:</label>
                <input type="text" id="venue_id_update" name="venue_id_update" required>

                <input type="submit" value="Update">
            </form>

            <!-- Delete Event form -->
            <form action="events/delete_events.php" method="post" onsubmit="return confirmDelete()">
                <h3>Delete Event</h3>
                <label for="event_id_delete">Event ID:</label>
                <input type="number" id="event_id_delete" name="event_id_delete" required>
                <input type="submit" value="Delete">
            </form>
        </div>
    </div>

    <!-- Section for managing Event Occurrences (Table 4) -->
    <div class="table-section" id="table4-section">
        <h2 onclick="toggleSection('table4')">Event Occurrences</h2>
        <div class="forms-container" id="table4-forms">
            <!-- Forms for Insert, Search, Update, and Delete operations on Event Occurrences -->
            <!-- Insert Event Occurrence form -->
            <form action="event_occurrences/insert_event_occurences.php" method="post">
                <h3>Insert Event Occurrence</h3>
                <label for="event_occurrence_id">Event Occurrence ID:</label>
                <input type="text" id="event_occurrence_id" name="event_occurrence_id">

                <label for="event_id">Event ID:</label>
                <input type="text" id="event_id" name="event_id" required>

                <label for="sequence_number">Sequence Number:</label>
                <input type="number" id="sequence_number" name="sequence_number" required>

                <label for="event_occurrence_date">Event Occurrence Date:</label>
                <input type="date" id="event_occurrence_date" name="event_occurrence_date" required>

                <input type="submit" value="Insert">
            </form>

            <!-- Search Event Occurrences form -->
            <form action="event_occurrences/select_event_occurences.php" method="get">
                <h3>Search Event Occurrences</h3>
                <label for="search_event_occurrence">Search by Event ID:</label>
                <input type="text" id="search_event_occurrence" name="search_event_occurrence">

                <input type="submit" value="Search">
            </form>

            <!-- Update Event Occurrence form -->
            <form action="event_occurrences/update_event_occurences.php" method="post">
                <h3>Update Event Occurrence</h3>
                <label for="event_occurrence_id_update">Event Occurrence ID:</label>
                <input type="number" id="event_occurrence_id_update" name="event_occurrence_id_update" required>

                <label for="event_id_update">Event ID:</label>
                <input type="text" id="event_id_update" name="event_id_update" required>

                <label for="sequence_number_update">New Sequence Number:</label>
                <input type="number" id="sequence_number_update" name="sequence_number_update" required>

                <label for="event_occurrence_date_update">New Event Occurrence Date:</label>
                <input type="date" id="event_occurrence_date_update" name="event_occurrence_date_update" required>

                <input type="submit" value="Update">
            </form>

            <!-- Delete Event Occurrence form -->
            <form action="event_occurrences/delete_event_occurences.php" method="post"
                onsubmit="return confirmDelete()">
                <h3>Delete Event Occurrence</h3>
                <label for="event_occurrence_id_delete">Event Occurrence ID:</label>
                <input type="number" id="event_occurrence_id_delete" name="event_occurrence_id_delete" required>
                <input type="submit" value="Delete">
            </form>
        </div>
    </div>




</body>

</html>