<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Create a connection to the database
    $servername = "localhost";
    $username = "root"; // Replace with your actual username
    $password = ""; // Replace with your actual password
    $dbname = "crms"; // Replace with your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the user inputs to prevent SQL injection
    $emp_fname = mysqli_real_escape_string($conn, $_POST['emp_fname']);
    $emp_mname = mysqli_real_escape_string($conn, $_POST['emp_mname']);
    $emp_lname = mysqli_real_escape_string($conn, $_POST['emp_lname']);  
    $emp_ID = mysqli_real_escape_string($conn, $_POST['emp_ID']);
    $emp_username = mysqli_real_escape_string($conn, $_POST['emp_username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Perform necessary validation, such as checking for empty fields and matching passwords
    $error = [];

    if (empty($emp_fname)) {
        $error[] = "First Name is required.";
    }
    if (empty($emp_mname)) {
        $error[] = "Middle Initial is required.";
    }
    if (empty($emp_lname)) {
        $error[] = "Last name is required.";
    }

    if (empty($emp_ID)) {
        $error[] = "ID Number is required.";
    }

    if (empty($emp_username)) {
        $error[] = "ID Number is required.";
    }

    if (empty($password)) {
        $error[] = "Password is required.";
    }

    // If there are any errors, display them to the user
    if (count($error) > 0) {
        foreach ($error as $err) {
            echo "<p>$err</p>";
        }
    } else {
        // Create and execute the SQL query
        $insert_query = "INSERT INTO employee_info(emp_fname, emp_mname, emp_lname, emp_ID, emp_username, password, role) VALUES ('$emp_fname', '$emp_mname', '$emp_lname', '$emp_ID', '$emp_username', '$password', '$role')";

        if ($conn->query($insert_query) === TRUE) {
            // If the data is successfully inserted, redirect the user back to the dashboard table page
            header("Location: staff.php");
            exit();
        } else {
            // If an error occurs during the insertion, display an error message
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
</head>
<body>
    <h2>Add Staff/Faculty</h2>
    <style>
        h2 {
            text-align: center;
        }
        form {
            max-width: 300px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: calc(50% - 5px); /* Adjust width to fit two inputs in a row */
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%; /* Make the submit button full width */
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Adjust input width for smaller screens */
        @media (max-width: 500px) {
            input[type="text"],
            input[type="password"],
            select {
                width: 100%; /* Make inputs full width on smaller screens */
            }
        }
        
</style>
    <form action="add_staff.php" method="post">
        <input type="text" name="emp_fname" placeholder="First Name" required>
        <input type="text" name="emp_mname" placeholder="Middle Initial" required>
        <input type="text" name="emp_lname" placeholder="Last Name" required>
        <input type="text" name="emp_ID" placeholder="ID Number" required>
        <input type="text" name="emp_username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role">
            <option value="Admin">Administrator</option>
            <option value="Staff">Staff</option>
            <option value="Faculty">Faculty</option>
        </select>
        <input type="submit" name="submit" value="Add Staff">
    </form>
</body>
</html>
