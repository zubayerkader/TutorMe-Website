<?php
	session_start();
	if(!isset($_SESSION['loggedIn']))
	{
		header('location:StudentSignInPage.php');
		exit();
	}
	
	$function = $_GET["function"];
	if (function_exists($function))
	{
		$function();
	}

	function getCourseList()
	{
		require_once("conn.php");

		$course = $_GET["course"];
		$department = $_GET["department"];

		$query = "	SELECT *
					FROM Course, Department
					WHERE Course.did=Department.did 
							and dname=? and cname LIKE '%$course%'
				 ";
		$stmt  = $dbc->prepare($query);
	    if ($stmt)
	    {
	    	//$param = "%" + $param + "%"
	        $stmt->bind_param("s", $department);
	        if ($stmt->execute())
	        {
	        	$result = $stmt->get_result();
				$course_list = $result->fetch_all(MYSQLI_ASSOC);
	        }
	        else
	            echo $dbc->error . "<br>";
	    }
	    else
	        echo $dbc->error . "<br>";

		echo json_encode($course_list);

	}

	function getTutors()
	{
		require_once("conn.php");
		$cid = $_GET["cid"];

		$query = "	SELECT Tutor.tid, fname, lname, rating, qualification
					FROM Tutor, TutorToCourse
					WHERE cid=? and Tutor.tid=TutorToCourse.tid
					ORDER BY rating DESC
				 ";
		$stmt  = $dbc->prepare($query);
	    if ($stmt)
	    {
	    	//$param = "%" + $param + "%"
	        $stmt->bind_param("i", $cid);
	        if ($stmt->execute())
	        {
	        	$result = $stmt->get_result();
				$tutor_list = $result->fetch_all(MYSQLI_ASSOC);
	        }
	        else
	            echo $dbc->error . "<br>";
	    }
	    else
	        echo $dbc->error . "<br>";

		echo json_encode($tutor_list);

	}
?>