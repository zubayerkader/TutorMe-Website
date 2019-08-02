<?php

	//needs to be added:
	//remove previous appointments
	//cancel existing appointments
	//view requests
	//cancel requests

	session_start();
	if(!isset($_SESSION['loggedIn']))
	{
		header('location:StudentSignInPage.php');
		exit();
	}
	$sid = $_SESSION['sid'];
	$email = $_SESSION['email'];

	

	require_once('conn.php');

    $stmt  = $dbc->prepare("SELECT cname, ccode, fname, lname, phone, location, appointment FROM ConnectSTC stc, Course c, Tutor t WHERE stc.sid=? and stc.cid=c.cid and stc.tid=t.tid");
    if ($stmt)
    {
        $stmt->bind_param("i", $sid);
        if ($stmt->execute())
        {
        	$stmt->bind_result($cname, $ccode, $fname, $lname, $phone, $location, $appointment);
        }
        else
            echo $dbc->error . "<br>";
    }
    else
        echo $dbc->error . "<br>";


    $i = 0;
	$table = array();
    while ($stmt->fetch()) 
    {
		echo $cname . " " . $ccode . "<br>" . $fname . " " . $lname . " " . $phone . "<br>" . $location . " " . $appointment . "<br><br>";
		$new_row = array($i => array("cname" => $cname, "ccode" => $ccode, "fname" => $fname, "lname" => $lname, "phone" => $phone, "location" => $location, "appointment" => $appointment));
		$table = array_merge($table, $new_row);
		$i++;
	}
	//echo '<pre>' , print_r($table) , '</pre>';
	mysqli_close($dbc);

?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Student Dashboard</title>
		
		
	</head>

	<body>
		<p>hello</p>
		<a href="http://localhost:8888/searchCourses.php">Search for Courses</a><br>
		<?php echo "sid: " . $sid . "<br>" . "email: " . $email . "<br>"; ?>
		<a href="studentSignOut.php">SignOut</a><br>
	</body>

	<footer>

	</footer>

</html>