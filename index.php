<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="index.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="indexm.css">
    <title>Login</title>
</head>
<body>
    <div class="box">
        <form action="login.php" method="POST" autocomplete="off">
        <h2>SOL LOGIN</h2>
        <div class="inputBox">
            <input type="text" name="emp_ID" required="required">
            <span>Employee ID</span>
            <i></i>
        </div>
        <div class="inputBox">
            <input type="password" name="password" required="required">
            <span>Password</span>
            <i></i>
        </div>
        <div id="myModal2" class="modal" style="<?php echo isset($_GET['error']) ? 'display: block;' : 'display: none;'; ?>">
            <div class="modal-content">
                <span class="close" onclick="closeModal2()">&times;</span>
                <p id="error-message"><?php echo isset($_GET['error']) ? htmlspecialchars($_GET['error']) : ''; ?></p>
            </div>
        </div>  
        </div>
        <input type="submit" value="Login">
        </form>
    </div>

</body>
    <script>
    function closeModal2() {
    document.getElementById('myModal2').style.display = 'none';
}
    </script>
</html>