<?php
	session_start();
	if(!isset($_SESSION['loggedIn']))
	{
		header('location:StudentSignInPage.php');
		exit();
	}
	
	$str_json = file_get_contents('php://input');
	$json = json_decode($str_json);
		
	$cid = $json->SelectedCourse->cid;
	$tid = $json->SelectedTutor->tid;
	$sid = $_SESSION['sid'];
	$timeArray = json_encode($json->Time); // $json->Time gives array of time-loc objs

	// print_r($cid);
	// print_r($tid);
	// print_r($sid);
	// print_r($timeArray);
	// print_r(json_encode($timeArray));
	// print_r(json_decode(json_encode($timeArray)));

	require_once('conn.php');
	$insertReq = "INSERT INTO Request (sid, tid, cid, time) VALUES (?, ?, ?, ?)";
	$stmt  = $dbc->prepare($insertReq);
	$sid;
	if ($stmt)
	{
		$stmt->bind_param("iiis", $sid, $tid, $cid, $timeArray);
		if ($stmt->execute())
		{
			echo "<br>No of records inserted : " . $dbc->affected_rows;
		}
		else
			echo $dbc->error . "<br>";
	}
	else
		echo $dbc->error . "<br>";

?>











