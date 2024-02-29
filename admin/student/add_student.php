<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $servername = "localhost";
    $username = "root"; // Replace with your actual username
    $password = ""; // Replace with your actual password
    $dbname = "crms"; // Replace with your actual database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stud_ID = mysqli_real_escape_string($conn, $_POST['stud_ID']);
    $stud_fname = mysqli_real_escape_string($conn, $_POST['stud_fname']);
    $stud_mname = mysqli_real_escape_string($conn, $_POST['stud_mname']);
    $stud_lname = mysqli_real_escape_string($conn, $_POST['stud_lname']);
    $yr_lvl = mysqli_real_escape_string($conn, $_POST['yr_lvl']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $email_add = mysqli_real_escape_string($conn, $_POST['email_add']);

    $error = [];

    if (empty($stud_ID)) {
        $error[] = "Student ID is required.";
    }
    if (empty($stud_fname)) {
        $error[] = "First Name is required.";
    }
    if (empty($stud_mname)) {
        $error[] = "Middle Initial is required.";
    }
    if (empty($stud_lname)) {
        $error[] = "Last name is required.";
    }
    if (empty($yr_lvl)) {
        $error[] = "Year Level is required.";
    }
    if (empty($semester)) {
        $error[] = "Semester is required.";
    }
    if (empty($section)) {
        $error[] = "Section is required.";
    }
    if (empty($email_add)) {
        $error[] = "Email Address is required.";
    }

    if (count($error) > 0) {
        foreach ($error as $err) {
            echo "<p>$err</p>";
        }
    } else {
        $insert_query = "INSERT INTO student_info(stud_ID, stud_fname, stud_mname, stud_lname, yr_lvl, semester, section, email_add) VALUES ('$stud_ID', '$stud_fname', '$stud_mname', '$stud_lname', '$yr_lvl', '$semester', '$section', '$email_add')";

        if ($conn->query($insert_query) === TRUE) {
            header("Location: /crms/admin/student/student.php");
            exit();
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        /* CSS styles */
        h2 {
            text-align: center;
        }
        .form-container {
            max-width: 300px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container select {
            width: calc(50% - 5px); /* Adjust width to fit two inputs in a row */
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            width: 100%; /* Make the submit button full width */
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Adjust input width for smaller screens */
        @media (max-width: 500px) {
            .form-container input[type="text"],
            .form-container input[type="password"],
            .form-container select {
                width: 100%; /* Make inputs full width on smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="heading">Add Student</h2>
        <form action="add_student.php" method="post" class="form-container">
            <input type="text" name="stud_ID" placeholder="Student ID" maxlength="10" required><br><br>
            <input type="text" name="stud_fname" placeholder="First Name" required><br><br>
            <input type="text" name="stud_mname" placeholder="Middle Initial" required><br><br>
            <input type="text" name="stud_lname" placeholder="Last Name" required><br><br>
            <select name="yr_lvl">
                <option value="1st">1st Year</option>
                <option value="2nd">2nd Year</option>
                <option value="3rd">3rd Year</option>
                <option value="4th">4th Year</option>
            </select><br><br>
            <select name="semester">
                <option value="1st">1st Semester</option>
                <option value="2nd">2nd Semester</option>
            </select><br><br>
            <input type="text" name="section" placeholder="Section" required><br><br>
            <input type="text" name="email_add" placeholder="Email Address" required><br><br>
            <input type="submit" name="submit" value="Add Student">
        </form>
    </div>
</body>
</html>
