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

	function queryDB($sid, $tid, $cid, $query)
	{
		require('conn.php');
		$table = [];
		$stmt  = $dbc->prepare($query);
		if ($stmt)
		{
			$stmt->bind_param("iii", $sid, $tid, $cid);
			if ($stmt->execute())
			{
				echo "<br>No of records affected: " . $dbc->affected_rows;
				//$result = $stmt->get_result();
				//$table = $result->fetch_all(MYSQLI_ASSOC);
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
		// 	return "No Result Found";
		mysqli_close($dbc);

	}

	function cancelAppointment()
	{
		//echo "hello";
		$sid = $_GET['sid'];
		$tid = $_GET['tid'];
		$cid = $_GET['cid'];

		$query = "DELETE FROM ConnectSTC WHERE sid = ? AND tid = ? AND cid = ?";
		queryDB($sid, $tid, $cid, $query);
		echo "wassup";
	}

	function cancelRequest()
	{
		//echo "hello";
		$sid = $_GET['sid'];
		$tid = $_GET['tid'];
		$cid = $_GET['cid'];

		$query = "DELETE FROM Request WHERE sid = ? AND tid = ? AND cid = ?";
		queryDB($sid, $tid, $cid, $query);
		echo "wassup";
	}

?>