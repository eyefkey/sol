<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

// Initialize a variable to hold the success or error message
// $faculty_id = $_GET['emp_ID']; // Assuming emp_ID is passed as a URL parameter

// Get the subject ID from the URL parameter
$sub_ID = $_GET['sub_ID'];

// SQL query to retrieve the assigned students for the subject
$sql = "SELECT rec_info.rec_ID, student_info.stud_ID, student_info.stud_lname, student_info.stud_fname, student_info.stud_mname, student_info.yr_lvl, student_info.section, student_info.email_add
        FROM rec_info
        JOIN student_info ON rec_info.stud_ID = student_info.stud_ID
        WHERE rec_info.sub_ID = '$sub_ID'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Students</title>
    <link rel="stylesheet" href="/crms/assets/css/view_student.css">
</head>
<body>
<div class="container">
    <div class="navigation">
        <!-- Navigation content -->
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
                <a href="dashboard.php">
                    <span class="icon">
                        <ion-icon name="home-outline"></ion-icon>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="staff.php">
                    <span class="icon">
                        <ion-icon name="people-outline"></ion-icon>
                    </span>
                    <span class="title">Administrator/Staff</span>
                </a>
            </li>
            <li>
                <a href="/crms/admin/student/student.php">
                    <span class="icon">
                        <ion-icon name="briefcase-outline"></ion-icon>
                    </span>
                    <span class="title">Students</span>
                </a>
            </li>
            <li>
                <a href="/crms/admin/subject/subject.php">
                    <span class="icon">
                        <ion-icon name="file-tray-stacked-outline"></ion-icon>
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
            <!-- Topbar content -->
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
                <h1>Students List</h1>
                <a href="stud_print.php?sub_ID=<?php echo $sub_ID; ?>" class="btn">Print Students</a>
            </section>
            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Year Level</th>
                            <th>Section</th>
                            <th>Email Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display assigned students
                        if ($result !== false && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $fullname = $row['stud_lname'] . " " . $row['stud_fname'] . " " . $row['stud_mname'];
                                echo "<tr>";
                                echo "<td>" . $row['stud_ID'] . "</td>";
                                echo "<td>" . $fullname . "</td>";
                                echo "<td>" . $row['yr_lvl'] . "</td>";
                                echo "<td>" . $row['section'] . "</td>";
                                echo "<td>" . $row['email_add'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No Assigned Students found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</div>
<script src="/crms/assets/js/main.js"></script>
                    
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
