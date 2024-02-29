<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "crms";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sub_ID = $_POST['sub_ID'];

    $delete_query = "DELETE FROM sub_info WHERE sub_ID = '$sub_ID'";

    if (mysqli_query($conn, $delete_query)) {
        header("Location:/crms/admin/subject/subject.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Subject</title>
    <style>
        /* CSS styles */
        h2 {
            text-align: center;
        }
        .form-container1 {
            max-width: 300px; /* Adjust max-width as needed */
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .form-container1 input[type="text"],
        .form-container1 select {
            width: calc(50% - 5px); /* Adjust width to fit the container with padding and border */
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container1 input[type="submit"] {
            width: 100%; /* Make the submit button full width */
            background-color: #4caf50;
            color: white;
            padding: 10px 0; /* Adjust vertical padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container1 input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Adjust input width for smaller screens */
        @media (max-width: 500px) {
            .form-container1 input[type="text"],
            .form-container1 select {
                width: 100%; /* Make inputs full width on smaller screens */
            }
        }
    </style>
</head>
<body>
    <h1>Delete Course
    <div class="form-container1">
    <form method="post" action="delete_course.php">
        <input type="text" id="sub_ID" name="sub_ID" placeholder="Subject Code" required>
        <input type="submit" name="" value="Delete">
    </form>
    </div>
    <?php
    if ($message) {
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
