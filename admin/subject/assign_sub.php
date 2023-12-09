<?php
// Include your database configuration file
include 'conf.php';
include 'dbconfig.php';

// Initialize a variable to hold the success or error message
$message = "";

// Check if the form to fetch faculty name is submitted
if (isset($_POST['get_faculty_name'])) {
    $emp_ID = mysqli_real_escape_string($conn, $_POST['emp_ID']);

    // Query to fetch faculty name based on usep_id from the 'users' table
    $facultyQuery = "SELECT emp_ID FROM solsystem.user_info WHERE emp_ID = '$emp_ID'";
    $resultFaculty = mysqli_query($conn, $facultyQuery);

    if ($resultFaculty && mysqli_num_rows($resultFaculty) > 0) {
        // Faculty ID found
        $facultyData = mysqli_fetch_assoc($resultFaculty);
        $emp_ID = $facultyData['emp_ID'];

        // Now, check if the sub_ID already exists
        $sub_ID = mysqli_real_escape_string($conn, $_POST['sub_ID']);
        $checkQuery = "SELECT * FROM sub_info WHERE sub_ID = '$sub_ID'";
        $resultCheck = mysqli_query($conn, $checkQuery);

        if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
            // If the sub_ID exists, you might want to update the existing record
            $updateQuery = "UPDATE sub_info SET sub_name = '$sub_name', semester = '$semester', units = '$units', school_year = '$school_year' WHERE sub_ID = '$sub_ID'";
            
            if (mysqli_query($conn, $updateQuery)) {
                $message .= "<br>Subject updated successfully.";
            } else {
                $message .= "<br>Error updating record: " . mysqli_error($conn);
            }
        } else {
            // If the sub_ID doesn't exist, insert a new record
            $insertQuery = "INSERT INTO sub_info (emp_ID, sub_ID, sub_name, semester, units, school_year) 
                            VALUES ('$emp_ID', '$sub_ID', '$sub_name', '$semester', '$units', '$school_year')";

            if (mysqli_query($conn, $insertQuery)) {
                $message .= "<br>Subject added successfully.";
            } else {
                $message .= "<br>Error: " . mysqli_error($conn);
            }
        }

        // Redirect to another page to avoid form resubmission
        header("Location: subject.php");
        exit();
    } else {
        // Faculty not found
        $message = "Faculty with ID $emp_ID not found.";
    }
}

// Fetch subjects from the database
$select = "SELECT * FROM sub_info";
$resultSubjects = mysqli_query($conn, $select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Subject</title>
</head>
<body>
    <h2>Assign Subject</h2>
    <form action="" method="post" id="facultyForm">
        <label for="emp_ID">Faculty ID:</label><br>
        <input type="text" id="emp_ID" name="emp_ID" required><br>

        <label for="sub_ID">Subject Code:</label><br>
        <input type="text" id="sub_ID" name="sub_ID" required><br>

        <label for="sub_name">Subject Name:</label><br>
        <input type="text" id="sub_name" name="sub_name" required><br>

        <label for="semester">Semester:</label><br>
        <input type="text" id="semester" name="semester" required><br>

        <label for="units">Units:</label><br>
        <input type="text" id="units" name="units" required><br>

        <label for="school_year">School Year:</label><br>
        <input type="text" id="school_year" name="school_year" required><br>
        
        <input type="submit" name="get_faculty_name" value="Register">
    </form>
</body>
</html>
