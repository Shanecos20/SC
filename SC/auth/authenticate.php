<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>Login</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            font-family: 'Roboto', sans-serif;
            text-align: center;
            font-size: 2em;
            color: #007BFF;
            margin-bottom: 20px;
            animation: colorChange 3s infinite alternate;
        }

        label {
            font-family: 'Roboto', sans-serif;
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            text-align: center;
            
        }

        .login-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
            margin: 0 auto;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: block;
            margin: 0 auto;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: darkolivegreen;
        }

        @keyframes colorChange {
            0% {
                color: #4CAF50;
            }
            100% {
                color: #333;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php
        session_start();

        if (isset($_POST['username']) && isset($_POST['password'])) {
            $entered_username = $_POST['username'];
            $entered_password = $_POST['password'];

            // Database connection parameters
            $servername = "localhost";
            $db_username = "root"; // Replace with your database username
            $db_password = ""; // Replace with your database password
            $dbname = "eventsmgm";

            // Create connection
            $conn = new mysqli($servername, $db_username, $db_password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to retrieve the hashed password for the entered username
            $query = "SELECT username, password FROM users WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $entered_username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];

                // Verify the entered password against the hashed password
                if (password_verify($entered_password, $hashed_password)) {
                    $_SESSION['username'] = $entered_username;
                    header("Location: ../eventsmgm.php");
                    exit();
                } else {
                    echo "Invalid username or password. Please try again.";
                }
            } else {
                echo "Invalid username or password. Please try again.";
            }

            // Close the database connection
            $conn->close();
        }
        ?>
        <form method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required><br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required><br>
            <input type="submit" value="Login">
        </form>
    
    </div>
</body>

</html>