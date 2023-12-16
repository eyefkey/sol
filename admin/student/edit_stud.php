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

$stud_ID = isset($_GET['stud_ID']) ? $_GET['stud_ID'] : '';

// If the form is submitted, update the data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $stud_ID = $_POST['stud_ID'];
    $stud_lname = $_POST['stud_lname'];
    $stud_fname = $_POST['stud_fname'];
    $stud_mname = $_POST['stud_mname'];
    $yr_lvl = $_POST['yr_lvl'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $email_add = $_POST['email_add'];

    // Perform the update only if you have valid data
    if (!empty($stud_lname) && !empty($stud_fname) && !empty($yr_lvl) && !empty($semester) && !empty($email_add)) {
        $update_query = "UPDATE student_info 
                         SET stud_lname='$stud_lname', 
                             stud_fname='$stud_fname', 
                             stud_mname='$stud_mname', 
                             yr_lvl='$yr_lvl', 
                             semester='$semester', 
                             section='$section', 
                             email_add='$email_add' 
                         WHERE stud_ID='$stud_ID'";

        if ($mysqli->query($update_query) === TRUE) {
            header('location: /sol/admin/student/student.php');
            exit();
        } else {
            echo "Error updating record: " . $mysqli->error;
        }
    }
}

// Fetch the data for the specified stud_ID
$result = mysqli_query($mysqli, "SELECT * FROM student_info WHERE stud_ID = '$stud_ID'");

if ($result && mysqli_num_rows($result) > 0) {
    $resultData = mysqli_fetch_assoc($result);
    $stud_lname = $resultData['stud_lname'];
    $stud_fname = $resultData['stud_fname'];
    $stud_mname = $resultData['stud_mname'];
    $yr_lvl = $resultData['yr_lvl'];
    $semester = $resultData['semester'];
    $section = $resultData['section'];
    $email_add = $resultData['email_add'];
} else {
    // Handle the case where the result set is empty
    $stud_lname = $stud_fname = $stud_mname = $yr_lvl = $semester = $section = $email_add = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Students</h1>
    <form name="edit" method="post" action="">
        <label for="stud_ID">Student ID:</label>
        <input type="text" name="stud_ID" value="<?php echo $stud_ID; ?>" required>
        <br>
        <label for="stud_lname">Last Name:</label>
        <input type="text" name="stud_lname" value="<?php echo $stud_lname; ?>" required>
        <br>
        <label for="stud_fname">First Name:</label>
        <input type="text" name="stud_fname" value="<?php echo $stud_fname; ?>" required>
        <br>
        <label for="stud_mname">Middle Name:</label>
        <input type="text" name="stud_mname" value="<?php echo $stud_mname; ?>">
        <br>
        <label for="yr_lvl">Year Level:</label>
        <input type="text" name="yr_lvl" value="<?php echo $yr_lvl; ?>" required>
        <br>
        <label for="semester">Semester:</label>
        <input type="text" name="semester" value="<?php echo $semester; ?>" required>
        <br>
        <label for="section">Section:</label>
        <input type="text" name="section" value="<?php echo $section; ?>">
        <br>
        <label for="email_add">Email Address:</label>
        <input type="text" name="email_add" value="<?php echo $email_add; ?>" required>
        <br>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>
