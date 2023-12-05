<?php
session_start();
@include 'config.php';
@include 'dbconfig.php';

// Check if the user is authenticated as Admin or Faculty
if (!isset($_SESSION['emp_ID'])) {
    // Redirect to login if the session variable is not set
    header('location: /sol/index.php');
    exit();
}

// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "solsystem";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected student and subject from the form
    $selectedStudent = $_POST["student"];
    $selectedSubject = $_POST["subject"];

    // Insert the assignment into the rec_info table
    $insertAssignment = "INSERT INTO rec_info (stud_ID, sub_ID) VALUES ('$selectedStudent', '$selectedSubject')";

    if ($conn->query($insertAssignment) === TRUE) {
        // Close the database connection
        $conn->close();

        // Redirect to student.php
        header('location: /sol/admin/student/student.php');
        exit();
    } else {
        echo "Error: " . $insertAssignment . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>