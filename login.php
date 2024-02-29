<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "crms";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = ''; // Initialize an error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_username = $_POST['emp_username']; // Updated to match the form field name
    $pass = $_POST['password']; // Updated to match the form field name

    // Prevent SQL injection by using prepared statements
    $select = "SELECT * FROM employee_info WHERE emp_username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $select);
    mysqli_stmt_bind_param($stmt, "ss", $emp_username, $pass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        // Set session variable indicating successful login
        $_SESSION['emp_username'] = $emp_username;
        $_SESSION['role'] = $row['role'];
        
        if ($row['role'] == 'Administrator' || $row['role'] == 'Staff') {
            // Redirecting to dashboard for Administrator or Staff
            header('location: /crms/admin/staff/dashboard.php');
            exit();
        } elseif ($row['role'] == 'Faculty') {
            // Redirecting to staff dashboard for Faculty
            header('location: /crms/faculty/faculty.php');
            exit();
        }
    } else {
        $error = 'Incorrect username or password!';
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
