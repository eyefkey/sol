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

// Retrieve grades from the activity_info table
$selectGrades = "SELECT act_name, act_date, score FROM activity_info WHERE rec_ID = '$recID'";

$resultGrades = mysqli_query($conn, $selectGrades);

// Check if the query was successful
if ($resultGrades !== false && mysqli_num_rows($resultGrades) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Grades</title>
        <!-- Add your stylesheets and scripts here -->
    </head>
    <body>
        <main class="table">
            <section class="table__header">
                <h1>View Grades</h1>
            </section>
            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th>Activity Name</th>
                            <th>Activity Date</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($resultGrades)) {
                            echo "<tr><td>" . $row['act_name'] . "</td>";
                            echo "<td>" . $row['act_date'] . "</td>";
                            echo "<td>" . $row['score'] . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </body>
    </html>
    <?php
} else {
    echo "No grades found.";
}

// Close the database connection
$conn->close();
?>
