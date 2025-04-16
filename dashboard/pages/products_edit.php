<?php
session_start();
if(isset($_SESSION['admin_id'])){
  include "init.php";
  error_reporting(E_ALL);
  ini_set('display_errors',1);
   if($_SERVER['REQUEST_METHOD']== 'POST'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $des = $_POST['description'];
    $price = intval($_POST['price']);
    $image = $_FILES['image'];
    $cat = $_POST['cat_id'];
    $sub = $_POST['subcat_id'];
    $country = $_POST['country_made'];
    $stock = $_POST['stock'];

    //validation 
    $errors_array = [];
    if (strlen($name) < 3 || strlen($name) > 20){
      $errors_array [] = "name must be between 3 and 20 characters";
      $nerror =  "name must be between 3 and 20 characters";
    }
    if (strlen($des) < 3 ){
        $errors_array [] = "name must be more than 3 characters";
        $derror =  "name must be more than 3 characters";
    }
    if (!is_numeric($price) || empty($price)) {
      $errors_array [] = "Invalid, Price is required and must be numeric";
      $perror = "Invalid, Price is required and must be numeric";
    }
    if(empty($country)){
        $errors_array [] = "country is required";
        $cerror =  "country is required";
    }
    if (!is_numeric($stock) || is_null($stock)) {
      $errors_array [] = "Invalid, Stock is required and must be numeric";
      $serror = "Invalid, Stock is required and must be numeric";
    }
    //start image validation 
    $imgerror = "";
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
      $image_path = validateImage($image, $errors_array, $imgerror);
    }
    if (empty($errors_array) && isset($image_path)) {
      $stmt = $pdo->prepare("UPDATE products SET name = :zname, description = :zdes, price = :zprice, Image = :zimg, country_made = :zcountry, stock = :zstock, cat_id = :zcat, subcat_id = :zsub 
      WHERE id = $id");
      $stmt->execute(array(
        'zname'    => $name,
        'zdes'     => $des,
        'zprice'   => $price,
        'zimg'     => $image_path,
        'zcountry' => $country,
        'zstock'   => $stock,
        'zcat'     => $cat,
        'zsub'     => $sub
      ));
      $_POST = [];
      echo "<div class='alert alert-success'>Product Updated successfully</div>";
    }elseif(empty($errors_array)){
    $stmt = $pdo->prepare("UPDATE products SET name = :zname, description = :zdes, price = :zprice, country_made = :zcountry, stock = :zstock, cat_id = :zcat, subcat_id = :zsub 
      WHERE id = $id");
      $stmt->execute(array(
        'zname'    => $name,
        'zdes'     => $des,
        'zprice'   => $price,
        'zcountry' => $country,
        'zstock'   => $stock,
        'zcat'     => $cat,
        'zsub'     => $sub
      ));
      $_POST = [];
      echo "<div class='alert alert-success'>Product Updated successfully</div>";
    }
   }
   if($_SERVER['REQUEST_METHOD']== 'GET' || $_SERVER['REQUEST_METHOD']== 'POST'){
    $id = $_GET['prodid'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
   }

?>
<div class="container">
 <div class="row">
 <div class="col-md-8 create-prod">
      <h1 class="text-center">Edit Product</h1>
  <form action="products_edit.php?prodid=<?php echo $row['id'] ;?>" method="POST" enctype="multipart/form-data">
  <div class="form-group row">
    <input type="hidden" name="id" value="<?php echo $row['id'] ;?>">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-8">
      <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Name" value="<?php echo $row['name'] ;?>">
      <div class="err" style="color:red;"><?php if(isset($nerror)) echo $nerror ;?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-8">
      <textarea name="description" class="form-control" id="inputEmail3"><?php echo $row['description'] ;?></textarea>
      <div class="err" style="color:red;"><?php if(isset($derror)) echo $derror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Price</label>
    <div class="col-sm-8">
      <input type="text" name="price" class="form-control" id="inputEmail3" placeholder="Price in numbers" value="<?php echo $row['price'] ;?>">
      <div class="err" style="color:red;"><?php if(isset($perror)) echo $perror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="cat" class="col-sm-2 col-form-label">Category:</label>
        <div class="col-sm-8">
            <select name="cat_id" id="cat">
              <?php 
                 $cats = getMainCats() ;
                 foreach ($cats as $cat) {
                    echo "<option class='prodcat' onclick=\"filterSelection('".$cat['id']."')\" value='".$cat['id']."'" ;
                    echo $cat['id'] == $row['cat_id'] ? "selected" : "";
                    echo ">".$cat['name']."</option>";
                 }
               ?>
            </select>
    </div>
  </div>
  <div class="form-group row">
    <label for="subcat" class="col-sm-2 col-form-label">Sub Cat.:</label>
        <div class="col-sm-8">
            <select name="subcat_id" id="subcat">
                <div class="prodsubcats">
              <?php 
                 $subcats = allSubCats();
                 foreach ($subcats as $sub) {
                    echo "<option  class='filterDiv ".$sub['parent_id']."' value='".$sub['id']."'";
                    echo $sub['id'] == $row['subcat_id'] ? "selected" : "";
                    echo ">".$sub['name']."</option>";
                 }
               ?>
               </div>
            </select>
    </div>
  </div> 
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Made in</label>
    <div class="col-sm-8">
      <input type="text" name="country_made" class="form-control" id="inputEmail3" placeholder="Made in " value="<?php echo $row['country_made'] ;?>">
      <div class="err" style="color:red;"><?php if(isset($cerror)) echo $cerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Stock</label>
    <div class="col-sm-8">
      <input type="number" name="stock" class="form-control" id="inputEmail3" value="<?php echo $row['stock'] ;?>">
      <div class="err" style="color:red;"><?php if(isset($serror)) echo $serror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="image" class="col-sm-2 col-form-label">Select image to upload(optional):</label>
     <div class="col-sm-8">
       <input type="file" name="image" id="image">
       <div class="err" style="color:red;"><?php if(isset($imgerror)) echo $imgerror ; ?></div>
     </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10 text-center">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
  </div>
   </form>
  </div>
  <div class="col-md-3">
                <!-- <img src="https://d2v5dzhdg4zhx3.cloudfront.net/web-assets/images/storypages/primary/ProductShowcasesampleimages/JPEG/Product+Showcase-1.jpg" alt="Denim Jeans" style="width:100%">
                -->
                <img src="<?php echo $row['Image'] ; ?>" alt="Denim Jeans" style="width: 160%; padding: 5px; margin: 10px;">  
               
  </div> 
 </div>
</div>
<?php 
include "../includes/templates/footer.php"; 
}else{
  header("Location: index.php");
}
?>