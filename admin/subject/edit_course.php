<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
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
    $sub_ID = mysqli_real_escape_string($conn, $_POST['sub_ID']);
    $emp_ID = mysqli_real_escape_string($conn, $_POST['emp_ID']);
    $sub_name = mysqli_real_escape_string($conn, $_POST['sub_name']);
    $yr_lvl = mysqli_real_escape_string($conn, $_POST['yr_lvl']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $units = mysqli_real_escape_string($conn, $_POST['units']);
    $school_year = mysqli_real_escape_string($conn, $_POST['school_year']);

    // Update the record in the database
    $update_query = "UPDATE sub_info SET emp_ID='$emp_ID', sub_name='$sub_name', yr_lvl='$yr_lvl', semester='$semester', units='$units', school_year='$school_year' WHERE sub_ID='$sub_ID'";

    if ($conn->query($update_query) === TRUE) {
        // If the data is successfully updated, redirect the user back to the subject table page or the desired location
        header("Location: subject.php"); // Replace with the appropriate URL
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
    <title>Edit Course</title>
</head>
<style>
        /* CSS styles */
        h2 {
            text-align: center;
        }
        .form-container1 {
            max-width: 300px; /* Adjust max-width as needed */
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .form-container1 input[type="text"],
        .form-container1 select {
            width: calc(50% - 5px); /* Adjust width to fit the container with padding and border */
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container1 input[type="submit"] {
            width: 100%; /* Make the submit button full width */
            background-color: #4caf50;
            color: white;
            padding: 10px 0; /* Adjust vertical padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container1 input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Adjust input width for smaller screens */
        @media (max-width: 500px) {
            .form-container1 input[type="text"],
            .form-container1 select {
                width: 100%; /* Make inputs full width on smaller screens */
            }
        }
    </style>
<body>
    <h2>Edit Course</h2>
    <div class="form-container1">
    <form action="edit_course.php" method="post">
        <input type="text" name="sub_ID" placeholder="Subject Code" required>
        <input type="text" name="emp_ID" placeholder="Employee ID" required>
        <input type="text" name="sub_name" placeholder="Subject Name" required>
        <select name="yr_lvl">
            <option value="1st">1st Year</option>
            <option value="2nd">2nd Year</option>
            <option value="3rd">3rd Year</option>
            <option value="4th">4th Year</option>
        </select>
        <select name="semester">
            <option value="1st">1st Semester</option>
            <option value="2nd">2nd Semester</option>
        </select>
        <input type="text" name="units" placeholder="Units" required>
        <input type="text" name="school_year" placeholder="School Year" required>   
        <input type="submit" name="update" value="Update Subject">
    </form>
    </div>
</body>
</html>
