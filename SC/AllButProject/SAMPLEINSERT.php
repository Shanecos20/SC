 <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emptdept";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Escape user inputs for security

$DEPTNO = $_POST['DEPTNO'];

$DNAME = $_POST['DNAME'];

$LOC = $_POST ['LOC'];

 

// attempt insert query execution

mysqli_query($conn, "INSERT INTO DEPT (DEPTNO, DNAME, LOC) VALUES ('$DEPTNO', '$DNAME', '$LOC')");

if(mysqli_affected_rows($conn)>0){

    echo "Records added successfully.";

} else{

    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);

}

 

// close connection

mysqli_close($conn);

?>