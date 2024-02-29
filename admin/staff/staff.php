<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM employee_info";
$result = $conn->query($sql);

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
                        <ion-icon name="briefcase-outline"></ion-icon>                        </span>
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
                <h1>Administrator/Staff</h1>
                        <a href="#" onclick="openModal()" class="btn">Add Staff</a>
                        <a href="#" onclick="openEdit()" class="btn">Edit Staff</a>
                        <a href="#" onclick="openDelete()" class="btn">Delete Staff</a>
            </section>
            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <?php
                // Display login activity data
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['emp_ID'] . "</td>";
                        echo "<td>" . $row['emp_lname'] . " " . $row['emp_fname'] . " " . $row['emp_mname'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>" . $row['role'] . "</td>";
                        echo "<td>";
                        if (isset($row['emp_ID'])) {
                            // Get sub_ID based on emp_ID
                            $emp_ID = $row['emp_ID'];
                            $sql_sub = "SELECT sub_ID FROM sub_info WHERE emp_ID = '$emp_ID'";
                            $result_sub = $conn->query($sql_sub);
                            if ($result_sub->num_rows > 0) {
                                $row_sub = $result_sub->fetch_assoc();
                                $sub_ID = $row_sub['sub_ID'];
                                echo "<a class='action-link' href='/crms/admin/staff/view_rec.php?emp_ID=$emp_ID&sub_ID=$sub_ID'>Records</a>";
                            } else {
                                echo "No assigned subjects";
                            }
                        }                  
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
    <div id="addEmployeeModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <?php include 'add_staff.php';?>
        </div>
    </div>
    <div id="editEmployeeModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEdit()">&times;</span>
            <?php include 'edit_staff.php';?>
        </div>
    </div>
    <div id="deleteEmployeeModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDelete()">&times;</span>
            <?php include 'delete_staff.php';?>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="/crms/assets/js/main.js"></script>
                    
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>