<?php
// Include timezone.php to set the default timezone
include 'timezone.php';

// Assuming you have a session_start() at the beginning of your script
session_start();

// Assuming you have a database connection established

// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "solsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_ID'])) {
    // Redirect to the login page or handle the case where the user is not logged in
    header("Location: /sol/index");
    exit();
}

// Retrieve the logged-in employee ID from the session
$loggedInEmpID = $_SESSION['user_ID'];

// Fetch login activity data
$sql = "SELECT * FROM activity_log WHERE emp_ID = '$loggedInEmpID' ORDER BY activity_date DESC";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Logs</title>
    <link rel="stylesheet" href="/sol/faculty25671/css/dashboard.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
<main class="table">
    <section class="table__header">
        <h1>Login Logs</h1>
    </section>
    <section class="table__body">
        <table>
            <thead>
                <tr>
                    <th> Activity Description</th>
                    <th> Activity Date </th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display login activity data
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['activity_description'] . "</td>";
                        
                        // Convert the stored UTC time to Asia/Manila timezone
                        $manilaTime = $row['activity_date'];

                        
                        
                        echo "<td>" . $manilaTime . "</td>";
                        echo "</tr>";
                    }
                } else {
                    
                    echo "<tr><td colspan='2'>No login activity found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</main>
<nav>
    <ul>
        <li>
            <a href="#" class="logo">
                <img src="/sol/img/sol.png" alt="">
                <span class="nav-item"> SOL - CRMS</span>
            </a>
        </li>
        <li>
            <a href="\sol\faculty25671\dashboard\dashboard">
                <i class="fas fa-home"></i>
                <span class="nav-item">Home</span>
            </a>
        </li>
        <li>
            <a href="\sol\faculty25671\logs\view.php">
                <i class="fas fa-th-list"></i>
                <span class="nav-item">Login Logs</span>
            </a>
        </li>
        <li>
            <a href="\sol\" class="logout">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-item">Log out</span>
            </a>
        </li>
    </ul>
</nav>
<script>
    // Your JavaScript functions here
</script>
</body>
</html>
