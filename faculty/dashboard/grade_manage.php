<?php
session_start();
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

// Get the rec_ID from the URL parameter
if (isset($_GET['rec_ID'])) {
    $recID = $_GET['rec_ID'];

    // Retrieve grades for the given rec_ID
    $selectGrades = "SELECT * FROM grade_info WHERE rec_ID = '$recID'";
    $resultGrades = mysqli_query($conn, $selectGrades);

    // Check if the query was successful
    if ($resultGrades !== false && mysqli_num_rows($resultGrades) > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Grade Management</title>
            <link rel="stylesheet" href="/sol/faculty/css/grade.css"/>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
        </head>
        <body>

            <main class="table">
                <section class="table__header">
                    <h1>Grade Management</h1>            
                    <div class="button1"><a href="/sol/faculty/dashboard/add_fgrade.php" style="--clr:#FF1818"><span>Add Final Grade</span><i></i></a></div>
                    <div class="button2"><a href="/sol/faculty/dashboard/add_activity.php" style="--clr:#1e9bff"><span>Add Activity</span><i></i></a></div>
                    <div class="button3"><a href="/sol/faculty/dashboard/view_score.php" style="--clr:#39FF14"><span>View Score</span><i></i></a></div>

                </section>
                <section class="table__body">
                    <table>
                        <thead>
                            <tr>
                                <th>Final Grade</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Output data of each row
                            while ($row = mysqli_fetch_assoc($resultGrades)) {
                                echo "<td>" . $row['final_grade'] . "</td>";
                                echo "<td>" . $row['remarks'] . "</td></tr>";
                            }
                            ?>
                            <?php
                                } else {
                                    echo "<div class='no-grades-message'>No grades found for the specified record.</div>";                                
                                }
                            } else {
                                echo "Invalid request. Please provide a rec_ID.";
                            }

                            // Close the database connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </section>
            </main>
            <nav>
    <ul>
        <li>
            <a href="#" class="logo">
                <img src="/sol/img/sol.png" alt="">
                <span class="nav-item"> SOL - CRMS</span>
            </a>
        </li>
        <li><a href="\sol\faculty\dashboard\dashboard.php">
            <i class="fas fa-home"></i>
            <span class="nav-item">Dashboard</span>
        </a></li>
        <li><a href="\sol\faculty\analytic\analytic.php">
            <i class="fas fa-user"></i>
            <span class="nav-item">Analytics</span>
        </a></li>
        <li><a href="\sol\index.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="nav-item">Log out</span>
        </a></li>
    </ul>
</nav>
        </body>
        </html>
        