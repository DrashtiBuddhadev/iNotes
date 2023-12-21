<?php  
//INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'buy fruits', 'Hey abc,\r\nYou need to go to the market to buy some fruits.', current_timestamp());
$insert = false;
$update=false;
$delete=false;
// Connect to the Database 
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}

//exit();
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete=true;
  $sql="DELETE FROM `notes` WHERE `sno`=$sno";
  $result= mysqli_query($conn,$sql);
}
if($_SERVER['REQUEST_METHOD'] == 'POST' ){
  if(isset($_POST['snoEdit'])){
    //update the record
    $sno=$_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description=$_POST["descriptionEdit"];

    //sql query to be executed
    $sql="UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno;";
    $result= mysqli_query($conn, $sql);

    if($result){
      $uodate=true;
    }
  }
  else{
    $title = $_POST["title"];
    $description=$_POST["description"];

    //sql query to be executed
    $sql="INSERT INTO `notes` (`title`,`description`) VALUES ('$title','$description')";
    $result= mysqli_query($conn, $sql);

    if($result){
      // echo "The record has been inserted successfully!<br/>";
      $insert = true;
    }
    else{
        echo "The record was not inserted successfully because of this error --->" . mysqli_error($conn);
    }
}
}
// else{
//     echo"Connection was successful!";
// }

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">


</head>

<body>
  <!-- edit modal -->
  <!--
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button>
-->
<!--edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/inotes/iNotes/index.php" method="post">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="form-group">
            <label for="title" class="form-label">Note title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <label for="description" class="form-label">Note Description</label>
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
          </div>
          <br/>
          <button type="submit" class="btn btn-primary">update Note</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">contact-Us</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <?php 
    if($insert){
       echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>SUCCESS!</strong> The notes has been inserted successfully!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
  ?>
  <?php 
    if($update){
       echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>SUCCESS!</strong> The notes has been updated successfully!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
  ?>
  <?php 
    if($delete){
       echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>SUCCESS!</strong> The notes has been deleted successfully!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
  ?>
  <div class="container  my-4">
    <h2>Add a note</h2>
    <form action="/inotes/iNotes/index.php?" method="post">
      <div class="form-group">
        <label for="title" class="form-label">Note title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <br/>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
  <div class="container my-4">


    <table class="table" id="myTable" >
      <thead>
        <tr>
          <th scope="col">S.no</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
          $sql = "SELECT * FROM `notes`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
            <th scope='row'>". $sno ."</th>
            <td>".$row['title']."</td>
            <td>".$row['description']."</td>
            <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button>  <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button>
          </tr>";
            //echo $row['sno'] . ".title is " . $row['title'] . " and desc is " . $row['description'];
            //echo "<br/>";
            
            
          }
        ?>
      
      </tbody>
    </table>
  </div>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <!--
  <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        -->
  
  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
        $('#myTable').dataTable();
    });
  </script>
  <script>
      edit = document.getElementsByClassName('edit');
      Array.from(edit).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit", e.target.parentNode.parentNode);
          tr=e.target.parentNode.parentNode;
          title= tr.getElementsByTagName("td")[0].innerText;
          description= tr.getElementsByTagName("td")[1].innerText;
          console.log(title,description);
          titleEdit.value = title;
          descriptionEdit.value=description;
          snoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
          
        })
      })

      deletes = document.getElementsByClassName('delete'); 
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit", );
          sno=e.target.id.substr(1,);
          
          
          if(confirm("Are you sure you want to delte this note?")){
            console.log("yes");
            window.location = `/inotes/iNotes/index.php?delete=${sno}`;
          }
          else{
            console.log("no");
          }
        })
      })
  </script>   
  
</body>

</html>