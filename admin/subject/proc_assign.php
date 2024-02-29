<?php

// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "crms";

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
        header('location: /crms/admin/subject/subject.php');
        exit();
    } else {
        echo "Error: " . $insertAssignment . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>