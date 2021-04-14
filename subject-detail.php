<?php

include "db_conn.php"; 
// Additon of ADD NEW
session_start();

if(isset($_POST['submit']))
{

    $user = $_SESSION["username"];
    $query = mysqli_query($conn,"select * from login where username = '$user'") or die("Query Failed in session");
    while($row = mysqli_fetch_assoc($query))
    {
        $id = $row['user_id'];
    }
    $subject = ($_POST['subject']);
    $subjectCode = ($_POST['subjectcode']);
    $semester = ($_POST['semester']);
    $branch = ($_POST['branch']);
    $sql = "INSERT INTO sub_details (subject, sub_code, branch, semester, user_id) VALUES ('{$subject}','{$subjectCode}', '{$branch}','{$semester}',{$id})";
    $result = mysqli_query($conn,$sql) or die("Data Addition Query Failed");
    if($result)
    {
?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data Created.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
<?php
    }

}
?>