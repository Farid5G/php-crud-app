<?php
require 'components/dbconnection.php';
$insert = false;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $title =  str_replace("'","\'",$title);
    $desc =  str_replace("'","\'",$desc);
    // echo $desc;
    $sql = "INSERT INTO `notes`( ntitle, ndesc, stime) VALUES ('$title','$desc',current_timestamp())";
    $result = mysqli_query($conn, $sql);
    if($result){
        $insert = true;
        // echo "successfully inserted";
    }
    }
    mysqli_close($conn);
}
?>
<?php
require 'components/dbconnection.php';
$editor = false;
if(isset($_GET['title'])){
$title = $_GET['title'];
$title = str_replace("'","\'",$title);
// echo $title;
$sql = "SELECT * FROM notes WHERE ntitle = '$title'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
  if($row > 0 ){
   $editor = true;
   $ntitle = $row['ntitle'];
  //  echo $ntitle;
  $description  = $row['ndesc'];
  // echo $description;

  }
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mnotes - Make notes without remembering it</title>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <!-- Include Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Include DataTables CSS -->
  <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

</head>
<link rel="stylesheet" href="style.css">
<body>

<?php
  require 'components/navbar.php';
  if($insert){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> The Notes Has been saved successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
  }
?>
<?php
$isDel = false;
require 'components/dbconnection.php';
if(isset($_GET['Sno'])){
$title = $_GET['Sno'];
$query = "DELETE FROM notes WHERE sno = '$title'";
$result = mysqli_query($conn,$query);
if($result){ 
  $isDel = true;
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Danger!</strong> The Notes Has been Deleted.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
}
?>
<?php 
require 'components/dbconnection.php';
if(isset($_POST['save'])){
  $ntitle = $_POST['title'];
  $description = $_POST['desc'];
  $ntitle =  str_replace("'","\'",$ntitle);
  $description =  str_replace("'","\'",$description);
  $query = "UPDATE notes SET ndesc = '$description'  WHERE ntitle = '$ntitle'";
  $res = mysqli_query($conn,$query);
  if(!$res){
   die(' Error:' . mysqli_connect_error());
  }
  else{
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> The Notes Has been Edited successfully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
}
?>
<?php

if(!$editor){
echo '<div class="container">
<div class="my-4 row d-flex justify-content-center bg-success">
<div class="col-md-5 align-items-center">
<form action = "index.php" method = "post">
<div class="mb-3 ">
<label for="exampleFormControlInput1" class="form-label">Notes Title</label>
<input type="text" name ="title" class="form-control" id="exampleFormControlInput1" placeholder="title">
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Notes Description</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name = "desc"></textarea>
</div>
<button type="submit" name= "submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
</div>';
}
elseif($editor){
  // echo $ntitle;
  // echo $description;
  echo '<div class="container">
<div class="my-4 row d-flex justify-content-center bg-success">
<div class="col-md-5 align-items-center">
<form action="index.php" method = "post">
<div class="mb-3 ">
<label for="exampleFormControlInput1" class="form-label">Notes Title
<small>.....(You Cannot Change the title)</small></label>
<input type="text" name ="title" class="form-control" id="exampleFormControlInput1" value = "' . $ntitle . '">
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Notes Description</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name = "desc"  >' . $description .'</textarea>
</div>

<button type="submit" name= "save" class="btn btn-primary">Save changes</button>
</form>
</div>
</div>
</div>';
}
elseif($isDel){
  echo '<div class="container">
  <div class="my-4 row d-flex justify-content-center bg-success">
  <div class="col-md-5 align-items-center">
  <form action="index.php" method = "post">
  <div class="mb-3 ">
  <label for="exampleFormControlInput1" class="form-label">Notes Title
  <small>.....(You Cannot Change the title)</small></label>
  <input type="text" name ="title" class="form-control" id="exampleFormControlInput1" value = "' . $ntitle . '">
  </div>
  <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Notes Description</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name = "desc"  >' . $description .'</textarea>
  </div>
  
  <button type="submit" name= "save" class="btn btn-primary">Confirm Delete</button>
  </form>
  </div>
  </div>
  </div>';
}

?>
<div class="container">
<table class="table" id = "exampleTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Sno</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">ToDo</th>
      <th scope="col">Done</th>
    </tr>
  </thead>
  <tbody>
    <?php
    require 'components/dbconnection.php';
    $sql = "SELECT * FROM `notes`";
    $result = mysqli_query($conn,$sql);
    $sno = 0;
    while($row = mysqli_fetch_assoc($result)){
      $sno++;
      echo "<tr>
      <th scope='row'>".$sno."</th>
      <td>".$row['ntitle']."</td>
      <td>".$row['ndesc']."</td>";
      echo "<td><a class = 'button' href = 'index.php?title=" . $row['ntitle'] . "' 
      >Edit</a></td>
      <td><a class = 'btnn' href = 'index.php?Sno=" . $row['sno'] . "' 
      >delete</a></td>
    </tr>";
    }
    mysqli_close($conn);

    ?>
  </tbody>
</table>
</div>

<!-- Add Bootstrap 5 JS and Popper.js links -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<!-- Include Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

  <!-- Include DataTables JavaScript -->
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

  <!-- DataTables Initialization -->
  <script>
      jQuery(document).ready(function() {
      jQuery('#exampleTable').DataTable();
    });

  </script>

</body>
</html>
