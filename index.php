<?php
  // INSERT INTO `notes` (`sr_no`, `title`, `description`, `tstamp`) VALUES ('', 'hello there', 'I am shubhangi from ty cse', current_timestamp());
    //connecting to database..
      $servername="localhost";
      $username="root";
      $password="";
      $database="crud";
      $insert=FALSE;
      $update=FALSE;
      $delete=FALSE;
      $con=mysqli_connect($servername,$username,$password,$database);

      if(!$con){
          die("connection failed --> " . mysqli_connect_error());
      }

      if(isset($_GET['delete'])){
        $sr_noDel=$_GET['delete'];
        $sql="DELETE FROM `notes` WHERE `sr_no`='$sr_noDel'";
        $result=mysqli_query($con,$sql);
        if($result){
          $delete=TRUE;
        }
      }

      if($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_POST['snoEdit'])){
          $sr_noEdit=$_POST['snoEdit'];
          $title=$_POST["titleEdit"];
          $desc=$_POST['descriptionEdit'];

          $sql="UPDATE `notes` SET `title`='$title' , `description`='$desc' WHERE `notes`.`sr_no`='$sr_noEdit'";
          $result=mysqli_query($con,$sql);

          if($result){
            $update=TRUE;
          }
        }
        else{

          $title=$_POST["title"];
          $desc=$_POST['discription'];
  
          $sql="INSERT INTO `notes` (`title`, `description`) VALUES ('$title','$desc');";
          $result=mysqli_query($con,$sql);
  
          if($result){
  
            $insert=TRUE;
          }
      

        }

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
      <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <title>Welcome to my_note</title>

    
  </head>
  <body>

      <!-- Modal -->
      <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editmodalLabel">Edit Note</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <form action='/crud/index.php' method="POST">
            <div class="modal-body">
            <input type="hidden" name=snoEdit id=snoEdit>
            <div class="form-group">
                <label for="titleEdit">Note Title </label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit">
            </div>
            <div class="form-group">
                <label for="descriptionEdit">Note Description</label>
                <textarea class="form-control" id="descriptionEdit" name='descriptionEdit'></textarea>
            </div>
            
          </div>
            <div class="modal-footer d-block">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
          </div>
        </div>
      </div>


   <!-- navbar start -->

   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"><img src="/crud/logo.png" height="28px" alt=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact Us</a>
      </li>
      
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

   <!-- navbar end -->

   <?php
   
      if($insert){
        echo "<div class='alert alert-success' role='alert'>
        <b>success!</b> your note inserted successfully 
      </div>";
      }

      if($update){
        echo "<div class='alert alert-success' role='alert'>
        <b>success!</b> your note Updated successfully 
      </div>";
      }

      if($delete){
        echo "<div class='alert alert-success' role='alert'>
        <b>success!</b> your note Deleted successfully 
      </div>";
      }
    // else{
    //   echo "<div class='alert alert-danger' role='alert'>
    //   <b>success!</b> sorry something went wrong!! 
    // </div>";
    // }

   ?>

   <div class="container col-md-8 my-4">
        <h4>Add a note to iNote app </h4>
        <form action='/crud/index.php' method="POST">
        <div class="form-group">
            <label for="title">Note Title </label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="discription">Note Description</label>
            <textarea class="form-control" id="description" name='discription'></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Note</button>
        </form>

   </div>

   <div class="container col-md-8">

<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">sr. no.</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
     $sql="SELECT * FROM `notes`";
     $result=mysqli_query($con,$sql);
  

  $sr_no=0;
     while($row=mysqli_fetch_assoc($result)){
      $sr_no+=1;
      echo "<tr>
      <th scope='row'>" . $sr_no . "</th>
      <td>" . $row['title'] . "</td>
      <td>" . $row['description'] . "</td>
      <td><button class='edit btn btn-sm btn-primary' id=".$row['sr_no'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sr_no'].">Delete</button></td>
    </tr>";
  }
   ?>
   
  </tbody>
</table>
   </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <Script>
        $(document).ready( function () {
        $('#myTable').DataTable();
    } );
    </Script>
    <script>
      edits=document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          tr=e.target.parentNode.parentNode;
          //console.log("edit ",e.target.parentNode.parentNode);
          title=tr.getElementsByTagName('td')[0].innerText;
          description=tr.getElementsByTagName('td')[1].innerText;
          console.log(title,description)
          titleEdit.value = title;
          descriptionEdit.value = description;
          snoEdit.value=e.target.id;
          console.log(e.target.id)
          $('#editmodal').modal('toggle');
        })
      })


      deletes=document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          tr=e.target.parentNode.parentNode;
          
          sno=e.target.id.substr(1,);
          console.log(e.target.id.substr(1,))
          if(confirm("Are you sure to delete this note ??")){
            console.log("yes");
            window.location=`/crud/index.php?delete=${sno}`;
          }
          else{
            console.log("no");
          }
        })
      })
    </script>
  </body>
</html>