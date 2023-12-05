<?php
// Include your database configuration file
include 'config.php';
include 'dbconfig.php';

// Initialize variables
$message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student'])) {
    // Collect form data
    $stud_id = mysqli_real_escape_string($conn, $_POST['stud_id']);

    // Perform data validation (add more validation as needed)
    if (empty($stud_id)) {
        $message = "Please select a Student ID to delete.";
    } else {
        // Delete student from the database table
        $deleteQuery = "DELETE FROM student_info WHERE stud_id = '$stud_id'";

        if (mysqli_query($conn, $deleteQuery)) {
            $message = "Student deleted successfully.";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

// Fetch all student IDs for the dropdown menu
$selectQueryAllIDs = "SELECT stud_id FROM student_info";
$resultAllIDs = mysqli_query($conn, $selectQueryAllIDs);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
</head>
<body>
    <h1>Delete Student</h1>
    <form method="post" action="">
        <!-- Display dropdown menu with all student IDs -->
        <label for="stud_id">Select Student ID to Delete:</label>
        <select id="stud_id" name="stud_id">
            <?php
            while ($rowID = mysqli_fetch_assoc($resultAllIDs)) {
                echo "<option value='" . $rowID['stud_id'] . "'>" . $rowID['stud_id'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="delete_student">Delete Student</button>
    </form>

    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <p><a href="students.php">Back to Students</a></p>
</body>
</html>
