<?php
session_start();
if(isset($_SESSION['admin_id'])){
  include "init.php";
    
  $id = intval($_GET['prodid']);
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute(array($id));
  $row = $stmt->fetch();
  if($row){
    $cat = findCat($row['cat_id']);
    $sub = findCat($row['subcat_id']);
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="show">
               <div class="card">
                <!-- <img src="https://d2v5dzhdg4zhx3.cloudfront.net/web-assets/images/storypages/primary/ProductShowcasesampleimages/JPEG/Product+Showcase-1.jpg" alt="Denim Jeans" style="width:100%">
                -->
                <img src="<?php echo $row['Image'] ; ?>" alt="Denim Jeans" style="width:100%">
               
                </div> 
            </div>
        </div>
        <div class="col-md-6">
            <div class="show des">
               <div class="card">
                 <h1 class="text-center"><?php echo $row['name'] ; ?></h1>
                 <p class="price">$<?php echo $row['price'] ; ?></p>
                 <p><span>Description:</span> <?php echo $row['description'] ; ?></p>
                 <p><span>Category:</span> <?php echo $cat['name'] ; ?></p>
                 <p><span>Sub Cat.:</span> <?php echo $sub['name'] ; ?></p>
                 <p><span>Country:</span> <?php echo $row['country_made'] ; ?></p>
                 <p><span>Stock:</span> <?php echo $row['stock'] ; ?></p>
                 <p><span>Created at:</span> <?php echo $row['created_at'] ; ?></p>
               </div> 
                 <p class="text-center"><a href="products_index.php?action=delete&prodid=<?php echo $row['id'] ; ?>"
                     class="btn btn-secondary confirm" data-inline="true" style="background-color: #e83d2bc4;">
                     <i class="fa-solid fa-eraser" style="color:black;"></i></a>
                     <a href="products_edit.php?prodid=<?php echo $row['id'] ; ?>"
                     class="btn btn-secondary" data-inline="true" style="background-color: #0fbd0980;">
                     <i class="fa-solid fa-file-pen" style="color:black;"></i></a>
                 </p>
            </div>
        </div>
</div>


<?php include "../includes/templates/footer.php";
    }else{
      echo "Product not found";
    }
}else{
  header('Location: index.php');
}
