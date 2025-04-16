<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header('Location: http://localhost/EasyShop/dashboard/pages/index.php');
  exit;
}
include "init.php";
$admins = getAllRows('admins');
if(isset($_SESSION['success'])){ echo $_SESSION['success'] ; unset($_SESSION['success']);}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Admins Table</h1>
            <a class="btn btn-outline-success" href="admins_create.php">Create Admin <i class="fa-solid fa-user-plus"></i></a><br><br>
<table class="table" style="background-color:#7d9a741f">
  <thead>
    <tr>
      <th>id</th>
      <th>Name</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($admins as $admin) {
        echo '<tr>';
        echo '<td>'.$admin['id'].'</td>';
        echo '<td>'.$admin['first_name']. ' '.$admin['last_name'].'</td>';
        echo '<td>'.$admin['email'].'</td>';
        echo '<td>
              <a href="http://localhost/EasyShop/dashboard/controllers/AdminController.php?action=delete&adminid='.$admin['id'].'"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-xmark" style="color:black;"></i></a>
              <a href="http://localhost/EasyShop/dashboard/controllers/AdminController.php?action=edit&adminid='.$admin['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-pen" style="color:black;"></i></a>
              <a href="http://localhost/EasyShop/dashboard/controllers/AdminController.php?action=show&adminid='.$admin['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-arrow-up-right-from-square" style="color:black;"></i></a>
        
        </td>';
      }
    ?>
  </tbody>
</table>
</div>
</div>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/includes/templates/footer.php");

