<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link rel="stylesheet" href="/sol/faculty25671/css/student_manages.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <?php    ?>
    <main class="table">
        
        <section class="table__header">
            <h1>Manage Students</h1>
        </section>

        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>

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

                    // Assuming you have a column named 'sub_ID' in the 'rec_info' table
                    $sub_ID = $_GET['sub_ID']; // Assuming you pass the sub_ID as a parameter in the URL
                
                    // Execute your query to retrieve assigned students for the subject from 'rec_info'
                    $selectStudents = "SELECT rec_info.rec_ID, student_info.stud_ID, student_info.stud_lname, student_info.stud_mname, student_info.stud_fname 
                   FROM rec_info 
                   JOIN student_info ON rec_info.stud_ID = student_info.stud_ID 
                   WHERE rec_info.sub_ID = '$sub_ID'";

                    $resultStudents = mysqli_query($conn, $selectStudents);

                    // Check if the query was successful
                    if ($resultStudents !== false && mysqli_num_rows($resultStudents) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($resultStudents)) {
                            $fullName = $row['stud_fname'] . " " . $row['stud_mname'] . " " . $row['stud_lname'];
                            echo "<tr><td>" . $row['stud_ID'] . "</td>";
                            echo "<td>" . $fullName . "</td>";
                            echo "<td>";
                            if (isset($row['rec_ID'])) {
                                echo "<a class='action-link' href='/sol/faculty25671/dashboard/grade_manage.php?rec_ID=" . $row['rec_ID'] ."&sub_ID"."=".$sub_ID. "'>Manage</a>";
                            } else {
                                echo "N/A";
                            }
                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No students assigned to this subject</td></tr>";
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
                    <span class="nav-item">SOL - CRMS</span>
                </a>
            </li>
            <li><a href="\sol\faculty25671\dashboard\dashboard">
                    <i class="fas fa-home"></i>
                    <span class="nav-item">Home</span>
                </a></li>
            <li><a href="\sol\faculty25671\logs\view.php">
                <i class="fas fa-th-list"></i>
                <span class="nav-item">Login Logs</span>
            </a></li>
            <li><a href="\sol\" class="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-item">Log out</span>
                </a></li>
        </ul>
    </nav>

    <script>
        // Your JavaScript functions here
    </script>

</body>

</html>