<?php

include "db_conn.php";

    $co_num = $_GET['co_num'];
    $ct_num = $_GET['ct_num'];
    $sub_id = $_GET['id'];

    $ct_id_sql = "SELECT ct_id FROM class_test WHERE sub_id = '{$sub_id}' AND ct_num = '{$_GET['ct_num']}'";
    $ct_id_query = mysqli_query($conn,$ct_id_sql) or die("Data Fetch Unsuccessfull");
    if($ct_id_query)
    {
        $row = mysqli_fetch_array($ct_id_query,MYSQLI_NUM);
        $ct_id = $row[0];
    }

    $sql = "INSERT INTO course_outcome(ct_id,co_num) VALUES('{$ct_id}','{$co_num}')";


    if(mysqli_query($conn,$sql))
    {
        for($i = 1; $i<=$co_num; $i++)
        {
            $query_cnt = "INSERT INTO ques_cnt(co_id,ques_count) VALUES ('{$ct_id}','{$_POST['co_'.$i]}')";
            if(!mysqli_query($conn,$query_cnt))
            {
                die('Invalid query: ' . mysql_error());
            }
        }
        echo '<span class="alert-success"> DATA SAVED </span>';

    } 
    else
    {
        echo '<span class="alert-danger"> DATA NOT SAVED </span>';
    }

?>