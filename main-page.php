<?php
include "student-data.php"; 
session_start();

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
    <title>Hello, world!</title>
  </head>
  <body>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-center" id="exampleModalLabel">Class Test Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <input type="num" class="form-control" id="ctNum" placeholder="CT No." required>
              </div>
              <!-- DYNAMIC CO GENERATION -->
              <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" id="co_count" placeholder="CO" required> 
                    <div class="input-group-append">
                    <span class="input-group-txt">
                    <button class="btn btn-info" id="created" onClick="create()" type="submit">
                        Create
                    </button>
                    </span>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                <div id="demo1">
                </div>
                <div id="demo2" class="mt-3">
                <button class="btn btn-info form-control mb-3" id="marked" onClick="max_marks()" type="submit" disabled>
                Marks 
                </button>
                </div>
              </div>
              <button type="submit" id="sub" class="btn btn-success form-control">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title center" id="exampleModalLabel">Student Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="main-page.php" method="POST">
              <div class="form-group">
                <input type="text" class="form-control" name="rollNum" placeholder="Roll No.">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="studName" placeholder="Name">
              </div>
              <button type="submit" name="stud_submit" class="btn btn-primary form-control">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- Navbar -->


    <nav class="navbar bg-info">
      <div class="container">
          <span class="navbar-text m-auto text-light">Hello, <b><?php echo $_SESSION["username"];  ?></b></span>
          <a href="logout.php" ><button class="btn primary-danger">Logout</button></a>
      </div>
    </nav>

    <!-- subject detail -->
    <?php
    include "db_conn.php";
    $user = $_SESSION["username"];
    $query = mysqli_query($conn,"select * from login where username = '$user'") or die("Query Failed in session");
    while($row = mysqli_fetch_assoc($query))
    {
        $id = $row['user_id'];
    }
    $sub_id = $_GET['id'];
    $data = "SELECT * FROM sub_details where user_id = '$id' AND id = '$sub_id'";
    $result1 = mysqli_query($conn,$data) or die("Data Fetch Unsuccessfull");
    if(mysqli_num_rows($result1) > 0)
    {
      $row = mysqli_fetch_assoc($result1)
    ?>
    <div class="breadcrumb">
      <div class="col input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">Subject:</span> 
        </div>  
        <input class = "form-control" value="<?php echo $row['subject'];  ?>" readonly> 
      </div>
      <div class="col input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">Subject Code:</span> 
        </div>  
        <input class = "form-control" value="<?php echo $row['sub_code'];  ?>" readonly> 
      </div>  
      <div class="col input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">Branch:</span> 
        </div>  
        <input class = "form-control" value="<?php echo $row['branch'];  ?>" readonly> 
      </div>
      <div class="col input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">Semester:</span> 
        </div>  
        <input class = "form-control" value="<?php echo $row['semester'];  ?>" readonly> 
      </div>
    </div>
    <?php
    }
    ?>

    <?php

    if($result)
    {
      echo '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Student Data.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>

    <div class="breadcrumb bg-dark">
    <div class="col text-center">
        <button type ="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal0">
          ADD Student
        </button>
        </div>
    <div class="col text-center">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          ADD CT
        </button>
    </div>
    </div>


    <!-- CT Table -->
    <div class="container">
      <table class="table table-bordered bg-light text-center table-sm">
        <tbody>
          <tr>
            <th width = "328">Examination</th>
            <th colspan="6" >
            CT:
            <select class="form-select form-select-sm" aria-label=".form-select-sm example">
              <option selected value = "1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
            </th>
          </tr>
          <tr>
            <th> Course Outcomes </th>
            <td colspan="3" >CO: 1</td>
            <td colspan="3" >CO: 2</td>
          </tr>
          <tr>
            <th>Question Numbers </th>
            <td>Q1</td>
            <td>Q2</td>
            <td>Q3</td>
            <td>Q4</td>
            <td>Q5</td>
            <td>Q6</td>
          </tr>
          <tr>
            <th>Max Marks</th>
            <td>5</td>
            <td>5</td>
            <td>5</td>
            <td>5</td>
            <td>5</td>
            <td>5</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="container">
      <?php
      include "db_conn.php";
      $data = "SELECT * FROM stud_data";
      $result = mysqli_query($conn,$data) or die("Data Fetch Unsuccessfull");
      if(mysqli_num_rows($result) > 0)
      {
      ?>
      <table class="table table-bordered text-center table-sm">
      <thead class="bg-dark text-white">
          <tr>
            <th> Student_ID </th> 
            <th width = "200"> Name </th>
            <th  colspan="6" >Marks</th>
          </tr>
        </thead>

      <tbody>
      <?php
        while($row = mysqli_fetch_assoc($result))
        {
      ?>
      <tr>
        <td><input class="form-control" value = "<?php echo $row['stud_roll']; ?>" readonly></td>
        <td><input class="form-control" value = "<?php echo $row['stud_name']; ?>" readonly></td>    
        <td><input class="form-control" value = "2" ></td>
        <td><input class="form-control" value = "5" ></td>
        <td><input class="form-control" value = "4" ></td>
        <td><input class="form-control" value = "5" ></td>
        <td><input class="form-control" value = "5" ></td>
        <td><input class="form-control" value = "5" ></td>
      </tr>
      </tbody>
      <?php
        }
      }
      ?>
      
    </div>
    </table>
      
        <table class="table table-striped table-bordered text-center table-sm">
          <tr>
            <td width="327" class="bg-dark text-white" ><input class="form-control"  value = "Marks more than 50% score" readonly></td>
            <td><input class="form-control" value = "2" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "4" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
          </tr>
          <tr>
            <td class="bg-dark text-white"  ><input class="form-control" value = "Students Attempted" readonly></td>
            <td><input class="form-control" value = "2" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "4" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
          </tr>
          <tr>
            <td class="bg-dark text-white"  ><input class="form-control" value = "Percentage" readonly></td>
            <td><input class="form-control" value = "2" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "4" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
          </tr>
          <tr>
            <td class="bg-dark text-white"  ><input class="form-control" value = "Internal Assesment" readonly></td>
            <td><input class="form-control" value = "2" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "4" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
          </tr>
      </table>
    </div>

  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>

  <script>
  
  
  function create()
  {

    var j = 0;
    document.getElementById("created").disabled = true;
    document.getElementById("marked").disabled = false;
    j = j + 1;
    var a = document.getElementById("demo1");
    var no_co = document.getElementById("co_count").value;
    console.log(no_co);
    for(var i = 1; i<=no_co; i++)
    {
      var b = document.createElement("Input");
      b.setAttribute("type", "text");
      b.setAttribute("class", "form-control");
      b.setAttribute("placeholder","No. of Ques in: CO "+parseInt(i));
      b.setAttribute("id", "co_"+parseInt(i));
      b.setAttribute("required","");
      a.appendChild(b);
    }

  }


  function max_marks()
  {
    document.getElementById("marked").disabled = true;
    var num_of_co = document.getElementById("co_count").value;
    var ques_count = 1; 
    for(var i = 0; i<num_of_co; i++)
    {
      var data = document.getElementById("co_"+parseInt(i+1)).value;
      var d = document.getElementById("demo2");
      for(var j = 1; j<=data; j++)
      {
        var c = document.createElement("Input");
        c.setAttribute("type", "text");
        c.setAttribute("class", "form-control");
        c.setAttribute("placeholder","Max Marks of Ques no. "+parseInt(ques_count));
        c.setAttribute("id", "co_"+parseInt(j));
        c.setAttribute("required","");
        d.appendChild(c);
        ques_count = ques_count + 1;
      }
    }
    

  }
  </script>
</html>