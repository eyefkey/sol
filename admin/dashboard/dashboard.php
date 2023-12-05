<?php
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
$sql = "SELECT * FROM user_info";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="/sol/admin/css/dashboard.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
    <main class="table">
        <section class="table__header">
            <h1>Dashboard</h1>
            <div class="export__file">
    <label for="export-file" class="export__file-btn" title="Export File"></label>
    <input type="checkbox" id="export-file">
    <div class="export__file-options">
        <label>Select: &nbsp; &#10140;</label>
        <label for="export-file" id="toPDF" onclick="openModal()">Add Employee<img src="images/pdf.png" alt=""></label>
        <label for="export-file" id="toJSON" onclick="editModal()">Edit Employee<img src="images/json.png" alt=""></label>
        <label for="export-file" id="toCSV" onclick="deleteModal()">Delete Employee<img src="images/csv.png" alt=""></label>
    </div>
</div>

        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Name</th>
                        <th> Employee ID </th>
                        <th> Password </th>
                        <th> Role </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['emp_lname']," ",$row['emp_fname']," ",$row['emp_mname']; ?></td>
                        <td><?php echo $row['emp_ID']; ?></td>
                        <td><?php echo $row['password']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <?php } }else{ ?>
                            <tr><td colspan="8">No Employee(s) found...</td></tr>
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
            <li><a href="\sol\admin\dashboard\dashboard.php">
                <i class="fas fa-home"></i>
                <span class="nav-item">Dashboard</span>
            </a></li>
            <li><a href="\sol\admin\student\student.php">
                <i class="fas fa-user"></i>
                <span class="nav-item">Students</span>
            </a></li>
            <li><a href="\sol\admin\subject\subject.php"><i class="fas fa-tasks"></i>
                <span class="nav-item">Subject</span>
            </a></li>
            <li><a href="\sol\index.php" class="logout"><i class="fas fa-sign-out-alt"></i>
                <span class="nav-item">Log out</span>
            </a></li>
        </ul>
    </nav>
    <script>
            function openModal() {
    document.getElementById("addEmployeeModal").style.display = "block";
    }
    function closeModal() {
    document.getElementById("addEmployeeModal").style.display = "none";
    }
    function editModal() {
    document.getElementById("editEmployeeModal").style.display = "block";
    }
    function closeModaledit() {
    document.getElementById("editEmployeeModal").style.display = "none";
    }
    function deleteModal() {
    document.getElementById("deleteEmployeeModal").style.display = "block";
    }
    function closeModaldelete() {
    document.getElementById("deleteEmployeeModal").style.display = "none";
    }
    </script>
    
    <div id="addEmployeeModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <?php include 'add_emp.php'; ?>
    </div>
    </div>

    <div id="editEmployeeModal" class="modal">
        <div class= "modal-content">
            <span class="close" onclick="closeModaledit()">&times;</span>
            <?php include 'edit_emp.php'; ?>
    </div>
    </div>

    <div id="deleteEmployeeModal" class="modal">
        <div class= "modal-content">
            <span class= "close" onclick="closeModaldelete()">&times;</span>
            <?php include 'delete_emp.php'; ?>
    </div>
    </div>
</body>
</html>