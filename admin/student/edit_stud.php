<?php
// Include your database configuration file
include 'config.php';
include 'dbconfig.php';

// Initialize variables
$message = "";
$stud_id = "";
$stud_fname = "";
$stud_mname = "";
$stud_lname = "";
$yr_lvl = "";
$semester = "";
$section = "";
$email_add = "";

// Fetch all available stud_id values
$studIdQuery = "SELECT stud_id FROM student_info";
$studIdResult = mysqli_query($conn, $studIdQuery);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitFirstForm'])) {
        // Collect form data from the first form
        $stud_id = mysqli_real_escape_string($conn, $_POST['stud_id']);

        // Fetch the selected student data
        $selectQuery = "SELECT * FROM student_info WHERE stud_id = '$stud_id'";
        $result = mysqli_query($conn, $selectQuery);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $stud_fname = $row['stud_fname'];
            $stud_mname = $row['stud_mname'];
            $stud_lname = $row['stud_lname'];
            $yr_lvl = $row['yr_lvl'];
            $semester = $row['semester'];
            $section = $row['section'];
            $email_add = $row['email_add'];
        } else {
            $message = "Student not found.";
        }
    } elseif (isset($_POST['submitSecondForm'])) {
        // Collect form data from the second form
        $stud_id = mysqli_real_escape_string($conn, $_POST['stud_id']);
        $stud_fname = mysqli_real_escape_string($conn, $_POST['stud_fname']);
        $stud_mname = mysqli_real_escape_string($conn, $_POST['stud_mname']);
        $stud_lname = mysqli_real_escape_string($conn, $_POST['stud_lname']);
        $yr_lvl = mysqli_real_escape_string($conn, $_POST['yr_lvl']);
        $semester = mysqli_real_escape_string($conn, $_POST['semester']);
        $section = mysqli_real_escape_string($conn, $_POST['section']);
        $email_add = mysqli_real_escape_string($conn, $_POST['email_add']);

        // Perform data validation (add more validation as needed)
        if (empty($stud_id) || empty($stud_fname) || empty($stud_lname) || empty($yr_lvl) || empty($semester) || empty($section) || empty($email_add)) {
            $message = "Please fill in all fields.";
        } else {
            // Update data in the database table based on stud_id
            $updateQuery = "UPDATE student_info 
                            SET stud_fname = '$stud_fname', stud_mname = '$stud_mname', stud_lname = '$stud_lname',
                                yr_lvl = '$yr_lvl', semester = '$semester', section = '$section', email_add = '$email_add'
                            WHERE stud_id = '$stud_id'";

            if (mysqli_query($conn, $updateQuery)) {
                $message = "Student updated successfully.";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Edit Student</h1>
    <form method="post" action="">
        <!-- Add a dropdown menu for selecting stud_id -->
        <label for="stud_id">Select Student ID:</label>
        <select id="stud_id" name="stud_id" required>
            <?php
            // Populate the dropdown menu with stud_id values
            while ($row = mysqli_fetch_assoc($studIdResult)) {
                echo "<option value='{$row['stud_id']}'>{$row['stud_id']}</option>";
            }
            ?>
        </select>

        <button type="submit" name="submitFirstForm">Fetch Student Data</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitFirstForm']) && $message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitFirstForm']) && !$message) : ?>
        <form method="post" action="" id="editForm" class="<?php echo $message ? 'hidden' : ''; ?>">
            <!-- Add your input fields for student information -->
            <label for="stud_id">Student ID:</label>
            <input type="text" id="stud_id" name="stud_id" value="<?php echo $stud_id; ?>" readonly>

            <label for="stud_fname">First Name:</label>
            <input type="text" id="stud_fname" name="stud_fname" value="<?php echo $stud_fname; ?>" required>

            <label for="stud_mname">Middle Name:</label>
            <input type="text" id="stud_mname" name="stud_mname" value="<?php echo $stud_mname; ?>">

            <label for="stud_lname">Last Name:</label>
            <input type="text" id="stud_lname" name="stud_lname" value="<?php echo $stud_lname; ?>" required>

            <label for="yr_lvl">Year Level:</label>
            <input type="text" id="yr_lvl" name="yr_lvl" value="<?php echo $yr_lvl; ?>" required>

            <label for="semester">Semester:</label>
            <input type="text" id="semester" name="semester" value="<?php echo $semester; ?>" required>

            <label for="section">Section:</label>
            <input type="text" id="section" name="section" value="<?php echo $section; ?>" required>

            <label for="email_add">Email Address:</label>
            <input type="email" id="email_add" name="email_add" value="<?php echo $email_add; ?>" required>

            <button type="submit" name="submitSecondForm">Update Student</button>
        </form>
    <?php endif; ?>

    <p><a href="students.php">Back to Students</a></p>

    <script>
        // JavaScript to show the second form after selecting a student ID
        document.getElementById('editForm').classList.remove('hidden');
    </script>
</body>
</html>
