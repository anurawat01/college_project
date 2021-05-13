<?php



include "db_conn.php";

session_start();

echo $_SESSION['user_id'];
// header('Content-Type: application/json');
// header('Acess-Control-Alow-Origin: *');



// $sql = "SELECT subject,sub_code,class_test.ct_num,course_outcome.co_num,ques_cnt.ques_count FROM sub_details INNER JOIN class_test ON sub_details.id = class_test.sub_id INNER JOIN course_outcome ON class_test.ct_id = course_outcome.ct_id INNER JOIN ques_cnt ON course_outcome.co_id = ques_cnt.co_id WHERE sub_details.user_id = '{$_SESSION['user_id']}'";
// $result = mysqli_query($conn,$sql) or die("Query Unsucessfull");

// if(mysqli_num_rows($result) > 0)
// {
//     $output = mysqli_fetch_all($result,MYSQLI_ASSOC);
//     echo json_encode($output);
// }
// else
// {   

//     echo json_encode(array('message' => 'No Record Found', 'status' => false));

// }   


?>