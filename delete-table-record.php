<?php
    $sub_id = $_GET['id'];
    include "db_conn.php";
    $sql = "DELETE FROM sub_details WHERE id = {$sub_id}"; 
    $result = mysqli_query($conn,$sql) or die("Deletion Unsucsessfull");
    header("Location: http://localhost/college_project/dashboard.php");
?>