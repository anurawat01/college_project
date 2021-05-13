<?php
include "db_conn.php";

$co_id_query = "SELECT ct_id FROM class_test WHERE sub_id = '{$_GET['id']}' AND ct_num = '{$_GET['ct_num']}' ";
$co_id_result = mysqli_query($conn,$co_id_query);
if($co_id_result)
{
    $co_row = mysqli_fetch_array($co_id_result,MYSQLI_NUM);
    $co_id = $co_row[0];
}
else
{
    echo "Error";
}

$arr = array();
$cnt_id_query = "SELECT cnt_id FROM ques_cnt INNER JOIN course_outcome ON course_outcome.co_id = ques_cnt.co_id WHERE ques_cnt.co_id = '{$co_id}'";
$cnt_id_result = mysqli_query($conn,$cnt_id_query) or die("Count Query Failed");
    if($cnt_id_result)
    {
        while($cnt_row = mysqli_fetch_array($cnt_id_result))
        {
            array_push($arr,$cnt_row['cnt_id']);
        }
    }
    else
    {
        echo "Error Question Count";
    }
        
$i = 1;
$k = 1;
while($i<=$_POST['co_count'])
{   
        for($j = 1; $j<=$_POST['co_'.$i]; $j++)
        {
            $ques_cnt = "INSERT INTO questions (cnt_id, question_num, max_marks) VALUES ('{$arr[$i-1]}',   '{$j}'   ,  '{$_POST['ques_'.$k]}')";
            if(!mysqli_query($conn,$ques_cnt))
            {
                die('Invalid query: ' . mysql_error());
            }
            $k = $k + 1;   
        }     
    $i++;
}
echo $_GET['ct_num'];

?>