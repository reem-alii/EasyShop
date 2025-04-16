<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header('Location: http://localhost/EasyShop/dashboard/pages/index.php');
  exit;
}
include "init.php";
$users = getAllRows('users');
if(isset($_SESSION['success'])){ echo $_SESSION['success'] ; unset($_SESSION['success']);}

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Users Table</h1>
            <a class="btn btn-outline-success" href="users_create.php">Create User <i class="fa-solid fa-user-plus"></i></a><br><br>
<table class="table" style="background-color:#7d9a741f">
  <thead>
    <tr>
      <th>id</th>
      <th>Name</th>
      <th>Email</th>
      <th>Reg. Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($users as $user) {
        echo '<tr>';
        echo '<td>'.$user['id'].'</td>';
        echo '<td>'.$user['first_name']. ' '.$user['last_name'].'</td>';
        echo '<td>'.$user['email'].'</td>';
        echo '<td>';
        if ($user['reg_status'] == 1 ){
          echo '<span class="badge badge-pill badge-success">Approved</span>';
        }else {
            echo '<a href="http://localhost/EasyShop/dashboard/controllers/UserController.php?action=approve&userid='.$user['id'].'" class="badge badge-pill badge-warning">Not Approved </a>';
        }
        echo '</td>';
        echo '<td>
              <a href="http://localhost/EasyShop/dashboard/controllers/UserController.php?action=delete&userid='.$user['id'].'"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-xmark" style="color:black;"></i></a>
              <a href="http://localhost/EasyShop/dashboard/controllers/UserController.php?action=edit&userid='.$user['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-pen" style="color:black;"></i></a>
              <a href="http://localhost/EasyShop/dashboard/controllers/UserController.php?action=show&userid='.$user['id'].'"
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
?>