<?php
// Include your database configuration file
include 'config.php';
include 'dbconfig.php';

// Check if the form is submitted
if (isset($_POST['importSubmit'])) {
    // Allowed mime types
    $csvMimes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );

    // Validate whether the selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
        // If the file is uploaded
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            // Open the uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from the CSV file line by line
            while (($line = fgetcsv($csvFile)) !== false) {
                // Get row data
                $studid = $line[0];
                $lastname = $line[1];
                $firstname = $line[2];
                $middle = $line[3];
                $yearlevel = $line[4];
                $semester = $line[5];
                $section = $line[6];
                $email = $line[7];

                // Check whether the member already exists in the database with the same email
                $prevQuery = "SELECT stud_id FROM student_info WHERE stud_id = '".$line[0]."'";
                $prevResult = mysqli_query($conn, $prevQuery);

                if ($prevResult !== false && mysqli_num_rows($prevResult) > 0) {
                    // Update member data in the database
                    $updateQuery = "UPDATE student_info SET stud_id = '$studid', stud_lname = '$lastname', stud_fname = '$firstname', stud_mname = '$middle', yr_lvl = '$yearlevel', semester = '$semester', section = '$section' WHERE email_add = '$email'";
                    mysqli_query($conn, $updateQuery);
                } else {
                    // Insert member data into the database
                    $insertQuery = "INSERT INTO student_info (stud_id, stud_lname, stud_fname, stud_mname, yr_lvl, semester, section, email_add) VALUES ('$studid', '$lastname', '$firstname', '$middle', '$yearlevel', '$semester', '$section', '$email')";
                    mysqli_query($conn, $insertQuery);
                }
            }

            // Close the opened CSV file
            fclose($csvFile);

            $qstring = '?status=succ';
        } else {
            $qstring = '?status=err';
        }
    } else {
        $qstring = '?status=invalid_file';
    }
}
    
// Redirect to the listing page
header("Location: student.php".$qstring);
?>
<!DOCTYPE html>
        <html>
        <head>
            <title>Import Students</title>
            <!-- Your style sheets and other meta information -->
        </head>
        <body>
            <h2>Import Form</h2>
            <form action="importdata.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" />
            <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
        </form>
        <!-- Additional content if needed -->
        </body>
        </html>