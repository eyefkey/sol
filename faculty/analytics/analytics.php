<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "solsystem";

$conn = new mysqli($servername, $username,$password,$database);

if($conn->connect_error){
    die("Connection failed: " .$conn->connect_error);
}

$query = $conn->query("
    

    
")



?>
    <script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Student 1', 'Student 2', 'Student 3'],
        datasets: [{
            label: 'Grades',
            data: [85, 92, 78],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>


