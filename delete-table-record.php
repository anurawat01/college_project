<?php
    include "db_conn.php";
    $sub_id = $_GET['id'];
    echo $sub_id;
    // $sql = "DELETE FROM sub_details WHERE id = '{$sub_id}'"; 
    // $result = mysqli_query($conn,$sql);
    // if(!$result)
    // {
    //     echo "Error".mysql_error();
    // }
    //header("Location: http://localhost/college_project/dashboard.php");
?>