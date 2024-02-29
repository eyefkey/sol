<?php
session_start();

if (!isset($_SESSION['emp_username'])) {
    // Redirect to the login page
    header('location: /crms');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crms";

//Connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check Connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch data from the employee table and subject table
$sql = "SELECT * FROM employee_info";
$result = $conn->query($sql);

$select = "SELECT * FROM sub_info";
$resultSubjects = mysqli_query($conn, $select);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/crms/assets/css/dash.css">
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
                        <ion-icon name="file-tray-stacked-outline"></ion-icon>                        </span>
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

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"> <?php
        // SQL query to count the number of students
        $sqlstudents = "SELECT COUNT(*) AS total_students FROM student_info";

        // Execute query
        $resultstudents = $conn->query($sqlstudents);

        if ($resultstudents->num_rows > 0) {
            // Output data of each row
            while($row = $resultstudents->fetch_assoc()) {
                echo '<div class="numbers">' . $row["total_students"] . '</div>';
            }
        } else {
            echo "0 results";
        }
        ?>
        </div>
                        <div class="cardName">Students</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="briefcase-outline"></ion-icon>                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?php
        // SQL query to count the number of administrator
        $sqladmin = "SELECT COUNT(*) AS admin_count FROM employee_info WHERE role = 'Admin' ";

        // Execute query
        $resultadmin = $conn->query($sqladmin);

        if ($resultadmin->num_rows > 0) {
            // Output data of each row
            while($row = $resultadmin->fetch_assoc()) {
                echo '<div class="numbers">' . $row["admin_count"] . '</div>';
            }
        } else {
            echo "0 results";
        }
        ?></div>
                        <div class="cardName">Administrator</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="person-circle-outline"></ion-icon>                    </div>
                </div>
        
                <div class="card">
    <div>
        <div class="numbers"><?php
            // SQL query to count the number of staff members
            $sqlstaff = "SELECT COUNT(*) AS staff_count FROM employee_info WHERE role = 'Staff'";

            // Execute query
            $resultstaff = $conn->query($sqlstaff);

            if ($resultstaff->num_rows > 0) {
                // Output data of each row
                while($row = $resultstaff->fetch_assoc()) {
                    echo '<div class="numbers">' . $row["staff_count"] . '</div>';
                }
            } else {
                echo "0 results";
            }
        ?></div>
        <div class="cardName">Staffs</div>
    </div>
    <div class="iconBx">
    <ion-icon name="id-card-outline"></ion-icon>
    </div>
</div>



                <div class="card">
                    <div>
                        <div class="numbers"><?php
                            // SQL query to count the number of administrator
        $sqlfaculty = "SELECT COUNT(*) AS faculty_count FROM employee_info WHERE role = 'Faculty' ";

        // Execute query
        $resultfaculty = $conn->query($sqlfaculty);

        if ($resultfaculty->num_rows > 0) {
            // Output data of each row
            while($row = $resultfaculty->fetch_assoc()) {
                echo '<div class="numbers">' . $row["faculty_count"] . '</div>';
            }
        } else {
            echo "0 results";
        }
        ?></div>
                        <div class="cardName">Faculty</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="people-circle-outline"></ion-icon>                    </div>
                </div>
            </div>
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Course List</h2>
                        
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td> Course Code </td>
                                <td> Course Name </td>
                                <td> Year </td>
                                <td> Units </td>
                                <td> School Year</td>
                              
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <?php
                                while ($row = mysqli_fetch_assoc($resultSubjects)) {
                                echo "<tr>";
                                echo "<td>". $row['sub_ID'] ."</td>";
                                echo "<td>". $row['sub_name'] ."</td>";
                                echo "<td>" . $row['yr_lvl'] ."</td>";
                                echo "<td>". $row['units']."</td>";
                                echo "<td>". $row['school_year']. "</td>";
                                echo "<tr>";
                                }
                                ?>
                            </tr>

                            
                        </tbody>
                    </table>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Employees</h2>
                    </div>

                    <table>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>        
                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="/crms/assets/imgs/emp.png" alt=""></div>
                            </td>
                            <td>
                                <h4><?php echo $row['emp_lname']; ?> <br> <span><?php echo $row['role']; ?></span></h4>
                            </td>
                            <?php } }else{ ?>
                                <tr><td colspan="8"> No Admin / Staff(s) found...</td></tr>
                                <?php } ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- =========== Scripts =========  -->
    <script src="/newsystem/assets/js/mains.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>