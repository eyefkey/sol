<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM student_info";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Page</title>
    <link rel="stylesheet" href="/crms/assets/css/table.css">
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
                    <a href="/crms/admin/staff/dashboard.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="/crms/admin/staff/staff.php">
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

        <!-- ========================= Main ==================== -->
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
            <div id="importModal">
                <div class="modal-content1">
                <span class="close" onclick="closeImportModal();">&times;</span>
                <h2>Import Students</h2>
            <form action="importdata.php" method="post" enctype="multipart/form-data">
                <input type="file" name="file" />
                <input type="submit" class="btn btn-primary green-btn" name="importSubmit" value="IMPORT">        
                </form>
        </div>
    </div>

            <main class="table">
            <section class="table__header">
                <h1>Students List</h1>
                        <a href="#" onclick="openModalstudent()" class="btns">Add Student</a>
                        <a href="#" onclick="openEditstudent()" class="btns">Edit Student</a>
                        <a href="#" onclick="openDeletestudent()" class="btns">Delete Student</a>
                        <a href="#" onclick="openImportModal()" class="btns">Import Students</a>
                    
            </section>
            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Year Level</th>
                        <th>Semester</th>
                        <th>Section</th>
                        <th>Email Address</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <?php
                // Display login activity data
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['stud_ID'] . "</td>";
                        echo "<td>" . $row['stud_lname'] . "  " . $row['stud_fname'] . " " . $row['stud_mname'] . "</td>";
                        echo "<td>" . $row['yr_lvl'] . "</td>";
                        echo "<td>" . $row['semester'] . "</td>";
                        echo "<td>" . $row['section'] . "</td>";
                        echo "<td>" . $row['email_add'] . "</td>";                    
                        echo "</tr>";
                    }
                } else {
                    
                    echo "<tr><td colspan='2'>No Student(s) found</td></tr>";
                }
                ?>
                    </tr>
                    </tbody>
                </table>
            </section>
        </main>
                
</div>
            </div>
        </div>
    </div>
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <?php include 'add_student.php';?>
        </div>
    </div>
    <div id="editStudentModal" class="modal">
        <div class="modal-content">
            <?php include 'edit_student.php';?>
        </div>
    </div>
    <div id="deleteStudentModal" class="modal">
        <div class="modal-content">
            <?php include 'delete_student.php';?>
        </div>
    </div>

    <script src="/newsystem/assets/js/mains.js"></script>
                    
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>