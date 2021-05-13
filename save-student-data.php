<?php

include "db_conn.php";


$stud_roll = $_POST['roll_no'];
$stud_name = $_POST['stud_name'];
    
$sql = "INSERT INTO stud_data (stud_roll,stud_name) VALUES ('{$stud_roll}','{$stud_name}')";
$result = mysqli_query($conn,$sql) or die("Data Addition Query Failed");
if($result)
{
    echo $stud_name;
}
else
{
    http_response_code(404);
    die();
}

?>
