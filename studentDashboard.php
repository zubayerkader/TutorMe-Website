<?php

	//needs to be added: do using php
	//remove previous appointments

	session_start();
	if(!isset($_SESSION['loggedIn']))
	{
		header('location:StudentSignInPage.php');
		exit();
	}
	$sid = $_SESSION['sid'];
	$email = $_SESSION['email'];

	function queryDB($sid, $query)
	{
		require('conn.php');
		$table = [];
		$stmt  = $dbc->prepare($query);
		if ($stmt)
		{
			$stmt->bind_param("i", $sid);
			if ($stmt->execute())
			{
				$result = $stmt->get_result();
				$table = $result->fetch_all(MYSQLI_ASSOC);
			}
			else
				echo $dbc->error . "<br>";
		}
		else
			echo $dbc->error . "<br>";
		//echo '<pre>' , print_r($table) , '</pre>';
		// if (count($table) > 0)
		// 	return $table;
		// else
		// 	return null;
		mysqli_close($dbc);
		return $table;

	}

	//student info
	$query1 = "SELECT * FROM Student WHERE sid=?";
	$studentInfo = queryDB($sid, $query1);
	//echo '<pre>' , print_r($studentInfo) , '</pre>';

	// appointments
	$query2 = "SELECT stc.cid, cname, ccode, stc.tid, fname, lname, phone, rating, qualification, location, stc.date, stc.from, stc.to  FROM ConnectSTC stc, Course c, Tutor t WHERE stc.sid=? and stc.cid=c.cid and stc.tid=t.tid";
	$appointments = queryDB($sid, $query2);
	//echo '<pre>' , print_r($appointments) , '</pre>';

	//pending requests
	$query3 = "SELECT r.tid, fname, lname, qualification, rating, r.cid, cname, ccode, time FROM Request r, Tutor t, Course c WHERE sid=? and r.tid=t.tid and r.cid=c.cid";
	$requests = queryDB($sid, $query3);
	//echo '<pre>' , print_r($requests) , '</pre>'; 

?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Student Dashboard</title>
		
		<script src="studentDashboard.js"></script>
	</head>

	<body>
		
		<h3>Signed In as Student</h3>
		<div id="studentInfo">
			<h2> Hi <?php echo $studentInfo[0]['fname']?> </h2>
			<a href="http://localhost:8888/account.php">Account Settings</a> <br> <br> 
			<a href="http://localhost:8888/studentSignOut.php">SignOut</a> <br> <br> 
		</div>

		<a href="http://localhost:8888/searchCourses.php">Search for Courses</a> <br>

		<h2>Appointments</h2>
		<div id="appointments">
			<?php 
				if (count($appointments) > 0)
				{
					for ($i=0; $i < count($appointments); $i++) 
					{
						echo "<div id='appointment-" . $i . "'>Course Name: " . $appointments[$i]['cname'] . "<br>Course Code: " . $appointments[$i]['ccode'] . "<br>With: " . $appointments[$i]['fname'] . " " . $appointments[$i]['lname'] . "<br>Tutor's Rating: " . $appointments[$i]['rating'] . "<br>Tutor's Qualification: " . $appointments[$i]['qualification'] . "<br>At: " . $appointments[$i]['location'] . "<br>Date: " . $appointments[$i]['date'] . "<br>From: " . $appointments[$i]['from'] . "<br>To: " . $appointments[$i]['to'] . "<br><a href='javascript: cancelAppointment(" . $sid . ", " . $appointments[$i]['tid'] . ", " . $appointments[$i]['cid'] . ")'>Cancel this Appointment</a>" . "<br><br></div>";
					}
				}
				else
					echo "No Appointments Scheduled"
			?>

		</div>

		<h2>Pending Requests</h2>
		<div id="pendingRequests">
			<?php 
				if (count($requests) > 0)
				{
					for ($i=0; $i < count($requests); $i++) 
					{
						$timeLocation = json_decode($requests[$i]['time']);
						//echo '<pre>' , print_r($timeLocation) , '</pre>';
						$string = "<div id='request-" . $i . "'>Course Name: " . $requests[$i]['cname'] . "<br>Course Code: " . $requests[$i]['ccode'] . "<br>With: " . $requests[$i]['fname'] . " " . $requests[$i]['lname'] . "<br>Tutor's Rating: " . $requests[$i]['rating'] . "<br>Tutor's Qualification: " . $requests[$i]['qualification'];
						for ($j=0; $j < count($timeLocation); $j++) 
						{ 	
							if ($j == (count($timeLocation)-1))	
								$string .= "<br>At: " . $timeLocation[$j]->location . "<br>Date: " . $timeLocation[$j]->date . "<br>From: " . $timeLocation[$j]->from . "<br>To: " . $timeLocation[$j]->to;
							else
								$string .= "<br>At: " . $timeLocation[$j]->location . "<br>From: " . $timeLocation[$j]->from . "<br>To: " . $timeLocation[$j]->to . "<br>Or";
						}
						$string .= "<br><a href='javascript: cancelRequest(" . $sid . ", " . $requests[$i]['tid'] . ", " . $requests[$i]['cid'] . ")'>Cancel this Request</a>" . "<br><br></div>";
						echo $string;
					}
				}
				else
					echo "No Pending Requests"
			?>
		</div>
		<div id="demo"></div>


		
	</body>

	<footer>

	</footer>

</html>