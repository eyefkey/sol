<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "solsystem";

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
require_once("dbconfig.php");

$sub_ID = isset($_GET['sub_ID']) ? $_GET['sub_ID'] : '';

// If the form is submitted, update the data
if (isset($_POST['update'])) {
    $sub_ID = $_POST['sub_ID'];
    $emp_ID = $_POST['emp_ID'];
    $sub_name = $_POST['sub_name'];
    $semester = $_POST['semester'];
    $units = $_POST['units'];
    $school_year = $_POST['school_year'];

    // Perform the update only if you have valid data
    if (!empty($emp_ID) && !empty($sub_name) && !empty($semester) && !empty($units) && !empty($school_year)) {
        mysqli_query($mysqli, "UPDATE sub_info SET emp_ID='$emp_ID', sub_name='$sub_name', semester=$semester, units=$units, school_year='$school_year' WHERE sub_ID=$sub_ID");
    }
}

// Fetch the data for the specified sub_ID
$result = mysqli_query($mysqli, "SELECT * FROM sub_info WHERE sub_ID = '$sub_ID'");

if ($result && mysqli_num_rows($result) > 0) {
    $resultData = mysqli_fetch_assoc($result);
    $emp_ID = $resultData['emp_ID'];
    $sub_name = $resultData['sub_name'];
    $semester = $resultData['semester'];
    $units = $resultData['units'];
    $school_year = $resultData['school_year'];
} else {
    // Handle the case where the result set is empty
    $emp_ID = $sub_name = $semester = $units = $school_year = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
</head>
<body>
    <h1>Edit Subjects</h1>
    <form name="edit" method="post" action="edit_proc.php">
        <label for="sub_ID">Subject Code:</label>
        <input type="text" name="sub_ID" value="<?php echo $sub_ID; ?>" required>
        <br>
        <label for="emp_ID">Employee ID:</label>
        <input type="text" name="emp_ID" value="<?php echo $emp_ID; ?>" required>
        <br>
        <label for="sub_name">Subject Name:</label>
        <input type="text" name="sub_name" value="<?php echo $sub_name; ?>" required>
        <br>
        <label for="semester">Semester:</label>
        <input type="text" name="semester" value="<?php echo $semester; ?>" required>
        <br>
        <label for="units">Units:</label>
        <input type="text" name="units" value="<?php echo $units; ?>" required>
        <br>
        <label for="school_year">School Year:</label>
        <input type="text" name="school_year" value="<?php echo $school_year; ?>" required>
        <br>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>
