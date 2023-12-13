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
    FROM rec_info r JOIN grade_info g ON r.rec_ID = g.rec_ID 
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
    <link rel="stylesheet" href="/sol/faculty/css/analytic.css"/>
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
        <li><a href="\sol\faculty\dashboard\dashboard.php">
            <i class="fas fa-home"></i>
            <span class="nav-item">Dashboard</span>
        </a></li>
        <li><a href="\sol\faculty\analytic\analytic.php">
            <i class="fas fa-chart-bar"></i>
            <span class="nav-item">Analytics</span>
        </a></li>
        <li><a href="\sol\index.php" class="logout"><i class="fas fa-sign-out-alt"></i>
            <span class="nav-item">Log out</span>
        </a></li>
    </ul>
</nav>

<div class="room">
<div class="chart-container1" style="width: 400px; height: 400px;">
    <canvas id="polarChart"></canvas>
</div>

<div class="chart-container2" style="width: 400px; height: 200px;">
    <canvas id="lineChart"></canvas>
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

const lineData = {
    labels: <?php echo json_encode($subIDs); ?>,
    datasets: [{
        label: 'Enrolled Students',
        data: <?php echo json_encode($enrolledStudentsCounts); ?>,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
    }]
};

const lineConfig = {
    type: 'line',
    data: lineData,
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

var lineChart = new Chart(
    document.getElementById('lineChart'),
    lineConfig
);
</script>
</body>
</html>
