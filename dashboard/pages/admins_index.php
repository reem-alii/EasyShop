<?php
session_start();
if(isset($_SESSION['admin_id'])){
include "init.php";
$stmt = $pdo->prepare('SELECT * FROM admins');
$stmt->execute();
$admins = $stmt->fetchAll();
$count = $stmt->rowCount();

// Delete Admin 
$action = isset($_GET['action']) ? $_GET['action'] : NULL;
if($action == 'delete'){
    $id = isset($_GET['adminid']) ? intval($_GET['adminid']) : 0;
    $stmt = $pdo->prepare('DELETE FROM admins WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: admins_index.php');
    exit();
}

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
              <a href="admins_index.php?action=delete&adminid='.$admin['id'].'"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-xmark" style="color:black;"></i></a>
              <a href="admins_edit.php?adminid='.$admin['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-pen" style="color:black;"></i></a>
              <a href="admins_show.php?adminid='.$admin['id'].'"
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