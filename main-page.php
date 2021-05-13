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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Marks | Dashboard</title>
  </head>
  <body>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title text-center" id="exampleModalLabel">Class Test Data</h5>
            <button type="button" class="close" id="modal_close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card m-auto">
            <!-- <div class="card-header bg-dark text-center text-white">
                Class Test Details
            </div> -->
            <div class="card-body">
                <?php
                    include "db_conn.php";
                    $ct_sql = "SELECT MAX(ct_num) from class_test WHERE sub_id = '{$_GET['id']}'";
                    $ct_result = mysqli_query($conn,$ct_sql) or die("Unsucessfull");
                    if($ct_result)
                    {
                        $ct_row = mysqli_fetch_array($ct_result,MYSQLI_NUM);
                ?>
                <form id="submit_form" method="POST">
                <div class="form-group">
                    
                    <label for="ctNum">Enter Class Test Number: </label>
                    <input type="num" name="ctNum" class="form-control" id="ctNum" placeholder="CT No." value="<?php echo $ct_row[0]+1; ?>" readonly>
                    <span id="availablity" > </span>
                    <?php
                    }
                    else
                    {
                      echo "Query Failed";
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label for="co_count">Enter Number of Course Outcome: </label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="co_count" id="co_count" placeholder="CO"> 
                        <div class="input-group-append">
                            <span class="input-group-txt">
                            <button class="btn btn-info" id="created" type="submit">
                                Create
                            </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label id="demo1_label" style="display:none;">Enter No. of Question in Each CO: </label>
                    <table id="demo1" class="table table-bordered bg-light" >
                        
                    </table>
                    <span id="mark_check" class="text-center" > </span>
                    <button class="btn btn-info form-control" id="marked" type="submit" style="display:none;" disabled>
                        Marks 
                    </button>
                </div>
                <div class="form-group">
                    <label id="demo2_label" style="display:none;">Enter Max Marks of Each Question: </label>
                    <table id="demo2" class="table table-bordered bg-light" >

                    </table>
                    <button class="btn btn-primary form-control" id="submitted" style="display:none;" type="button" disabled>
                        Final Submit
                    </button>
                    <span id="final_submit"> </span>
                </div>
              <form>
          </div>
      </div>
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
            <form id="stud_form" method="POST">
              <div class="form-group">
                <input type="text" class="form-control" id="roll_no" name="rollNum" placeholder="Roll No.">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="stud_name" name="studName" placeholder="Name">
              </div>
              <button type="submit" id="stud_submit" name="stud_submit" class="btn btn-primary form-control">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- Navbar -->


    <nav class="navbar bg-info">
      <div class="container">
          <span class="navbar-text m-auto text-light">Hello, <b><?php echo $_SESSION["username"];  ?></b></span>
          <!-- Delete Model -->
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
        <button class="btn primary-danger" data-toggle="modal" data-target="#exampleModal1">Logout</button>
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

    // //validation so that other id cannot be accessed
    // $check = "SELECT * FROM sub_details where user_id = '$id'";
    // $result2 = mysqli_query($conn,$check) or die("Data Fetch Unsuccessfull");
    // $flag = 0;
    // while($row = mysqli_fetch_assoc($result2))
    // {
    //   if($sub_id == $row['id'])
    //   {
    //     $flag = 1;
    //   }
    // }
    // if($flag == 0)
    // {
    //   echo '<div class="alert alert-danger text-center" role="alert">
    //             Wrong Subject | Subject Doesnt exist !
    //          </div>';
    //   die();
    //   header("Location: http://localhost/college_project/error.php");
    // }
    
    //subject fetch if exist then only
    $data = "SELECT * FROM sub_details where user_id = '$id' AND id = '$sub_id'";
    $result1 = mysqli_query($conn,$data) or die("Data Fetch Unsuccessfull");
    if(mysqli_num_rows($result1) > 0)
    {
      $row = mysqli_fetch_assoc($result1);
      
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
            <?php
            $ct_details = "SELECT * FROM class_test INNER JOIN sub_details ON class_test.sub_id = sub_details.id WHERE sub_id = '$sub_id'";

            $ct_result = mysqli_query($conn,$ct_details) or die("Class Test Data Fetch Unsuccessfull");

            if(mysqli_num_rows($ct_result) > 0)
            {
              while($ct_data = mysqli_fetch_assoc($ct_result))
              {
            ?>
              <option><?php echo $ct_data['ct_num']; ?></option>
            <?php
              }
            }
            ?>
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
      <div class="autosave"></div>
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
            <th width = "128" > Student_ID </th> 
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
      <form id="marks_form" method="POST"> 
      </tr>
      </form>
      </tbody>
      <?php
        }
      }
      ?>
    </div>
    </table>

    <!-- <div class="breadcrumb">
      <div class="col text-center">
          <button type ="button" class="btn btn-dark form-control">
            UPDATE
          </button>
      </div>
      <div class="col text-center">
          <button type="button" class="btn btn-dark form-control">
            DELETE
          </button>
      </div>
      <div class="col text-center">
            <button id="main_final_submit" type="button" class="btn btn-dark form-control">
            FINAL SUBMIT
            </button>
      </div>
    </div> -->
        
        
        <table class="table table-striped table-bordered text-center table-sm mt-3">
          <tr class="bg-dark text-white">
              <th colspan="7" >Analysis</th>
          </tr>
          <tr>
            <td width="327"><input class="form-control"  value = "Marks more than 50% score" readonly></td>
            <td><input class="form-control" value = "2" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "4" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
          </tr>
          <tr>
            <td><input class="form-control" value = "Students Attempted" readonly></td>
            <td><input class="form-control" value = "2" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "4" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
          </tr>
          <tr>
            <td><input class="form-control" value = "Percentage" readonly></td>
            <td><input class="form-control" value = "2" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "4" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
          </tr>
          <tr>
            <td><input class="form-control" value = "Internal Assesment" readonly></td>
            <td><input class="form-control" value = "2" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "4" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
            <td><input class="form-control" value = "5" ></td>
          </tr>
      </table>

    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  </body>
