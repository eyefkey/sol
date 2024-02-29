<!DOCTYPE html>
<html>
<head>
	<title>Welcome to SOL-CRMS</title>
	<link rel="stylesheet" type="text/css" href="assets/css/index.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<!-- <img class="wave" src="assets/imgs/bgnew.png"> -->
	<div class="container">
		<div class="img">
			<!-- <img src="assets/imgs/bg.svg"> -->
		</div>
		<div class="login-content">
			<form action="login.php" method="POST" autocomplete="off">
				<img src="assets/imgs/sol.png">
				<h2 class="title">Welcome</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Username</h5>
           		   		<input type="text" name="emp_username" required="required" class="input">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" name="password" required="required" class="input">
            	   </div>
            	</div>
            	<input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="assets/js/index.js"></script>
</body>
</html>
