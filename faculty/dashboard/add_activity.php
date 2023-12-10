<?php

// Include your configurations and database connection
@include 'conf.php';
@include 'dbconfig.php';

// Check if the user is authenticated as Faculty
if (isset($_SESSION['user_ID'])) {
    $facultyID = $_SESSION['user_ID']; // Get the faculty's ID
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

// Initialize variables to store form data
$recID = $subID = $actName = $actDate = $score = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $recID = $_POST['rec_ID'];
    $subID = $_POST['sub_ID'];
    $actName = $_POST['act_name'];
    $actDate = $_POST['act_date'];
    $score = $_POST['score'];

    // Perform validation if needed

    // Insert data into the activity_info table
    $insertActivity = "INSERT INTO activity_info (rec_ID, sub_ID, act_name, act_date, score) 
                       VALUES ('$recID', '$subID', '$actName', '$actDate', '$score')";

    if (mysqli_query($conn, $insertActivity)) {
        // Activity added successfully, reload the current webpage using JavaScript
        echo '<script>window.location.reload();</script>';
        exit();
    } else {
        echo "Error: " . $insertActivity . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <!-- Include your CSS stylesheets or link to external stylesheets here -->
    <link rel="stylesheet" href="/sol/faculty/css/faculty.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
    <main class="form">
        <section class="form__header">
            <h1>Add Task</h1>
        </section>
        <section class="form__body">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="rec_ID" value="<?php echo htmlspecialchars($_GET['rec_ID']); ?>">
                
                <label for="sub_ID">Subject Code:</label>
                <input type="text" name="sub_ID" required>

                <label for="task_name">Task Name:</label>
                <input type="text" name="task_name" required>

                <label for="task_date">Task Date:</label>
                <input type="date" name="task_date" required>

                <label for="task_description">Task Description:</label>
                <textarea name="task_description" rows="4" required></textarea>

                <button type="submit">Add Task</button>
            </form>
        </section>
    </main>
    <!-- Include your navigation bar or other elements as needed -->
    <nav>
        <ul>
            <li>
                <a href="#" class="logo">
                    <img src="/sol/img/sol.png" alt="">
                    <span class="nav-item"> SOL - CRMS</span>
                </a>
            </li>
            <!-- Include other navigation links as needed -->
        </ul>
    </nav>
    <!-- Include your JavaScript files or scripts as needed -->
</body>
</html>
