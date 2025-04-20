<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/admins.php");?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Admins Table</h1>
            <a class="btn btn-outline-success" href="http://localhost/dashboard/views_html/admins/create.php">Create Admin <i class="fa-solid fa-user-plus"></i></a><br><br>
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
              <a href="http://localhost/dashboard/views_html/admins/index.php?action=delete&adminid='.$admin['id'].'"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-xmark" style="color:black;"></i></a>
              <a href="http://localhost/dashboard/views_html/admins/edit.php?action=edit&adminid='.$admin['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-pen" style="color:black;"></i></a>
              <a href="http://localhost/dashboard/views_html/admins/show.php?action=show&adminid='.$admin['id'].'"
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
include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php");

