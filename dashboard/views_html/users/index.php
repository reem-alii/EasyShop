<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/users.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Users Table</h1>
            <a class="btn btn-outline-success" href="http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/users/create.php">Create User <i class="fa-solid fa-user-plus"></i></a><br><br>
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
            echo '<a href="http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/users/index.php?action=approve&userid='.$user['id'].'" class="badge badge-pill badge-warning">Not Approved </a>';
        }
        echo '</td>';
        echo '<td>
              <a href="http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/users/index.php?action=delete&userid='.$user['id'].'"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-xmark" style="color:black;"></i></a>
              <a href="http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/users/edit.php?action=edit&userid='.$user['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-user-pen" style="color:black;"></i></a>
              <a href="http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/users/show.php?action=show&userid='.$user['id'].'"
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

<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php"); ?>