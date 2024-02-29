<?php


// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "crms";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch students' IDs from the database
$selectStudents = "SELECT stud_ID FROM student_info"; 
$resultStudents = $conn->query($selectStudents);

// Fetch subjects from the database
$selectSubjects = "SELECT sub_ID FROM sub_info";
$resultSubjects = $conn->query($selectSubjects);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Courses to Students</title>
    <style>
        /* CSS styles */
        h2 {
            text-align: center;
        }
        .form-container13 {
            max-width: 300px; /* Adjust max-width as needed */
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        
        .form-container13 input[type="text"],
        .form-container13 select {
            width: calc(50% - 5px); /* Adjust width to fit the container with padding and border */
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container13 select{
            width:115px;
        }
        .form-container13 input[type="submit"] {
            width: 100%; /* Make the submit button full width */
            background-color: #4caf50;
            color: white;
            padding: 10px 0; /* Adjust vertical padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container13 input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Adjust input width for smaller screens */
        @media (max-width: 500px) {
            .form-container13 input[type="text"],
            .form-container13 select {
                width: 100%; /* Make inputs full width on smaller screens */
            }
        }
    </style>
</head>
<body>
    <main class="assign-subjects">
        <section class="assign-subjects__header">
            <h1>Assign Courses to Students</h1>
        </section>
        
        <section class="assign-subjects__body">
            <div class="form-container13">
            <form action="proc_assign.php" method="post">
                
                <select name="student" id="student" aria-placeholder="Student ID">
                    <?php
                        while ($rowStudent = mysqli_fetch_assoc($resultStudents)) {
                            echo "<option value='{$rowStudent['stud_ID']}'>{$rowStudent['stud_ID']}</option>";
                        }
                    ?>
                </select>
                    
                <select name="subject" id="subject" placeholder="Subject">
                    <?php
                        while ($rowSubject = mysqli_fetch_assoc($resultSubjects)) {
                            echo "<option value='{$rowSubject['sub_ID']}'>{$rowSubject['sub_ID']}</option>";
                        }
                    ?>
                </select>

                <input type="submit" value="Assign">
            </form>
            </div>
        </section>
    </main>
</body>
</html>