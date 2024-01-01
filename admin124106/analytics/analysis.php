<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "solsystem";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the number of students passed and failed for each sub_ID
$query = $conn->query("SELECT r.sub_ID, 
    COUNT(CASE WHEN g.final_grade >= 75 THEN g.rec_ID END) as passed_count, 
    COUNT(CASE WHEN g.final_grade < 75 THEN g.rec_ID END) as failed_count 
    FROM rec_info r LEFT JOIN grade_info g ON r.rec_ID = g.rec_ID 
    GROUP BY r.sub_ID");

$data = $query->fetch_all(MYSQLI_ASSOC);

$subIDs = array_column($data, 'sub_ID');
$passedCounts = array_column($data, 'passed_count');

// Query to get the number of enrolled students for each sub_ID
$enrollmentQuery = $conn->query("SELECT sub_ID, COUNT(DISTINCT stud_ID) AS enrolled_students_count
    FROM rec_info
    GROUP BY sub_ID");

$enrollmentData = $enrollmentQuery->fetch_all(MYSQLI_ASSOC);
$enrolledStudentsCounts = array_column($enrollmentData, 'enrolled_students_count');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/sol/admin124106/css/analytic.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<nav>
    <ul>
        <li>
            <a href="#" class="logo">
                <img src="/sol/img/sol.png" alt="">
                <span class="nav-item"> SOL - CRMS</span>
            </a>
        </li>
        <li><a href="\sol\admin124106\dashboard\dashboard">
                <i class="fas fa-home"></i>
                <span class="nav-item">Employee</span>
            </a></li>
            <li><a href="\sol\admin124106\student\student">
                <i class="fas fa-user"></i>
                <span class="nav-item">Student</span>
            </a></li>
            <li><a href="\sol\admin124106\subject\subject"><i class="fas fa-tasks"></i>
                <span class="nav-item">Subject</span>
            </a></li>
            <li><a href="\sol\admin124106\analytics\analysis"><i class="fas fa-chart-bar"></i>
                <span class="nav-item">Analysis</span>
            </a></li>
            <li><a href="\sol\" class="logout"><i class="fas fa-sign-out-alt"></i>
                <span class="nav-item">Log out</span>
            </a></li>
    </ul>
</nav>

<div class="room">
    <div class="chart-container1" style="width: 400px; height: 400px;">
        <canvas id="polarChart"></canvas>
    </div>

    <div class="chart-container2" style="width: 400px; height: 200px;">
        <canvas id="barChart"></canvas>
    </div>
</div>

<script>
const polarData = {
    labels: <?php echo json_encode($subIDs); ?>,
    datasets: [{
        label: 'Students Passed',
        data: <?php echo json_encode($passedCounts); ?>,
        backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(75, 192, 192)',
            'rgb(255, 205, 86)',
            'rgb(201, 203, 207)',
            'rgb(54, 162, 235)'
        ],
        borderWidth: 1
    }]
};

const polarConfig = {
    type: 'polarArea',
    data: polarData,
    options: {
        scales: {
            r: {
                suggestedMin: 0
            }
        }
    }
};

const barData = {
    labels: <?php echo json_encode($subIDs); ?>,
    datasets: [{
        label: 'Enrolled Students',
        data: <?php echo json_encode($enrolledStudentsCounts); ?>,
        backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(75, 192, 192)',
            'rgb(255, 205, 86)',
            'rgb(201, 203, 207)',
            'rgb(54, 162, 235)'
        ],
        borderWidth: 1
    }]
};

const barConfig = {
    type: 'bar',
    data: barData,
    options: {
        scales: {
            y: {
                beginAtZero: true,
                stepSize: 1
            }
        }
    }
};

var polarChart = new Chart(
    document.getElementById('polarChart'),
    polarConfig
);

var barChart = new Chart(
    document.getElementById('barChart'),
    barConfig
);
</script>
</body>
</html>
