<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

// Retrieve emp_ID from URL parameter
$faculty_id = $_GET['emp_ID'];

// SQL query to retrieve assigned courses for the faculty
$sql = "SELECT * FROM sub_info WHERE emp_ID = '$faculty_id'";
$result = mysqli_query($conn, $sql);

// Fetch faculty information
$sql_employee = "SELECT emp_lname, emp_fname, emp_mname FROM employee_info WHERE emp_ID = '$faculty_id'";
$result_employee = mysqli_query($conn, $sql_employee);
$row_employee = mysqli_fetch_assoc($result_employee);
$fullname = $row_employee['emp_lname'] . " " . $row_employee['emp_fname'] . " " . $row_employee['emp_mname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
<div class="container-lg"><br>
    <p class="fs-5">Name: <?php echo $fullname; ?></p> 
    <p class="fs-5">Document: SoL-CRMS Courses Individual</p>
    <div class="text-end">
        <button onclick="window.print()" class="btn btn-primary">PRINT COURSES</button>
        <button onclick="window.history.back()" class="btn btn-primary">RETURN</button>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Course Code</th>
                <th scope="col">Course Name</th>
                <th scope="col">Year Level</th>
                <th scope="col">Semester</th>
                <th scope="col">Units</th>
                <th scope="col">School Year</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display assigned courses
            if ($result !== false && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['sub_ID'] . "</td>";
                    echo "<td>" . $row['sub_name'] . "</td>";
                    echo "<td>" . $row['yr_lvl'] . "</td>";
                    echo "<td>" . $row['semester'] . "</td>";
                    echo "<td>" . $row['units'] . "</td>";
                    echo "<td>" . $row['school_year'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No Assigned Courses found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
