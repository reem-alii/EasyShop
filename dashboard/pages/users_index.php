<?php
session_start();
if(isset($_SESSION['admin_id'])){
include "init.php";
$stmt = $pdo->prepare('SELECT * FROM users');
$stmt->execute();
$users = $stmt->fetchAll();
$count = $stmt->rowCount();

// Delete User
$action = isset($_GET['action']) ? $_GET['action'] : NULL;
if($action == 'delete'){
    $id = isset($_GET['userid']) ? intval($_GET['userid']) : 0;
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: users_index.php');
    exit();
}
// Approve User
if($action == 'approve'){
    $id = isset($_GET['userid']) ? intval($_GET['userid']) : 0;
    $stmt = $pdo->prepare('UPDATE users SET reg_status = 1 WHERE id = ?');
    $stmt->execute(array($id));
    header('Location: users_index.php');
    exit();
}

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
            echo '<a href="users_index.php?action=approve&userid='.$user['id'].'" class="badge badge-pill badge-warning">Not Approved </a>';
        }
        echo '</td>';
        echo '<td>
              <a href="users_index.php?action=delete&userid='.$user['id'].'"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-xmark" style="color:black;"></i></a>
              <a href="users_edit.php?userid='.$user['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-pen" style="color:black;"></i></a>
              <a href="users_show.php?userid='.$user['id'].'"
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

<?php include "../includes/templates/footer.php";
}else{
  header('Location: index.php');
}
?>