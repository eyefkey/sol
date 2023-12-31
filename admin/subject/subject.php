<?php
// Include your database configuration file
include 'conf.php';
include 'dbconfig.php';

// Initialize a variable to hold the success or error message
$message = "";

// Check if the form to fetch faculty name is submitted
if (isset($_POST['get_faculty_name'])) {
    $emp_ID = mysqli_real_escape_string($conn, $_POST['emp_ID']);

    // Query to fetch faculty name based on usep_id from the 'users' table
    $facultyQuery = "SELECT emp_ID FROM solsystem.user_info WHERE emp_ID = '$emp_ID'";
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
    <title>Document</title>
    <link rel="stylesheet" href="/sol/admin/css/sub.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
    <main class="table">
        <section class="table__header">
            <h1>Subject Management</h1>
            <div class="export__file">
    <label for="export-file" class="export__file-btn" title="Select Options"></label>
    <input type="checkbox" id="export-file">
    <div class="export__file-options">
        <label>Select: &nbsp; &#10140;</label>
        <label for="export-file" id="toPDF" onclick="assignSub()">Assign Subject<img src="images/pdf.png" alt=""></label>
        <label for="export-file" id="toJSON" onclick="editSub()">Edit Subject<img src="images/json.png" alt=""></label>
        <label for="export-file" id="toCSV" onclick="deleteSub()">Delete Subject<img src="images/csv.png" alt=""></label>
    </div>
</div>

        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Faculty ID</th>
                        <th> Subject Code </th>
                        <th> Subject Name </th>
                        <th> Semester </th>
                        <th> Units </th>
                        <th> School Year </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($resultSubjects)) {
                        echo "<tr>";
                        echo "<td class='center-text'>" . $row['emp_ID'] . "</td>";
                        echo "<td class='center-text'>" . $row['sub_ID'] . "</td>";
                        echo "<td class='center-text'>" . $row['sub_name'] . "</td>";
                        echo "<td class='center-text'>" . $row['semester'] . "</td>";
                        echo "<td class='center-text'>" . $row['units'] . "</td>";
                        echo "<td class='center-text'>" . $row['school_year'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tr>
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
            <li><a href="\sol\admin\dashboard\dashboard">
                <i class="fas fa-home"></i>
                <span class="nav-item">Employee</span>
            </a></li>
            <li><a href="\sol\admin\student\student">
                <i class="fas fa-user"></i>
                <span class="nav-item">Student</span>
            </a></li>
            <li><a href="\sol\admin\subject\subject"><i class="fas fa-tasks"></i>
                <span class="nav-item">Subject</span>
            </a></li>
            <li><a href="\sol\admin\analytics\analysis"><i class="fas fa-chart-bar"></i>
                <span class="nav-item">Analysis</span>
            </a></li>
            <li><a href="\sol\" class="logout"><i class="fas fa-sign-out-alt"></i>
                <span class="nav-item">Log out</span>
            </a></li>
        </ul>
    </nav>
    <script>
    function assignSub() {
        document.getElementById("assignSubject").style.display = "block";
    }
    function closeassign(){
        document.getElementById("assignSubject").style.display = "none";
    }

    function editSub() {
        document.getElementById("editSubject").style.display = "block";
    }
    function closeedit() {
        document.getElementById("editSubject").style.display = "none";
    }

    function deleteSub(){
        document.getElementById("deleteSubject").style.display = "block";
    }
    function closedel(){
        document.getElementById("deleteSubject").style.display = "none";
    }
    </script>


    <div id="assignSubject" class="modal">
        <div class="modal-content">
            <span class= "close" onclick= "closeassign()">&times;</span>
            <?php include 'assign_sub.php'; ?>
        </div>
    </div>

    <div id="editSubject" class="modal">
        <div class="modal-content">
            <span class= "close" onclick= "closeedit()">&times;</span>
            <?php include 'edit_sub.php'; ?>
        </div>
    </div>

    <div id="deleteSubject" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closedel()">&times;</span>
            <?php include 'delete_sub.php'; ?>
        </div>
    </div>


</body>
</html>