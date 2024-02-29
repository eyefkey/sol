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
$message = "";

// Check if the form to fetch faculty name is submitted
if (isset($_POST['get_faculty_name'])) {
    $emp_ID = mysqli_real_escape_string($conn, $_POST['emp_ID']);

    // Query to fetch faculty name based on usep_id from the 'users' table
    $facultyQuery = "SELECT emp_ID FROM crms.employee_info WHERE emp_ID = '$emp_ID'";
    $resultFaculty = mysqli_query($conn, $facultyQuery);

if ($resultFaculty && mysqli_num_rows($resultFaculty) > 0) {
    // Faculty ID found
    $facultyData = mysqli_fetch_assoc($resultFaculty);
    $emp_ID = $facultyData['emp_ID'];

    // Now, insert the data into the database
    $sub_ID = mysqli_real_escape_string($conn, $_POST['sub_ID']);
    $sub_name = mysqli_real_escape_string($conn, $_POST['sub_name']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $units = mysqli_real_escape_string($conn, $_POST['units']);
    $school_year = mysqli_real_escape_string($conn, $_POST['school_year']);

    // Perform data validation (add more validation as needed)
    if (empty($emp_ID) || empty($sub_ID) || empty($sub_name) || empty($semester) || empty($units) || empty($school_year)) {
        $message .= "<br>Please fill in all fields.";
    } else {
        // Insert data into the database table, including facultyID
        $insertQuery = "INSERT INTO sub_info (emp_ID, sub_ID, sub_name, semester, units, school_year) 
                        VALUES ('$emp_ID', '$sub_ID', '$sub_name', '$semester', '$units', '$school_year')";

        if (mysqli_query($conn, $insertQuery)) {
            $message .= "<br>Subject added successfully.";
        } else {
            $message .= "<br>Error: " . mysqli_error($conn);
        }
    }
} else {
    // Faculty not found
    $message = "Faculty with ID $emp_ID not found.";
        }
}

// Fetch subjects from the database
$select = "SELECT * FROM sub_info";
$resultSubjects = mysqli_query($conn, $select);
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
            <main class="table">
            <section class="table__header">
                <h1>Courses List</h1>
                        <a href="#" onclick="openModalSubject()" class="btnsus">Add Course</a>
                        <a href="#" onclick="openEditSubject()" class="btnsus">Edit Course</a>
                        <a href="#" onclick="openDeleteSubject()" class="btnsus">Delete Course</a>
                        <a href="#" onclick="openAssignSubject()" class="btnsus">Assign Course</a>
            </section>
            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                        <th>Faculty ID</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Semester</th>
                        <th>Units</th>
                        <th>School Year</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <?php
                // Display login activity data
                if ($resultSubjects->num_rows > 0) {
                    while ($row = $resultSubjects->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['emp_ID'] . "</td>";
                        echo "<td>" . $row['sub_ID'] . "</td>";
                        echo "<td>" . $row['sub_name'] . "</td>";
                        echo "<td>" . $row['semester'] . "</td>";
                        echo "<td>" . $row['units'] . "</td>";
                        echo "<td>" . $row['school_year'] . "</td>";                    
                        echo "</tr>";
                    }
                } else {          
                    echo "<tr><td colspan='8'>No Course(s) found</td></tr>";
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
    <div id="addSubjectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <?php include 'add_course.php';?>
        </div>
    </div>
    <div id="editSubjectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEdit()">&times;</span>
            <?php include 'edit_course.php';?>
        </div>
    </div>
    <div id="deleteSubjectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDelete()">&times;</span>
            <?php include 'delete_course.php';?>
        </div>
    </div>
    <div id="assignSubjectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAssign()">&times;</span>
            <?php include 'assign_student.php';?>
        </div>
    </div>

    <script src="/newsystem/assets/js/mains.js"></script>
                    
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>