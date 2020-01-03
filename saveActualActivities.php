<?php
    $line = $_GET['line'];
    $savename = $_GET['name'];

    $con = mysqli_connect('localhost', 'root', '');
 
    if(!$con) {
        die('Not Connected To Server');
    }

    if(!mysqli_select_db($con, 'lessonplaner')) {
        echo 'Database Not Selected';
    }
    $con->set_charset('utf8');
    $query = mysqli_query($con,"SELECT * FROM actual_activities");

    $time = $_GET['time'];
    $lesson = $_GET['lesson'];
    $method = $_GET['method'];
    $workforms = $_GET['workforms'];
    $tools = $_GET['tools'];
    $notes = $_GET['notes'];

    $time = (int) $time;
    $time = $time*1;

    $sql = "INSERT INTO actual_activities (name, time, lesson, method, workforms, tools,notes) VALUES 
    ('$savename','$time', '$lesson', '$method', '$workforms', '$tools','$notes')";

    if(!mysqli_query($con, $sql)) {
        echo 'Could not insert';
    }
    else {
        echo "Thank you, " .'time'.$line. ". Your information has been inserted.";
    }
 
    mysqli_close($con);
?>