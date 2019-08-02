<?php
	require_once('conn.php');
	$query = "SELECT * FROM Request";
	$stmt  = $dbc->prepare($query);
	if ($stmt)
	{
		//$stmt->bind_param("i", $tid);
		if ($stmt->execute())
		{
			$result = $stmt->get_result();
			$req_list = $result->fetch_all(MYSQLI_ASSOC);
		}
		else
			echo $dbc->error . "<br>";
	}
	else
		echo $dbc->error . "<br>";

	//print_r($req_list);			// $req_list[0]['time'] is a string
	echo "<pre>", print_r(json_decode($req_list[0]['time'])), "</pre>";
?>