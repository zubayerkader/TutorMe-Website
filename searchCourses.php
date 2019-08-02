<!--
UI: from search bar to display

put search bar
take input using js
pass input to backend by http-request using js
read input by php
sql query for similar named courses using php (LIKE)
put returned data in json
pass to frontend
display data on client side using javascript 
	(document.getElementById("demo1").innerHtml = "<html>write html code</html>")
-->
<?php
	session_start();
	if(!isset($_SESSION['loggedIn']))
	{
		header('location:StudentSignInPage.php');
		exit();
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Search for Courses</title>
		<!--<link rel="stylesheet/css" href="StudentSignIn.css">-->
		<script src="bookAppointment.js"></script>
		<style>
			table 
			{
			  font-family: arial, sans-serif;
			  border-collapse: collapse;
			  width: 100%;
			}

			td, th 
			{
			  border: 1px solid #dddddd;
			  text-align: left;
			  padding: 8px;
			}
		</style>
	</head>

	<body>
		<h1>Search for course</h1>
		<a href="http://localhost:8888/studentDashboard.php">Return to Dashboard</a> <br><br>
		<label for="Department">Department: </label>
		<select id="selectDepartment">
			<option value="select">Select Department</option>
			<option value="cmpt">Computing Science</option>
			<option value="ensc">Engineering Science</option>
			<option value="bus">Business</option>
		</select>
		
		<label for="course">Course: </label>
		<input type="text" id="searchQuery" placeholder="Search...">

		<button onclick="sendSearchQuery()">Search</button>

		<p id="success"></p>

		<h2 id="courseList"></h2>
		<div id="courseListBody"></div>

		<h2 id="tutorList"></h2>
		<div id="tutorListBody"></div>

		<h2 id="dateTime"></h2>
		<div id="dateTimeBody"></div>

		<div id="addMore"></div>

		<div id="bookAppointmentButton"></div>

		
		
	</body>

	<footer>

	</footer>

</html>
