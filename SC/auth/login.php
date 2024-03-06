<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

    <title>Login</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; 
            /* Use the 'Roboto' font */
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            font-family: 'Courier New', Courier, monospace; 
            /* Use the 'Roboto' font */
            text-align: center;
            font-size: 2em;
            color: #007BFF;
            margin-bottom: 5px;
            animation: colorChange 3s infinite alternate;
        }

        h4 {
            font-family: 'Courier New', Courier, monospace; 
            /* Use the 'Roboto' font */
            text-align: center;
            color: #007BFF;
            margin-bottom: 5px;
            animation: colorChange 3s infinite alternate;
        }

        label {
            font-family: 'Courier New', Courier, monospace; 
            /* Use the 'Roboto' font */
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


        input[type="submit"],
        input[type="button"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: darkgoldenrod;
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
        <br>
        <h4>Event Management System</h4><br>
        <form action="authenticate.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Login">
            <input type="button" class="register-button" value="Register" onclick="window.location.href='register.php'" />

        </form>
    </div>
</body>

</html>