<?php
$result = $_POST['result'];
$subject = $_POST['subject'];

if ($result >= 70) { 
    echo "Passed: Grade A <br />";
}
elseif ($result >= 60) {
    echo "Passed: Grade B <br />";
}
elseif ($result >= 50) {
    echo "Passed: Grade C <br />";
}
elseif ($result >= 40) {
    echo "Passed: Grade D <br />";
}
else {
    echo "Failed <br />";
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Net Pay Calculator Extended</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
    <main>
        
        <br>
        <label>SUBJECT:</label>
        <span><?php echo $subject; ?></span>
        <br><br>

        <label>RESULT:</label>
        <span><?php echo $result; ?></span>
        <label>%</label>
        <br><br>

       
    </main>
</body>
</html>