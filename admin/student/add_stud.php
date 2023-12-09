<?php
// Include your database configuration file
include 'conf.php';
include 'dbconfig.php';

// Initialize variables
$message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $studID = mysqli_real_escape_string($conn, $_POST['stud_id']);
    $fname = mysqli_real_escape_string($conn, $_POST['stud_fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['stud_mname']);
    $lname = mysqli_real_escape_string($conn, $_POST['stud_lname']);
    $yrLvl = mysqli_real_escape_string($conn, $_POST['yr_lvl']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $email = mysqli_real_escape_string($conn, $_POST['email_add']);

    // Perform data validation (add more validation as needed)
    if (empty($studID) || empty($fname) || empty($lname) || empty($yrLvl) || empty($semester) || empty($section) || empty($email)) {
        $message = "Please fill in all fields.";
    } else {
        // Insert data into the database table
        $insertQuery = "INSERT INTO student_info (stud_ID, stud_fname, stud_mname, stud_lname, yr_lvl, semester, section, email_add)
                        VALUES ('$studID', '$fname', '$mname', '$lname', '$yrLvl', '$semester', '$section', '$email')";

        if (mysqli_query($conn, $insertQuery)) {
           
            header('location: /sol/admin/student/student.php');
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Students</title>
</head>
<body>

    <h1>Add Students</h1>
    <form method="post" action="">
        <!-- Add your input fields for student information -->
        <label for="stud_id">Student ID:</label>
        <input type="text" id="stud_id" name="stud_id" required><br>
        
        <label for="stud_fname">First Name:</label>
        <input type="text" id="stud_fname" name="stud_fname" required><br>
        
        <label for="stud_mname">Middle Name:</label>
        <input type="text" id="stud_mname" name="stud_mname"><br>
        
        <label for="stud_lname">Last Name:</label>
        <input type="text" id="stud_lname" name="stud_lname" required><br>
        
        <label for="yr_lvl">Year Level:</label>
        <input type="text" id="yr_lvl" name="yr_lvl" required><br>
        
        <label for="semester">Semester:</label>
        <input type="text" id="semester" name="semester" required><br>
        
        <label for="section">Section:</label>
        <input type="text" id="section" name="section" required><br>
        
        <label for="email_add">Email Address:</label>
        <input type="email" id="email_add" name="email_add" required><br>

        <button type="submit">Add Student</button>
    </form>

    <?php
    if ($message) {
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
