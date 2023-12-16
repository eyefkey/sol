<?php
session_start();

// Establish a connection to the database
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your username
$password = ""; // Replace with your password
$dbname = "solsystem"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the personnel table
$sql = "SELECT * FROM student_info";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/sol/admin/css/student.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
    <main class="table">
        <section class="table__header">
            <h1>Students Management</h1>
            <div class="reload-btn">
                <button onclick="reloadPage()"><i class="fas fa-sync"></i></button>
            </div>
            <div class="export__file">
    <label for="export-file" class="export__file-btn" title="Select Options"></label>
    <input type="checkbox" id="export-file">
    <div class="export__file-options">
        <label>Select: &nbsp; &#10140;</label>
        <label for="export-file" id="toPDF" onclick="openImportModal()">Import Students<img src="" alt=""></label>
        <label for="export-file" id="toCSV" onclick="assignSubjectsModal()">Assign Subject<img src="" alt=""></label>
        <label for="export-file" id="toPDF" onclick="addStudentsModal()">Add Student<img src="" alt=""></label>
        <label for="export-file" id="toJSON" onclick="editStudentsModal()">Edit Student<img src="" alt=""></label>
        <label for="export-file" id="toCSV" onclick="deleteStudentsModal()">Delete Student<img src="" alt=""></label>
    </div>
</div>
        </section>
        <div id="importModal">
                <div class="modal-content1">
                <span class="close" onclick="closeImportModal();">&times;</span>
                <h2>Import Students</h2>
            <form action="importdata.php" method="post" enctype="multipart/form-data">
                <input type="file" name="file" />
                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
            </form>
        </div>
    </div>
  </div>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                    <th>STUDENT ID </th>
                    <th>FULL NAME </th>
                    <th>YEAR LEVEL </th>
                    <th>SEMESTER </th>
                    <th>SECTION </th>
                    <th>EMAIL </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Get member rows
                    $result = $conn->query("SELECT * FROM student_info");
                    if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                ?>
            <tr>
                <td><?php echo $row['stud_ID']; ?></td>
                <td><?php echo $row['stud_fname']," ",$row['stud_mname']," ",$row['stud_lname']; ?></td>
                <td><?php echo $row['yr_lvl']; ?></td>
                <td><?php echo $row['semester']; ?></td>
                <td><?php echo $row['section']; ?></td>
                <td><?php echo $row['email_add']; ?></td>

                <?php } }else{ ?>
                    <tr><td colspan="8">No student(s) found...</td></tr>
                <?php } ?>
            </tr>
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
            <li><a href="\sol\admin\dashboard\dashboard">
                <i class="fas fa-home"></i>
                <span class="nav-item">Dashboard</span>
            </a></li>
            <li><a href="\sol\admin\student\student">
                <i class="fas fa-user"></i>
                <span class="nav-item">Student  </span>
            </a></li>
            <li><a href="\sol\admin\subject\subject"><i class="fas fa-tasks"></i>
                <span class="nav-item">Subject</span>
            </a></li>
            <li><a href="\sol\" class="logout"><i class="fas fa-sign-out-alt"></i>
                <span class="nav-item">Log out</span>
            </a></li>
        </ul>
    </nav>
    <script>
        //import students
        function openImportModal() {
        var modal = document.getElementById("importModal");
        modal.style.display = "block";
        }

        function closeImportModal() {
        var modal = document.getElementById("importModal");
        modal.style.display = "none";
        }

        //assign subjects to student
        function assignSubjectsModal() {
        var modal = document.getElementById("assignSubjectModal");
        modal.style.display = "block";
        }

        // Function to close the assign subject modal
        function closeSubjectsModal() {
        var modal = document.getElementById("assignSubjectModal");
        modal.style.display = "none";
        }

        //add students manual
        function addStudentsModal(){
        var modal = document.getElementById('addStudentModal');
        modal.style.display = 'block';
        }
        function closeaddStudentsModal(){
        var modal = document.getElementById('addStudentModal');
        modal.style.display = 'none';
        }

        //edit students personnal information
        function editStudentsModal(){
        var modal = document.getElementById('editStudentModal');
        modal.style.display = 'block';
        }
        function closeeditStudentsModal(){
        var modal = document.getElementById('editStudentModal');
        modal.style.display = 'none';
        }
        
        //delete students
        function deleteStudentsModal(){
        var modal = document.getElementById('deleteStudentModal');
        modal.style.display = 'block';
        }
        function closedeleteStudentsModal(){
        var modal = document.getElementById('deleteStudentModal');
        modal.style.display = 'none';
        }

        function reloadPage() {
        location.reload(true); // Pass true to force a reload from the server, ignoring the cache
        }
    </script>

    <div id="assignSubjectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeSubjectsModal()">&times;</span>
            <?php include 'assign_stud.php'; ?>
        </div>
    </div>

    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeaddStudentsModal()">&times;</span>
            <?php include 'add_stud.php'; ?>
        </div>
    </div>

    <div id="editStudentModal" class="modal">
        <div class="modal-content-edit">
            <span class="close" onclick="closeeditStudentsModal()">&times;</span>
            <?php include 'edit_stud.php'; ?>
        </div>
    </div>
    

    <div id="deleteStudentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closedeleteStudentsModal()">&times;</span>
            <?php include 'delete_stud.php'; ?>
        </div>
    </div>

    <div id="assignSubjectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeSubjectsModal()">&times;</span>
            <?php include 'assign_stud.php'; ?>
        </div>
    </div>

    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeaddStudentsModal()">&times;</span>
            <?php include 'add_stud.php'; ?>
        </div>
    </div>

    <div id="editStudentModal" class="modal">
        <div class="modal-content-edit">
            <span class="close" onclick="closeeditStudentsModal()">&times;</span>
            <?php include 'edit_stud.php'; ?>
        </div>
    </div>
    

    <div id="deleteStudentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closedeleteStudentsModal()">&times;</span>
            <?php include 'delete_stud.php'; ?>
        </div>
    </div>
</body> 
</html>