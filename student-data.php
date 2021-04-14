<?php

include "db_conn.php";

if(isset($_POST['stud_submit']))
{   
    $stud_roll = $_POST['rollNum'];
    $stud_name = $_POST['studName'];
    
    $sql = "INSERT INTO stud_data (stud_roll,stud_name) VALUES ('{$stud_roll}','{$stud_name}')";
    $result = mysqli_query($conn,$sql) or die("Data Addition Query Failed");
}

?>