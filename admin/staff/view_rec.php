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
$faculty_id = $_GET['emp_ID']; // Assuming emp_ID is passed as a URL parameter

// SQL query to retrieve the assigned subjects for the faculty
$sql = "SELECT * FROM sub_info WHERE emp_ID = '$faculty_id'";
$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Subjects</title>
    <link rel="stylesheet" href="/crms/assets/css/view_record.css">
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
            <h1>Course List</h1>
            <a href="rec_print.php?emp_ID=<?php echo $faculty_id; ?>" class="btn">Print Courses</a>

            </section>
            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Year Level</th>
                            <th>Semester</th>
                            <th>Units</th>
                            <th>School Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display assigned subjects
                        if ($result !== false && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['sub_ID'] . "</td>";
                                echo "<td>" . $row['sub_name'] . "</td>";
                                echo "<td>" . $row['yr_lvl'] . "</td>";
                                echo "<td>" . $row['semester'] . "</td>";
                                echo "<td>" . $row['units'] . "</td>";
                                echo "<td>" . $row['school_year'] . "</td>";
                                echo "<td>";
                                if (isset($row['sub_ID'])){
                                    $sub_ID = $row['sub_ID'];
                                    $sql_rec = "SELECT rec_ID FROM rec_info WHERE sub_ID = '$sub_ID'";
                                    $result_rec = $conn->query($sql_rec);
                                    if ($result_rec->num_rows > 0){
                                        $row_rec = $result_rec->fetch_assoc();
                                        $rec_ID = $row_rec['rec_ID'];
                                        echo "<a class = 'action-link' href='/crms/admin/staff/view_stud.php?sub_ID=$sub_ID&rec_ID=$rec_ID'>Students</a>";
                                    }else {
                                        echo "No assigned students";
                                    }
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No Assigned Courses found</td></tr>";
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
