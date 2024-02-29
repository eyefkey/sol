<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "crms";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error); 
}

$sub_ID = $_GET['sub_ID'];
$rec_ID = $_GET['rec_ID'];

// Fetch subjects
$sqlSubjects = "SELECT sub_ID, sub_name FROM sub_info WHERE sub_ID = '$sub_ID'";
$resultSubjects = $conn->query($sqlSubjects);

// Check if subjects were fetched successfully
if (!$resultSubjects) {
    die("Error fetching subjects: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRMS</title>
    <link rel="stylesheet" href="/crms/assets/css/max.css">
</head>
<body>
<div class="container">
    <div class="navigation">
        <!-- Navigation Bar -->
    </div>
    <div class="main">
        <div class="topbar">
            <!-- Topbar Content -->
        </div>
        <main class="table">
            <section class="table__header">
                <h1>CRMS</h1>
                <button onclick="openGradeModal()">Add Grade</button>
                <button onclick="addColumnModal()">Add Column</button>
            </section>
            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <?php
                            // Fetch distinct act_names from activity_info table for the specified sub_ID
                            $sql = "SELECT DISTINCT act_name FROM activity_info WHERE sub_ID = '$sub_ID'";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<th>" . $row['act_name'] . "</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch student details
                        $sql = "SELECT * FROM student_info";
                        $resultStudents = $conn->query($sql);
                        while ($rowStudent = $resultStudents->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $rowStudent['stud_ID'] . "</td>";
                            echo "<td>" . $rowStudent['stud_lname'] . " " . $rowStudent['stud_fname'] . " " . $rowStudent['stud_mname'] . "</td>";
                            
                            // Fetch scores for each student for each act_name for the specified sub_ID
                            $sqlact = "SELECT act_name, score FROM activity_info WHERE sub_ID = '$sub_ID' AND rec_ID = '$rec_ID' ";
                            $resultScores = $conn->query($sqlact);
                            $scores = [];
                            while ($rowScore = $resultScores->fetch_assoc()) {
                                $scores[$rowScore['act_name']] = $rowScore['score'];
                            }
                            
                            // Display scores for each act_name
                            $result = $conn->query("SELECT DISTINCT act_name FROM activity_info WHERE sub_ID = '$sub_ID'");
                            while ($row = $result->fetch_assoc()) {
                                echo "<td>" . ($scores[$row['act_name']] ?? '') . "</td>";
                            }
                            
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</div>

<!-- Add Grade Modal -->
<div id="gradeModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeGradeModal()">&times;</span>
        <?php include 'grade_manage.php'; ?>
    </div>
</div>

<!-- Add Column Modal -->
<div id="addColumnModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <?php include 'add_column.php'; ?>
    </div>
</div>

<script>
    function openGradeModal() {
        document.getElementById('gradeModal').style.display = "block";
    }

    function closeGradeModal() {
        document.getElementById('gradeModal').style.display = "none";
    }

    function addColumnModal() {
        document.getElementById('addColumnModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('addColumnModal').style.display = "none";
    }
</script>

</body>
</html>
