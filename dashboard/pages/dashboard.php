<?php 
session_start();
if(isset($_SESSION['admin_id'])){
include "init.php";
?>
    <div class="dashboard">
        <img src="../layouts/images/01186-RG.jpg" style="width: 1480px; height: 400px;">
         <!-- Statistics -->
    <div class="container home-stats text-center">
        <h1> Statistics </h1>
      <div class="row">
        <div class="col-md-4">
        <div class="card">
           <i class="fa-solid fa-users"></i>
             <div class="info">
               Total Users
             </div>
               <br><span><a href="users_index.php"><?php echo getTotalUsers() ?></a></span>
          </div>
        </div>
        <div class="col-md-4">
            <div class="card">
             <i class="fa-solid fa-tag"></i>
               <div class="info">
                 Total Products
                </div>
                 <br><span><a href="products_index.php"><?php echo getTotalProducts() ?></a></span>
             </div>
          </div>
        <div class="col-md-4">
           <div class="card">
            <i class="fa-solid fa-bag-shopping"></i>
              <div class="info">
                Total Orders
              </div>
                <br><span><a href="orders_index.php"><?php echo getTotalOrders() ; ?></a></span>
          </div>
        </div>
      </div>
    </div>
    <!-- /statistics -->

    </div>
<?php include "../includes/templates/footer.php"; 
}else{
  header("Location: index.php");
}
?>