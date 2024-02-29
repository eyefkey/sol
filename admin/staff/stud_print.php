<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Get the sub_ID from the URL parameter
$sub_ID = $_GET['sub_ID'];

// Query to retrieve students assigned to the specific sub_ID
$sql = "SELECT student_info.stud_ID, student_info.stud_lname, student_info.stud_fname, student_info.stud_mname, student_info.yr_lvl, student_info.section, student_info.email_add
        FROM rec_info
        JOIN student_info ON rec_info.stud_ID = student_info.stud_ID
        WHERE rec_info.sub_ID = '$sub_ID'";
$result = $conn->query($sql);

$sql_employee = "SELECT employee_info.emp_lname, employee_info.emp_fname, employee_info.emp_mname
        FROM sub_info
        JOIN employee_info ON sub_info.emp_ID = employee_info.emp_ID
        WHERE sub_info.sub_ID = '$sub_ID'";
$result_employee = $conn->query($sql_employee);

// Fetch employee's information
if ($result_employee->num_rows > 0) {
    $row_employee = $result_employee->fetch_assoc();
    $fullname = $row_employee['emp_lname'] . " " . $row_employee['emp_fname'] . " " . $row_employee['emp_mname'];
} else {
    $fullname = "Unknown";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container-lg"><br>
    <p class="fs-5">Name: <?php echo $fullname; ?></p>
    <p class="fs-5">Document: List of Students</p>
    <div class="text-end">
        <button onclick="window.print()" class="btn btn-primary">PRINT STUDENTS</button>
        <button onclick="window.history.back()" class="btn btn-primary">RETURN</button>
    </div><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Student ID</th>
                <th scope="col">Last Name</th>
                <th scope="col">First Name</th>
                <th scope="col">Middle Name</th>
                <th scope="col">Year Level</th>
                <th scope="col">Section</th>
                <th scope="col">Email Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['stud_ID'] . "</td>";
                    echo "<td>" . $row['stud_lname'] . "</td>";
                    echo "<td>" . $row['stud_fname'] . "</td>";
                    echo "<td>" . $row['stud_mname'] . "</td>";
                    echo "<td>" . $row['yr_lvl'] . "</td>";
                    echo "<td>" . $row['section'] . "</td>";
                    echo "<td>" . $row['email_add'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No students assigned to this subject.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
