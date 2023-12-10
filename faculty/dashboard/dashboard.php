<?php
// Start the session (if not already started)
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="/sol/faculty/css/faculty.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
<main class="table">
        <section class="table__header">
            <h1>Dashboard</h1>
            <div class="export__file">
    <label for="export-file" class="export__file-btn" title="Export File"></label>
    <input type="checkbox" id="export-file">
    <div class="export__file-options">
        <label>Select: &nbsp; &#10140;</label>
        <label for="export-file" id="toPDF" onclick="openModal()">Add Employee<img src="images/pdf.png" alt=""></label>
        <label for="export-file" id="toJSON" onclick="editModal()">Edit Employee<img src="images/json.png" alt=""></label>
        <label for="export-file" id="toCSV" onclick="deleteModal()">Delete Employee<img src="images/csv.png" alt=""></label>
    </div>
        </div>
    </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Subject Code</th>
                        <th> Subject Name </th>
                        <th> Semester </th>
                        <th> Units </th>
                        <th> School Year </th>
                        <th class = "action-column"> Action </th>
                    </tr>
                </thead>
                <tbody>
                <?php
    // Execute your query to retrieve assigned subjects for the faculty
    $select = "SELECT * FROM sub_info WHERE emp_ID = '$facultyID'";
    $resultSubjects = mysqli_query($conn, $select);

    // Check if the query was successful
    if ($resultSubjects !== false && mysqli_num_rows($resultSubjects) > 0) {
        // Output data of each row

        while ($row = mysqli_fetch_assoc($resultSubjects)) {

            echo "<tr><td>" . $row['sub_ID'] . "</td><td>" . $row['sub_name'] . "</td><td>" . $row['semester'] . "</td><td>" . $row['units'] . "</td><td>" . $row['school_year'] . "</td>";

            // Add the "Manage" action link with a dynamic URL
            echo "<td><a class='action-link' href='/sol/faculty/dashboard/student_manage.php?sub_ID=" . $row['sub_ID'] . "'>Manage</a></td></tr>";

        }
        
    } else {
        echo "<tr><td colspan='6'>No subjects assigned to this faculty</td></tr>";
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
            <li><a href="\sol\index.php" class="logout"><i class="fas fa-sign-out-alt"></i>
                <span class="nav-item">Log out</span>
            </a></li>
        </ul>
    </nav>
    <script>
    // Your JavaScript functions here
</script>

</body>
</html>
