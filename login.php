<?php
require('timezone.php');
// Start a session
session_start();


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "solsystem";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to insert login activity
function insertLoginActivity($empID, $description, $conn) {
    // Generate the login activity date
    $activityDate = date('Y-m-d H:i:s');

    // Prepare and execute the SQL query to insert a new record into the activity_log table
    $sql = "INSERT INTO activity_log (emp_ID, activity_description, activity_date) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $empID, $description, $activityDate);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$error = ''; // Initialize an error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_ID = $_POST['emp_ID']; // Updated to match the form field name
    $pass = $_POST['password']; // Updated to match the form field name

    // Prevent SQL injection by using prepared statements
    $select = "SELECT * FROM user_info WHERE emp_ID = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $select);
    mysqli_stmt_bind_param($stmt, "ss", $emp_ID, $pass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['role'] == 'Admin') {
            $_SESSION['admin_ID'] = $row['emp_ID'];
            insertLoginActivity($_SESSION['admin_ID'], "Admin logged in", $conn);
            header('location: /sol/admin124106/dashboard/dashboard');
            exit();
        } elseif ($row['role'] == 'Faculty') {
            $_SESSION['user_ID'] = $row['emp_ID'];
            insertLoginActivity($_SESSION['user_ID'], "Faculty logged in", $conn);
            header('location: /sol/faculty25671/dashboard/dashboard');
            exit();
        }
    } else {
        $error = 'Incorrect Employee ID or password!';
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);

// Redirect back to index.php with the error message
header('location: index.php?error=' . urlencode($error));
exit();
?>