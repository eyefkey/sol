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

    $stud_ID = $_POST['stud_ID'];

    $delete_query = "DELETE FROM student_info WHERE stud_ID='$stud_ID'";

    if ($conn->query($delete_query) === TRUE) {
        header("Location: /crms/admin/student/student.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Remove Student</title>
</head>
<style>
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
<body>
    <div class="container">
    <h2 class="heading">Remove Student</h2>
    <form action="delete_student.php" method="post" class="form-container">
        <input type="text" name="stud_ID" placeholder="Enter Student ID" required><br><br>
        <input type="submit" value="Delete Student">
    </form>
    </div>
</body>
</html>
