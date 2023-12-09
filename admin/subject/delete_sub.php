<?php
// Include your database configuration file
include 'conf.php';
include 'dbconfig.php';

// Initialize variables
$message = "";
$subjectCodeToDelete = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subjectCodeToDelete = mysqli_real_escape_string($conn, $_POST['sub_ID']);

    // Query to delete the subject based on the provided subject code
    $deleteQuery = "DELETE FROM sub_info WHERE sub_ID = '$subjectCodeToDelete'";
    $resultDelete = mysqli_query($conn, $deleteQuery);

    if ($resultDelete) {
        $message = "Subject with code $subjectCodeToDelete deleted successfully.";

        // Redirect back to subject.php after successful deletion
        header("Location: subject.php");
        exit(); // Make sure to exit after the header to prevent further execution
    } else {
        $message = "Error deleting subject: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Subject</title>
</head>
<body>
    <h1>Delete Subject</h1>
    <form method="post" action="">
        <label for="sub_ID">Enter Subject Code to Delete:</label>
        <input type="text" id="sub_ID" name="sub_ID" value="<?php echo $subjectCodeToDelete; ?>" required>
        <button type="submit">Delete Subject</button>
    </form>

    <?php
    if ($message) {
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