<script>
function create()
{
    var j = 0;
    document.getElementById("created").disabled = true;
    document.getElementById("marked").disabled = false;
    document.getELementById("marked")
    document.getElementById("demo1_label").style.display = "block";
    j = j + 1;
    var a = document.getElementById("demo1");
    var no_co = document.getElementById("co_count").value;
    console.log(no_co);
    for(var i = 1; i<=no_co; i++)
    {
        var b = document.createElement("td");
        b.innerHTML = "<input type='text' class='form-control' name=co_"+ parseInt(i) + " placeholder='No. of Ques in: CO "+parseInt(i)+"' id=co_"+parseInt(i)+" required>"
        a.appendChild(b);
    }
     
}
function max_marks()
{
    document.getElementById("marked").disabled = true;
    
    document.getElementById("submitted").disabled = false;
    document.getElementById("demo2_label").style.display = "block";
    var num_of_co = document.getElementById("co_count").value;
    
    var total = 1;
    for(var i = 0; i<num_of_co; i++)
    {
      var data = document.getElementById("co_"+parseInt(i+1)).value;
      var d = document.getElementById("demo2");
      var e = document.createElement("tr");
      let ques_count = 1; 
      for(var j = 1; j<=data; j++)
      {
        var c = document.createElement("td");
        c.innerHTML = "<input type='text' class='form-control' name=ques_"+ total +" placeholder='Max Marks of Ques No."+ques_count+"' id='ques_"+ques_count+"'required>";
        e.appendChild(c);
        ques_count = ques_count + 1;
        total = total + 1;
      }
      d.appendChild(e);
    }
}
</script>

<script>
$(document).ready(function()
{   

    function autoSave()
    {
      $.ajax({
        url:"stud-marks-add.php",
        method:"POST",
        data: $("#marks_form").serialize(),
        dataType:"text",
        success:function(data)
        {
          $('#autosave').text("Marks get automatically updated after every 5 sec");
          setInterval(() => {
            $('autosave').text('');
          }, 2000);
        }
      }); 
    }
    setInterval(() => {
      autoSave();
    }, 5000);



    $("#stud_submit").click(function(e)
    {
        e.preventDefault();
        var val1 = $('#roll_no').val();
        var val2 = $('#stud_name').val();
        if(val1 != '' || val2 != '')
        { 
        $.ajax({
          url:"save-student-data.php",
          type:"POST",
          data: {roll_no:val1,stud_name:val2},
          success:function(data)
          {
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-center',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true
              })
              Toast.fire({
                icon: 'success',
                title: 'Student added successfully'
              }).then(function() {
                    location.reload();
              });
          },
          error:function(data)
          {
            alert(data);
          }
         });
        }
        else
        {
          Swal.fire({
          icon: 'warning',
          title: 'Invalid Input',
          text: 'Please fill all the detail!',
          });
        }
              
    });
    $("#created").click(function(e)
    {        
        e.preventDefault();
        $.ajax({
            url:"save-ct-data.php?id="+ <?php echo $sub_id; ?>+ "&ct_num=" + document.getElementById("ctNum").value,
            type:"POST",
            data: $('#submit_form').serialize(),
            success: function(data)
            {
                create();
                $("#availablity").html(data);
            },
            error: function(data)
            {
                $("#availablity").html('<span class="alert-danger"> CT already exist! </span>');
            }
        });

    });
    $("#marked").click(function(e)
    {
        e.preventDefault();
        $.ajax({
            url:"save-co-data.php?id=" + <?php echo $sub_id; ?> + "&ct_num=" + 
            document.getElementById("ctNum").value
            + "&co_num=" + document.getElementById("co_count").value,
            type:"POST",
            data: $('#submit_form').serialize(),
            success:function(data)
            {
                max_marks();
                $("#mark_check").html(data);
            }
            

        });
    });
    $("#submitted").click(function(e)
    {
        e.preventDefault();
        $.ajax({
            url:"final-add-ct.php?id="+ <?php echo $sub_id; ?> +"&ct_num="+document.getElementById("ctNum").value,
            type:"POST",
            data: $('#submit_form').serialize(),
            success:function(data)
            {
              Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: 'CT'+ data +' has been saved',
                    showConfirmButton: false,
                    timer: 1500
                  }).then(function() {
                    location.reload();
                });
            }

        });
    });
    $("#modal_close").click(function(e)
    {
      e.preventDefault();
      Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
      }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Your data has been deleted.',
                'success'
              )
            }
          })
    });
    // $("#main_final_submit").click(function()
    // {

    //   $.ajax({
    //   url:"stud-marks-add.php",
    //   type:"POST",
    //   data: $('#submit_form').serialize(),
    //   const Toast = S n({
    //           toast: true,
    //           position: 'top-right',
    //           showConfirmButton: false,
    //           timer: 1000,
    //           timerProgressBar: true
    //           })
    //           Toast.fire({
    //             icon: 'success',
    //             title: 'Student added successfully'
    //           }).then(function() {
    //                 location.reload();
    //           });
    // });
      
});

</script>
</html>