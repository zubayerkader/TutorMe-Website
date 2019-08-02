<?php
    //learn to query db
    //password verify
    //get all data about student (including connected tutor and course)
    //create a html using this data either in front-end or in back-end


    //if in front-end pass json data to js and let js create the html page
    //if in back-end create the html page using php and then return page to front-end

    session_start();
    if (isset($_SESSION['loggedIn']))
    {
        //echo "already logged in";
        header ('location:studentDashboard.php');
        exit();
    }

	$str_json = file_get_contents('php://input');
    $json = json_decode($str_json);

    $email = $json->email; //"marefin@sfu.ca";
    $password = $json->pass; //"12345678";

    require_once('conn.php');
    $stmt  = $dbc->prepare("SELECT sid, password FROM StudentLogin WHERE email=?");
    
    if ($stmt)
    {
        $stmt->bind_param("s", $email);
        if ($stmt->execute())
        {
        	$stmt->bind_result($sid, $dbpassword);
            //echo "<br>No of records inserted : " . $dbc->affected_rows;
        }
        else
            echo $dbc->error . "<br>";
    }
    else
        echo $dbc->error . "<br>";

    //$stmt->fetch_all();
    //echo $str_json;
    while ($stmt->fetch()) 
    {
		//echo $sid . " " . $dbpassword . "<br>";
	}

    if (($stmt->num_rows == 1) && password_verify($password, $dbpassword)) 
    {
        $_SESSION['loggedIn'] = '1';
        $_SESSION['sid'] = $sid;
        $_SESSION['email'] = $email;

        //$_SESSION['password'] = $password;

        echo 'Password is valid!';
        //header("location:http://localhost:8888/studentDashboard.php");
        //readfile("index.html");
        //header("location: http://localhost:8888/index.html");
    } 
    else 
    {
        echo 'Invalid password.<br>';
    }

?>
