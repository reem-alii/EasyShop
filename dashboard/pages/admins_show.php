<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header('Location: http://localhost/EasyShop/dashboard/pages/index.php');
  exit;
}
include "init.php";
$row = $_SESSION['row'];

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
          <div class="user">
            <div class="card">
               <img src="https://img.freepik.com/premium-vector/user-icons-includes-user-icons-people-icons-symbols-premiumquality-graphic-design-elements_981536-526.jpg?semt=ais_hybrid" alt="Denim Jeans" style="width:100%">
               <h1><?php echo $row['first_name']. " " . $row['last_name']; ?></h1>
               <p class="price"><?php echo $row['email'] ?></p>
               <p class="buttons">
                  <a href="admins_index.php?action=delete&adminid=<?php echo $row['id']?>"
                  class="btn btn-secondary btn-sm confirm" data-inline="true">
                  <i class="fa-solid fa-user-xmark" style="color:black;"></i></a>
                  <a href="admins_edit.php?adminid=<?php echo $row['id']?>"
                  class="btn btn-secondary btn-sm" data-inline="true">
                  <i class="fa-solid fa-user-pen" style="color:black;"></i></a>
                  </p>
            </div> 
          </div>
    </div>
</div>


<?php
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/includes/templates/footer.php");
