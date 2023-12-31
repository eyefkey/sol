<?php

// Include your configurations and database connection
@include 'conf.php';
@include 'dbconfig.php';

// // Check if the user is authenticated as Faculty
// if (isset($_SESSION['user_ID'])) {
//     $facultyID = $_SESSION['user_ID']; // Get the faculty's ID
// } else {
//     // Redirect to login if the session variable is not set
//     header('location: /sol/index.php');
//     exit();
// }

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

if (isset($_GET['rec_ID'])){

    $recID = $_GET['rec_ID'];
    $sub_ID = $_GET['sub_ID'];

    $selectGrades = "SELECT act_name, act_date, score FROM activity_info WHERE rec_ID = '$recID'";
    $resultGrades = mysqli_query($conn, $selectGrades);
}
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Grades</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="/sol/faculty/css/grade.css" />
        <!-- Add your stylesheets and scripts here -->
    </head>
    <body>
        <main class="table">
            <section class="table__header">
                <h1>View Scores</h1>
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
                    if ($resultGrades !== false && mysqli_num_rows($resultGrades) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($resultGrades)) {
                            echo "<tr><td>" . $row['act_name'] . "</td>";
                            echo "<td>" . $row['act_date'] . "</td>";
                            echo "<td>" . $row['score'] . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No grades found.</td></tr>";
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                    </tbody>
                </table>
            </section>
        </main>
    
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
            <li><a href="\sol\index.php" class="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-item">Log out</span>
                </a></li>
        </ul>
    </nav>
</body>
</html>