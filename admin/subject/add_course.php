<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root"; // Replace with your actual username
    $password = ""; // Replace with your actual password
    $dbname = "crms"; // Replace with your actual database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $emp_ID = mysqli_real_escape_string($conn, $_POST['emp_ID']);
    $sub_ID = mysqli_real_escape_string($conn, $_POST['sub_ID']);
    $sub_name = mysqli_real_escape_string($conn, $_POST['sub_name']);
    $yr_lvl = mysqli_real_escape_string($conn, $_POST['yr_lvl']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $units = mysqli_real_escape_string($conn, $_POST['units']);
    $school_year = mysqli_real_escape_string($conn, $_POST['school_year']);

    $facultyQuery = "SELECT emp_ID FROM crms.employee_info WHERE emp_ID = '$emp_ID'";
    $resultFaculty = mysqli_query($conn, $facultyQuery);

    if ($resultFaculty && mysqli_num_rows($resultFaculty) > 0) {
        // Faculty ID found
        $facultyData = mysqli_fetch_assoc($resultFaculty);
        $emp_ID = $facultyData['emp_ID'];

        $checkQuery = "SELECT * FROM sub_info WHERE sub_ID = '$sub_ID'";
        $resultCheck = mysqli_query($conn, $checkQuery);

        if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
            $updateQuery = "UPDATE sub_info SET sub_name = '$sub_name', yr_lvl='$yr_lvl', semester = '$semester', units = '$units', school_year = '$school_year' WHERE sub_ID = '$sub_ID'";
            
            if (mysqli_query($conn, $updateQuery)) {
                $message .= "<br>Subject updated successfully.";
            } else {
                $message .= "<br>Error updating record: " . mysqli_error($conn);
            }
        } else {
            $insertQuery = "INSERT INTO sub_info (sub_ID, emp_ID, sub_name, yr_lvl, semester, units, school_year) 
                            VALUES ('$sub_ID', '$emp_ID', '$sub_name', '$yr_lvl', '$semester', '$units', '$school_year')";

            if (mysqli_query($conn, $insertQuery)) {
                $message .= "<br>Subject added successfully.";
            } else {
                $message .= "<br>Error: " . mysqli_error($conn);
            }
        }

        header("Location: subject.php");
        exit();
    } else {
        $message = "Faculty with ID $emp_ID not found.";
    }

    $conn->close();
}

$select = "SELECT * FROM sub_info";
$resultSubjects = mysqli_query($conn, $select);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
    <style>
        /* CSS styles */
        h2 {
            text-align: center;
        }
        .form-container1 {
            max-width: 300px; /* Adjust max-width as needed */
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .form-container1 input[type="text"],
        .form-container1 select {
            width: calc(50% - 5px); /* Adjust width to fit the container with padding and border */
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container1 input[type="submit"] {
            width: 100%; /* Make the submit button full width */
            background-color: #4caf50;
            color: white;
            padding: 10px 0; /* Adjust vertical padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container1 input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Adjust input width for smaller screens */
        @media (max-width: 500px) {
            .form-container1 input[type="text"],
            .form-container1 select {
                width: 100%; /* Make inputs full width on smaller screens */
            }
        }
    </style>
</head>
<body>
    <h2>Add Course</h2>
    <div class="form-container1">
    <form action="" method="post" id="facultyForm">
        <input type="text" name="emp_ID" placeholder="Faculty ID" required>
        <input type="text" name="sub_ID" placeholder="Subject Code">
        <input type="text" name="sub_name" placeholder="Subject Name">
        <select name="yr_lvl">
            <option value="1st">1st Year</option>
            <option value="2nd">2nd Year</option>
            <option value="3rd">3rd Year</option>
            <option value="4th">4th Year</option>
        </select>
        <select name="semester">
            <option value="1st">1st Semester</option>
            <option value="2nd">2nd Semester</option>
        </select>
        <input type="text" name="units" placeholder="Units">
        <input type="text" name="school_year" placeholder="School Year">
        <input type="submit" name="get_faculty_name" value="Register">
    </form>
    </div>
</body>
</html>
