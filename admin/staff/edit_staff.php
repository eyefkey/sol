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

    // Update the record in the database
    $update_query = "UPDATE employee_info SET emp_fname='$emp_fname', emp_mname='$emp_mname', emp_lname='$emp_lname', emp_username='$emp_username', password='$password', role='$role' WHERE emp_ID='$emp_ID'";

    if ($conn->query($update_query) === TRUE) {
        // If the data is successfully updated, redirect the user back to the personnel table page or the desired location
        header("Location: staff.php"); // Replace with the appropriate URL
        exit();
    } else {
        // If an error occurs during the update, display an error message
        echo "Error updating record: " . $conn->error;
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
    <title>Edit Staff</title>
</head>
<body>
    <h2>Edit Staff</h2>
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
    <form action="edit_staff.php" method="post">
        <input type="text" name="emp_fname" placeholder="First Name" required><br><br>
        <input type="text" name="emp_mname" placeholder="Middle Initial" required><br><br>
        <input type="text" name="emp_lname" placeholder="Last Name" required><br><br>
        <input type="text" name="emp_ID" placeholder="ID Number" required><br><br>
        <input type="text" name="emp_username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <select name="role">
            <option value="Administrator">Administrator</option>
            <option value="Staff">Staff</option>
            <option value="Faculty">Faculty</option>
        </select><br><br>
        <input type="submit" name="submit" value="Edit Staff">
    </form>
</body>
</html>
