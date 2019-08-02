<?php
	session_start();
    if (isset($_SESSION['loggedIn']))
    {
        //echo "already logged in";
        header ('location:studentDashboard.php');
        exit();
    }
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Student Login</title>
		<link rel="stylesheet/css" href="StudentSignIn.css">
		<script src="main.js"></script>
	</head>

	<body>
		<main class="StudentSignIn">
			<p>SignIn</p>
			<form action="" method="POST" id="SignInform" onsubmit="">
				<div id="Email">
					<label for="email">Email: </label>
					<input type="text" id="email"></input>
				</div>
				<div id="password">
					<label for="pass">Password: </label>
					<input type="password" id="pass" ></input>
				</div>
				<div id="SignIn">
					<input type="hidden" name="Submitted" value="true">
					<input type="button" name="btn" value="SignIn" onClick="studentSignIn()"></input>
					<!--<input type="submit" value="SignIn"></input>-->

				</div>
			</form>
			<p><a href="./StudentSignUp.html">SignUp if you don't have an account!</a></p>
			<p id="demo1">demo1</p>
			<p id="demo2">demo2</p>
		</main>
		
	</body>

	<footer>

	</footer>

</html>