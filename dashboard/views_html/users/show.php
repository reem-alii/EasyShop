<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/users.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
          <div class="user">
            <div class="card">
               <img src="<?php echo $src ; ?>" alt="Denim Jeans" style="width:100%">
               <h1><?php echo $row['first_name']. " " . $row['last_name']; ?></h1>
               <p class="price"><?php echo $row['email'] ?></p>
               <p><?php echo $stat ; ?></p>
               <p class="buttons">
                  <a href="http://localhost/dashboard/views_html/users/index.php?action=delete&userid=<?php echo intval($row['id'])?>"
                  class="btn btn-secondary btn-sm confirm" data-inline="true">
                  <i class="fa-solid fa-user-xmark" style="color:black;"></i></a>
                  <a href="http://localhost/dashboard/views_html/users/edit.php?action=edit&userid=<?php echo intval($row['id'])?>"
                  class="btn btn-secondary btn-sm" data-inline="true">
                  <i class="fa-solid fa-user-pen" style="color:black;"></i></a>
                  </p>
            </div> 
          </div>
    </div>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php");
