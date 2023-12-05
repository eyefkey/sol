<?php
// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is authenticated as Admin or Faculty
if (isset($_SESSION['emp_ID'])) {
    // User is authenticated
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
    <title>Assign Subjects to Students</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
    <main class="assign-subjects">
        <section class="assign-subjects__header">
            <h1>Assign Subjects to Students</h1>
        </section>
        
        <section class="assign-subjects__body">
            <form action="proc_assignt.php" method="post">
                
                <label for="student">Select Student:</label>
                <select name="student" id="student">
                    <?php
                        while ($rowStudent = mysqli_fetch_assoc($resultStudents)) {
                            echo "<option value='{$rowStudent['stud_ID']}'>{$rowStudent['stud_ID']}</option>";
                        }
                    ?>
                </select>

                <label for="subject">Select Subject:</label>
                <select name="subject" id="subject">
                    <?php
                        while ($rowSubject = mysqli_fetch_assoc($resultSubjects)) {
                            echo "<option value='{$rowSubject['sub_ID']}'>{$rowSubject['sub_ID']}</option>";
                        }
                    ?>
                </select>

                <input type="submit" value="Assign">
            </form>
        </section>
    </main>
</body>
</html>