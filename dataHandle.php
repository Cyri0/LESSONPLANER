<?php
    //Connection to MySQL
    $con = mysqli_connect('localhost', 'root', '');
 
    if(!$con) {
        die('Not Connected To Server');
    }
 
    //Connection to database
    if(!mysqli_select_db($con, 'lessonplaner')) {
        echo 'Database Not Selected';
    }
    $con->set_charset('utf8');
    $query = mysqli_query($con,"SELECT * FROM userdatas");

    $teacher = $_POST['nameOfTheTeacher'];
    $subject = $_POST['schoolSubject'];
    $class = $_POST['schoolClass'];
    $lessonTheme = $_POST['subjectTheme'];
    $goals = $_POST['subjectGoals'];
    $didactics = $_POST['subjectDidactics'];
    $subjectConnections = $_POST['subjectRelationships'];
    $sources = $_POST['usedSources'];
    $date = $_POST['date'];

    $sql = "INSERT INTO userdatas (teacher, subject, class, lessonTheme, goals, didactics, subjectConnections, sources, date) VALUES ('$teacher', '$subject','$class','$lessonTheme','$goals', '$didactics', '$subjectConnections', '$sources', '$date')";

    //Response
    //Checking to see if name or email already exsist
    if(!mysqli_query($con, $sql)) {
        echo 'Could not insert';
    }
    else {
        echo "Thank you, " . $_POST['nameOfTheTeacher'] . ". Your information has been inserted.";
    }
 
    //Close connection
    mysqli_close($con);
?> 


