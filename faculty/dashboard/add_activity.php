<?php

// Include your configurations and database connection
@include 'conf.php';
@include 'dbconfig.php';

// Check if the user is authenticated as Faculty
if (isset($_SESSION['user_ID'])) {
    $facultyID = $_SESSION['user_ID']; // Get the faculty's ID
} else {
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

// Initialize variables to store form data
$recID = $subID = $actName = $actDate = $score = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $recID = $_POST['rec_ID'];
    $subID = $_POST['sub_ID'];
    $actName = $_POST['act_name'];
    $actDate = $_POST['act_date'];
    $score = $_POST['score'];

    // Perform validation if needed

    // Insert data into the activity_info table
    $insertActivity = "INSERT INTO activity_info (rec_ID, sub_ID, act_name, act_date, score) 
                       VALUES ('$recID', '$subID', '$actName', '$actDate', '$score')";

    if (mysqli_query($conn, $insertActivity)) {
        // Activity added successfully, reload the current webpage using JavaScript
        echo '<script>window.location.reload();</script>';
        exit();
    } else {
        echo "Error: " . $insertActivity . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
$conn->close();
?>
