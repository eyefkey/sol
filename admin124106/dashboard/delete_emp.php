<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create a connection to the database
    $servername = "localhost";
    $username = "root"; // Replace with your actual username
    $password = ""; // Replace with your actual password
    $dbname = "solsystem"; // Replace with your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the user inputs to prevent SQL injection
    $emp_ID = $_POST['emp_ID'];

    // Delete the record from the database
    $delete_query = "DELETE FROM user_info WHERE emp_ID='$emp_ID'";

    if ($conn->query($delete_query) === TRUE) {
        // If the record is successfully deleted, redirect to index.php
        header("Location: /sol/admin124106/dashboard/dashboard.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Remove Employee</title>
</head>
<body>
    <h2>Remove Employee</h2>
    <form action="delete_emp.php" method="post">
        <input type="text" name="emp_ID" placeholder="Enter Employee ID" required><br><br>
        <input type="submit" value="Delete Employee">
    </form>
</body>
</html>
