<?php 
 session_start();
    //declare CWID variable
    $student_id = $_POST['s_id'];
    //======== BIGIN INPUT PARSING ===========
    //check for user input errors such as missing CWID or less than 9 digits
    //if error is found, kick the user back to index, following an error msg

    if(!$student_id){
        $_SESSION['message1'] = "Please enter Student ID.";
        header("Location: index.php");
    }elseif(strlen($student_id) < 9){
        $_SESSION['message1'] = "Student ID must be 9 digits.";
        header("Location: index.php");
    }elseif(!is_numeric($student_id)){
        $_SESSION['message1'] = "Please enter numeric 9 digits.";
        header("Location: index.php");
    }else{

        //user entered 9 numeric digits, now check if he/she is in database

        //local variable to connect to database
        $user = 'root';
        $password = 'root';
        $db = 'TermProject';
        $host = '127.0.0.1';
        $port = 8889;
        $socket = 'localhost:/Applications/MAMP/tmp/mysql/mysql.sock';

        $link = mysqli_init();
        $success = mysqli_real_connect($link, $host, $user, $password, $db, $port, $socket);
        if (mysqli_connect_errno()) {
            echo "<p>Error: Could not connect to data base.  Try again<p>\n";
            exit;
        } 
        //echo "Successfully connected to database TermProject\n";
        //database connected

        $query = 'SELECT S_ID, Fname, Lname from STUDENT WHERE S_ID = '.$student_id.';';
        $result = $link->query($query) or die("ERROR: " . mysqli_error($link));
        if($result->num_rows === 0){
            $_SESSION['message1'] = "The student does not exist. Please enter valid student ID.";
            header("Location: index.php");
        }else{
            $row = $result->fetch_assoc();
            $student_id = $row['S_ID'];
            $student_fname = $row['Fname'];
            $student_lname = $row['Lname'];
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Page</title>
    <meta name = "author" content="Yuri Van Steenburg" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel= "stylesheet" type="text/css" href="style.css" />
</head>
<body>
<header>
    <div class = "student_greeting">
    <h2> Student Page </h2>
    </div>
</header>
<main>
    <div class = "student_greeting">
        <?php

        echo '<h3 >Hello! '.$student_fname.' '.$student_lname.' Student ID: '.$student_id.'<h3>';

        ?>
    </div>
</main>

</body>
</html>

       