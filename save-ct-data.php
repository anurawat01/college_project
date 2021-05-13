<?php
include "db_conn.php";
session_start();

if(isset($_POST['ctNum']))
{
    $query = "SELECT * from class_test WHERE ct_num = '{$_POST['ctNum']}' and sub_id = '{$_GET['id']}'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0)
    {
        http_response_code(404);
        die();
    }
    else
    {
        $ct_num = $_POST['ctNum'];
        $sql = "INSERT INTO class_test(sub_id,ct_num) VALUES ('{$_GET['id']}','{$ct_num}')";
        if(mysqli_query($conn,$sql))
        {
            echo '<span class="success alert-success">
                  CT '. $ct_num . ' Created!
                  </span>';
        }
        else
        {
            echo "Query Failed";    
        }

    }
}
?>