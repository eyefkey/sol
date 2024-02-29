<?php
// Include your database connection code here

$sub_ID = $_GET['sub_ID'];

// Handle form submission to add or update grades
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_ID = $_POST['student_ID'];
    $act_name = $_POST['act_name'];
    $score = $_POST['score'];

    // Add or update grade in your database table
    // You'll need to write appropriate SQL queries here
    // Example:
    // $sql = "INSERT INTO grades (student_ID, act_name, score) VALUES ('$student_ID', '$act_name', '$score')";
    // or
    // $sql = "UPDATE grades SET score='$score' WHERE student_ID='$student_ID' AND act_name='$act_name'";
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="sub_ID" value="<?php echo $sub_ID; ?>">
    <label for="student_ID">Student ID:</label>
    <input type="text" id="student_ID" name="student_ID" required>
    <label for="act_name">Activity Name:</label>
    <input type="text" id="act_name" name="act_name" required>
    <label for="score">Score:</label>
    <input type="text" id="score" name="score" required>
    <input type="submit" value="Submit">
</form>
