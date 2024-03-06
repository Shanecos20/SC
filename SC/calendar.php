<?php
include 'db_connect.php';

function build_calendar($month, $year, $events) {
    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');

    $calendar = "<table class='calendar'>";
    $calendar .= "<caption>$monthName $year</caption>";
    $calendar .= "<tr>";

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    } 

    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) { 
        for ($k = 0; $k < $dayOfWeek; $k++) { 
            $calendar .= "<td></td>"; 
        }
    }

    $currentDay = 1;

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    
    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }
      
        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";

        $dayname = strtolower(date('l', strtotime($date)));
        $eventDay = $events[$date] ?? false;

        if ($dateToday == $date){
            $calendar .= "<td class='day current-day' rel='$date'>$currentDay</td>";
        } elseif ($eventDay) {
            $calendar .= "<td class='day event-day' rel='$date'>$currentDay</td>";
        } else {
            $calendar .= "<td class='day' rel='$date'>$currentDay</td>";
        }

        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) { 
        $remainingDays = 7 - $dayOfWeek;
        for ($i = 0; $i < $remainingDays; $i++) { 
            $calendar .= "<td></td>"; 
        }
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    return $calendar;
}

function fetchEvents($conn, $month, $year) {
    $events = [];
    $sql = "SELECT event_date FROM events WHERE MONTH(event_date) = $month AND YEAR(event_date) = $year";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $events[$row['event_date']] = true;
        }
    }
    return $events;
}

$month = date('m');
$year = date('Y');

$events = fetchEvents($conn, $month, $year);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="style/style.css"> <!-- Link to your CSS file -->
    <script src="scripts/script.js" defer></script> <!-- Link to your JavaScript file -->
</head>
<body>
    <?php echo build_calendar($month, $year, $events); ?>
</body>
</html>