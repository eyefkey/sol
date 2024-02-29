<?php
// Process form submission to add a new column
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code here

    $newColumnName = $_POST['newColumnName'];

    // Add column to your database table
    $sql = "ALTER TABLE activity_info ADD COLUMN `$newColumnName` int(3)";
    if ($conn->query($sql) === TRUE) {
        echo "New column added successfully";
    } else {
        echo "Error adding new column: " . $conn->error;
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="newColumnName">New Column Name:</label>
    <input type="text" id="newColumnName" name="newColumnName" required>
    <input type="submit" value="Add Column">
</form>
