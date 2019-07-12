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
            $password = $json->pass;
            $phone = $json->phone;
            $gender = $json->gender;
            $department = $json->major;
            $school = $json->school;

            require_once('conn.php');
            $query = "INSERT INTO Student (fname, lname, email, phone, gender, department, school) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt  = $dbc->prepare($query);
            if ($stmt)
            {
                $stmt->bind_param("sssdsss", $fname, $lname, $email, $phone, $gender, $department, $school);
                if ($stmt->execute())
                {
                    echo "<br>No of records inserted : " . $dbc->affected_rows;
                    echo "<br>Insert ID : " . $dbc->insert_id;
                }
                else
                    echo $dbc->error;
            }
            else
                echo $dbc->error;
            //i Integers
            //d Doubles
            //b Blobs
            //s Everything Else
        ?>
    </body>
</html>