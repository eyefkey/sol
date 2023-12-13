<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "solsystem";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->query("SELECT r.sub_ID, COUNT(CASE WHEN g.final_grade >= 75 THEN g.rec_ID END) as passed_count, COUNT(CASE WHEN g.final_grade < 75 THEN g.rec_ID END) as failed_count FROM rec_info r JOIN grade_info g ON r.rec_ID = g.rec_ID GROUP BY r.sub_ID");
$data = $query->fetch_all(MYSQLI_ASSOC);

$subIDs = array_column($data, 'sub_ID');
$passedCounts = array_column($data, 'passed_count');
$failedCounts = array_column($data, 'failed_count');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/sol/faculty/css/analytics.css"/>
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

</body>
<div class="chart-container" style="width: 500px; height: 300px;">
  <canvas id="myChart"></canvas>
</div>
<script>
const data = {
  labels: <?php echo json_encode($subIDs); ?>,
  datasets: [{
    label: 'Students Passed',
    data: <?php echo json_encode($passedCounts); ?>,
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    borderColor: 'rgb(75, 192, 192)',
    borderWidth: 1
  },
  {
    label: 'Students Failed',
    data: <?php echo json_encode($failedCounts); ?>,
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
    borderColor: 'rgb(255, 99, 132)',
    borderWidth: 1
  }]
};

const config = {
  type: 'bar',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 1
        }
      }
    }
  }
};

var myChart = new Chart(
  document.getElementById('myChart'),
  config
);
</script>
</html>
