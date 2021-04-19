<?php 
include "subject-detail.php"; 
session_start();
if(!isset($_SESSION["username"]))
{
  header("Location: http://localhost/college_project/login.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <title>Subject | Dashboard</title>
  </head>
  <body>
  <!-- Navbar -->
    <nav class="navbar bg-info">
      <div class="container">
          <span class="navbar-text m-auto text-light">Hello, <b> <?php echo $_SESSION["username"];  ?></b></span>
          <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Are you sure you want to logout?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
              </div>
            </div>
          </div>
        </div>
        <button class="btn primary-danger" data-toggle="modal" data-target="#exampleModal1" >Logout</button>
      </div>
    </nav>
    <div class="container border pb-5 mt-5 mb-5" >
      <div class="breadcrumb">
        <h4 class="m-auto" >New Subject: </h4>
      </div>
      <form  method="POST" action="dashboard.php">
        <div class="row">
          <div class="col">
            <input type="text" class="form-control" placeholder="Subject" name="subject" required>
            </div>
            <div class="col">
            <input type="text" class="form-control" placeholder="Subject Code" name="subjectcode" required> 
            </div>
            <div class="col">
            <input type="text" class="form-control" placeholder="Semester" name="semester" required>
            </div>
            <div class="col">
            <input type="text" class="form-control" placeholder="Branch" name="branch" required>
            </div>
            <div class="col">
            <button class="btn btn-primary form-control" name="submit" >ADD NEW</button>
          </div>
        </div>
      </form>
    </div>

  <!-- table -->
  <div class="container" >
    <?php
    include "db_conn.php";
    $user = $_SESSION["username"];
    $query = mysqli_query($conn,"select * from login where username = '$user'") or die("Query Failed in session");
    while($row = mysqli_fetch_assoc($query))
    {
        $id = $row['user_id'];
    }
    $data = "SELECT * FROM sub_details where user_id = '$id'";
    $result = mysqli_query($conn,$data) or die("Data Fetch Unsuccessfull");
    if(mysqli_num_rows($result) > 0)
    {
    ?>

    <table class="table table-bordered table-striped text-center table-sm">
    <thead class="thead-dark">
        <tr>
        <th scope="col">S.No.</th>
        <th scope="col">Subject</th>
        <th scope="col">Subject Code</th>
        <th scope="col">Branch</th>
        <th scope="col">Semester</th>
        <th scope="col"></th>
        <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        while($row = mysqli_fetch_assoc($result))
        {
        ?>
        <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['subject']; ?></td>
        <td><?php echo $row['sub_code']; ?></td>
        <td><?php echo $row['branch']; ?></td>
        <td><?php echo $row['semester']; ?></td>
        <td><a href="main-page.php?id=<?php echo $row['id'];?>"><button class="btn btn-success form-control"><i class="bi bi-pencil-square"></i></button></a></td>

        <!-- DELETE MODEL -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Do Really Want to Delete?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                This will delete the subject including marks to that corresponding subject.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="delete-table-record.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-danger">Delete</button></a>
              </div>
            </div>
          </div>
        </div>
        <td><button class="btn btn-danger form-control" data-toggle="modal" data-target="#exampleModal"><i class="bi bi-x-square-fill"></i></button></td>
        </tr>
        <?php } ?>
    </tbody>
    </table>
    <?php } ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>

