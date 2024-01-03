<?php
// Include your configurations and database connection
@include 'conf.php';
@include 'dbconfig.php';


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
$recID = $finalGrade = $remarks = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $sub_ID = $_POST['sub_ID'];
    $recID = $_POST['rec_ID'];
    $finalGrade = $_POST['final_grade'];
    $remarks = $_POST['remarks'];

    // Perform validation if needed

    // Insert data into the grade_info table
    $insertGrade = "INSERT INTO grade_info (rec_ID, final_grade, remarks) VALUES ('$recID', '$finalGrade', '$remarks')";

    
    if (mysqli_query($conn, $insertGrade)) {
        // Grade added successfully, redirect to student_manage.php

        header('location: student_manage.php?sub_ID=' . $sub_ID);
        exit();

    } else {
        echo "Error: " . $insertGrade . "<br>" . mysqli_error($conn);
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
    <title>Add Final Grade</title>
    <link rel="stylesheet" href="/sol/faculty25671/css/add_fgrade.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <?php echo $recID; ?>
    <main class="form">
        <section class="form__header">
            <h1>Add Final Grade</h1>
        </section>
        <section class="form__body">
        <div class="grade-form-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="rec_ID" value="<?php echo htmlspecialchars($_GET['rec_ID']); ?>">
                <input type="hidden" name="sub_ID" value="<?php echo htmlspecialchars($_GET['sub_ID']); ?>">

                <label for="final_grade">Final Grade:</label>
                <input type="text" name="final_grade" required>

                <label for="remarks">Remarks:</label>
                <input type="text" name="remarks" required>

                <button type="submit">Add Grade</button>
            </form>
        </div>
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
            <li><a href="\sol\faculty25671\dashboard\dashboard">
                    <i class="fas fa-home"></i>
                    <span class="nav-item">Home</span>
                </a></li>
                <li><a href="\sol\faculty25671\logs\view.php">
                <i class="fas fa-th-list"></i>
                <span class="nav-item">Login Logs</span>
            </a></li>
            <li><a href="\sol\index.php" class="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-item">Log out</span>
                </a></li>
        </ul>
    </nav>
</body>

</html>