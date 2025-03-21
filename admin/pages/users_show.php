<?php
session_start();
if(isset($_SESSION['admin_id'])){
  include "init.php";
    
  $id = intval($_GET['userid']);
  $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->execute(array($id));
  $row = $stmt->fetch();
  if($row){
    $stat = $row['reg_status'] ? '<span class="badge badge-pill badge-success">Approved</span>' : '<span class="badge badge-pill badge-warning">Not Approved </span>';
    $src = $row['Image'] ? $row['Image'] : "https://img.freepik.com/premium-vector/user-icons-includes-user-icons-people-icons-symbols-premiumquality-graphic-design-elements_981536-526.jpg?semt=ais_hybrid" ;
?>
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
                  <a href="users_index.php?action=delete&userid=<?php echo $row['id']?>"
                  class="btn btn-secondary btn-sm confirm" data-inline="true">
                  <i class="fa-solid fa-user-xmark" style="color:black;"></i></a>
                  <a href="users_edit.php?userid=<?php echo $row['id']?>"
                  class="btn btn-secondary btn-sm" data-inline="true">
                  <i class="fa-solid fa-user-pen" style="color:black;"></i></a>
                  </p>
            </div> 
          </div>
    </div>
</div>


<?php include "../includes/templates/footer.php";
    }else{
      echo "User not found";
    }
}else{
  header('Location: index.php');
}
