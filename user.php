<?php
session_start();  ob_start();
include('constant.php');

if(!isset($_SESSION['user'])){
    header('location: login.php'); exit;
}
if($admin!=1){
    header('location: login.php'); exit;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sales Agents</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" >
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        a{text-decoration: none;}
    </style>
</head>
<body>
<?php include('nav2.php') ?>
<div class="container mt-4">
<div class="app-content-header"> <!--begin::Container-->   
<div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                        <div class="col-sm-6">
                        <h2 class="mb-0">Manage Sales Agents</h2>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Dashboard
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
</div> <!--end::Container-->
</div> <!--end::App Content Header--> <!--begin::App Content-->
    
<div class="row">
        
    </div>
    <div class="row">
        <div class="col-md-4">
<div class="card">
    <div class="card-header">
        <h6>Register New Agent</h6>
    </div>
    <div class="card-body">
        <form method="post">
      <div class="form-group">
<label for="">Name:</label>
<input type="text" class="form-control" name="name" placeholder="Enter name">
<label for="">Phone:</label>
<input type="number" class="form-control" name="phone" placeholder="Enter phone">
<label for="">Email:</label>
<input type="email" class="form-control" name="email" placeholder="Enter email">
<label for="">Password:</label>
<input type="password" class="form-control" name="password" placeholder="Enter password">
</div>
</div>
<div class="card-footer">
<div class="form-group">
    <div style="float:right">
    <button type="submit" class="btn btn-primary" name="RegisterUser">Register User</button>
    </div>
</div>
</form>
</div>
</div>
</div>

<div class="col-md-8">

<div class="card">
    <div class="card-header">
        <h6>Users</h6>
    </div>
    <div class="card-body">
       
        <table class="table">
            <tr>
                <th>SN</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Registered</th>
                <th>Action</th>
                <th>Admin</th>

            </tr>
            <?php 
            
        if (isset($_GET['sn'])){
            $sn = $_GET['sn'];

            if(isset($_GET['status'])){
                $status = $_GET['status'];
                $db->query("UPDATE user SET status='$status' WHERE sn='$sn'");
            }

            if(isset($_GET['set_admin'])){
                $db->query("UPDATE user SET admin=1 WHERE sn='$sn'");
            }

            if(isset($_GET['remove_admin'])){
                $db->query("UPDATE user SET admin=0 WHERE sn='$sn'");
            }
        }
        
            
             $sql = $db->query("SELECT * FROM user WHERE bid='$bid' ORDER BY sn DESC LIMIT 20");
while($row = mysqli_fetch_assoc($sql)){ $i =1 ;
    $status = $row['status'];
    $action = '';
 if($row['status']==1){
          $action = '<a href="?sn='.$row['sn'].'&status=0" class="btn btn-sm btn-danger">Deactivate</a>';    
    } else{
        $action = '<a href="?sn='.$row['sn'].'&status=1" class="btn btn-sm btn-success">Activate</a>'; }

    if($row['admin']==1){
        $adminaction = '<a href="?sn='.$row['sn'].'&remove_admin=1" class="btn btn-sm btn-danger">Remove</a>';    
  } else{
    $adminaction = '<a href="?sn='.$row['sn'].'&set_admin=1" class="btn btn-sm btn-success">Make Admin</a>'; }

?> 
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['phone'] ?></td>
                        <td><?= $row['email'] ?></td>
                    <td><?= substr($row['created'],0,10) ?></td>
                    <td><?= $action ?></td>
                    <td><?= $adminaction?></td>
                  
                    </tr>
     
                    <?php } ?>
        </table>
        
    </div>
    </div>
    <div class="card-footer"></div>
    </div>
</div>
    

<script src="js/bootstrap.bundle.min.js"></script> 
<?php include('footer.php') ?>
</body>
</html>