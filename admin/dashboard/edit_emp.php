<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
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
    $emp_fname = mysqli_real_escape_string($conn, $_POST['emp_fname']);
    $emp_mname = mysqli_real_escape_string($conn, $_POST['emp_mname']);
    $emp_lname = mysqli_real_escape_string($conn, $_POST['emp_lname']);  
    $emp_ID = mysqli_real_escape_string($conn, $_POST['emp_ID']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Update the record in the database
    $update_query = "UPDATE user_info SET emp_fname='$emp_fname', emp_mname='$emp_mname', emp_lname='$emp_lname', password='$password', role='$role' WHERE emp_ID='$emp_ID'";

    if ($conn->query($update_query) === TRUE) {
        // If the data is successfully updated, redirect the user back to the personnel table page or the desired location
        header("Location: /sol/admin/dashboard/dashboard.php"); // Replace with the appropriate URL
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
    <title>Edit Personnel</title>
</head>
<body>
    <h2>Edit Personnel</h2>
    <form action="edit_emp.php" method="post">
        <input type="text" name="emp_fname" placeholder="First Name" required><br><br>
        <input type="text" name="emp_mname" placeholder="Middle Initial" required><br><br>
        <input type="text" name="emp_lname" placeholder="Last Name" required><br><br>
        <input type="text" name="emp_ID" placeholder="ID Number" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <select name="role">
            <option value="Faculty">Faculty</option>
            <option value="Admin">Admin</option>
        </select><br><br>
        <input type="submit" name="submit" value="Edit Personnel">
    </form>
</body>
</html>
