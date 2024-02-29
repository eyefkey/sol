<?php
session_start();

if (!isset($_SESSION['emp_username']) || !isset($_SESSION['role'])) {
    // Redirect if the user is not logged in
    header('location: /crms');
    exit();
}

if ($_SESSION['role'] !== 'Faculty') {
    // Redirect if the user is not a faculty member
    header('location: /crms');
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "crms";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve specific subjects assigned to the logged-in faculty
$facultyID = $_SESSION['emp_username'];
$selectSubjects = "SELECT sub_info.* FROM sub_info JOIN employee_info ON sub_info.emp_ID = employee_info.emp_ID WHERE employee_info.emp_username = '$facultyID'";
$resultSubjects = mysqli_query($conn, $selectSubjects);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/crms/assets/css/max.css">
</head>
<body>
<div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                        <img src="/crms/assets/imgs/sol.png" alt="" width="50" height="50">
                        </span>
                        <span class="title">SoL - CRMS</span>
                    </a>
                </li>

                <li>
                    <a href="faculty.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Courses</span>
                    </a>
                </li>

                <li>
                    <a href="/crms">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user">
                    <img src="/crms/assets/imgs/law.png" alt="">
                </div>
            </div>
            <main class="table">
            <section class="table__header">
                <h1>Courses List</h1>
            </section>
            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Semester</th>
                        <th>Year Level</th>
                        <th>Units</th>
                        <th>School Year</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <?php
                        while ($rowSubject = mysqli_fetch_assoc($resultSubjects)) {
                        echo "<tr>";
                        echo "<td>" . $rowSubject['sub_ID'] . "</td>";
                        echo "<td>" . $rowSubject['sub_name'] ."</td>";
                        echo "<td>" . $rowSubject['semester'] . "</td>";
                        echo "<td>" . $rowSubject['yr_lvl'] . "</td>";
                        echo "<td>" . $rowSubject['units'] . "</td>";
                        echo "<td>" . $rowSubject['school_year'] . "</td>";
                        echo "<td><a class='action-link' href='/crms/faculty/student_manage.php?sub_ID=" . $rowSubject['sub_ID'] . "'>Manage</a></td></tr>";

                                                    };
    
                ?>
                    </tr>
                    </tbody>
                </table>
            </section>
        </main>    
<!-- Add other content of faculty.php as needed -->
<script src="/crms/assets/js/main.js"></script>
                    
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
