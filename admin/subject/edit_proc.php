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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Retrieve form data
    $sub_ID = $_POST['sub_ID'];
    $emp_ID = $_POST['emp_ID'];
    $sub_name = $_POST['sub_name'];
    $semester = $_POST['semester'];
    $units = $_POST['units'];
    $school_year = $_POST['school_year'];

    // Update the record in the database
    $update_query = "UPDATE sub_info SET 
                    emp_ID='$emp_ID', 
                    sub_name='$sub_name', 
                    semester='$semester', 
                    units='$units', 
                    school_year='$school_year' 
                    WHERE sub_ID='$sub_ID'";

    if ($mysqli->query($update_query) === TRUE) {
        echo "Record updated successfully";

        header('location: /sol/admin/subject/subject.php');
        exit();
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
}


// Close the database connection
$mysqli->close();
?>
