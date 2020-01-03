<?php

$id = (int)$_GET['lineID'];
$id = $id*1;
getDataAtID($id);

function getDataAtID($id){
        $con = mysqli_connect('localhost', 'root', '');
        if(!$con) {die('Not Connected To Server'); }
        if(!mysqli_select_db($con, 'lessonplaner')) {echo 'Database Not Selected';}
        $con->set_charset('utf8');
        $sql="SELECT * FROM activities WHERE ID = $id";
        $result = mysqli_query($con,$sql);
        $array = mysqli_fetch_row($result);
        echo json_encode($array);
        mysqli_close($con);
}
?>