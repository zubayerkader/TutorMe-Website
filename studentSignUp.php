<html>
    <head>
        <title>Add Student</title>
    </head>
    <body>
        <?php
            $str_json = file_get_contents('php://input');
            $json = json_decode($str_json);
            
            $fname = $json->fname;
            $lname = $json->lname;
            $email = $json->email;
            $password = password_hash($json->pass, PASSWORD_DEFAULT);
            $phone = $json->phone;
            $gender = $json->gender;
            $department = $json->major;
            $school = $json->school;

            require_once('conn.php');
            $sinsert = "INSERT INTO Student (fname, lname, email, phone, gender, department, school) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt  = $dbc->prepare($sinsert);
            $sid;
            if ($stmt)
            {
                $stmt->bind_param("sssdsss", $fname, $lname, $email, $phone, $gender, $department, $school);
                if ($stmt->execute())
                {
                    echo "<br>No of records inserted : " . $dbc->affected_rows;
                    $sid = $dbc->insert_id;
                    echo "<br>Insert ID : " . $dbc->insert_id . "<br>";
                }
                else
                    echo $dbc->error . "<br>";
            }
            else
                echo $dbc->error . "<br>";

            $slogininsert = "INSERT INTO StudentLogin (sid, email, password) VALUES (?, ?, ?)";
            $stmt  = $dbc->prepare($slogininsert);
            if ($stmt)
            {
                $stmt->bind_param("iss", $sid, $email, $password);
                if ($stmt->execute())
                {
                    echo "<br>No of records inserted : " . $dbc->affected_rows . "<br>";
                    //echo "<br>Insert ID : " . $dbc->insert_id;
                }
                else
                    echo $dbc->error . "<br>";
            }
            else
                echo $dbc->error . "<br>";

            //readfile("index.html");

            //i Integers
            //d Doubles
            //b Blobs
            //s Everything Else
        ?>
    </body>
</html>