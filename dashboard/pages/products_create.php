<?php
session_start();
if(isset($_SESSION['admin_id'])){
  include "init.php";
  error_reporting(E_ALL);
  ini_set('display_errors',1);
   if($_SERVER['REQUEST_METHOD']== 'POST'){
    $name = $_POST['name'];
    $des = $_POST['description'];
    $price = intval($_POST['price']);
    $image = $_FILES['image'];
    $cat = $_POST['cat_id'];
    $sub = $_POST['subcat_id'];
    $country = $_POST['country_made'];
    $quantity = $_POST['stock'];

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
    if (!is_numeric($quantity) || empty($quantity) || $quantity < 1) {
      $errors_array [] = "Invalid, Quantity is required and must be numeric and more than 1";
      $qerror = "Invalid, Quantity is required and must be numeric and more than 1";
    }
    //start image validation 
    if($image){
      $imgerror = "";
      $image_path = validateImage($image, $errors_array, $imgerror);
    }else{
      $errors_array [] = "image is required";
      $imgerror = "image is required";
    }
    if(empty($errors_array)) {
      $stmt = $pdo->prepare("INSERT INTO products(name, description, price, Image, country_made, stock, cat_id, subcat_id, created_at) 
      VALUES(:zname, :zdes, :zprice, :zimg, :zcountry, :zstock, :zcat, :zsub, :zcreated)");
      $stmt->execute(array(
        'zname'    => $name,
        'zdes'     => $des,
        'zprice'   => $price,
        'zimg'     => $image_path,
        'zcountry' => $country,
        'zstock'   => $quantity,
        'zcat'     => $cat,
        'zsub'     => $sub,
        'zcreated' => date("Y-m-d")
      ));
      $_POST = [];
      echo "<div class='alert alert-success'>Product added successfully</div>";
    }else{
       foreach($errors_array as $error){
           echo "<div class='alert alert-danger'>".$error."</div>";
       }
   }
   }
?>
<div class="container create-prod">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <h1 class="text-center">Create Product</h1>
<form action=<?php echo $_SERVER['PHP_SELF']?> method="POST" enctype="multipart/form-data">
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-8">
      <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Name" value="<?php if(isset($_POST['name'])) echo $_POST['name'] ; ?>">
      <div class="err" style="color:red;"><?php if(isset($nerror)) echo $nerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-8">
      <textarea name="description" class="form-control" id="inputEmail3"><?php if(isset($_POST['description'])) echo $_POST['description'] ; ?></textarea>
      <div class="err" style="color:red;"><?php if(isset($derror)) echo $derror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Price</label>
    <div class="col-sm-8">
      <input type="text" name="price" class="form-control" id="inputEmail3" placeholder="Price in numbers" value="<?php if(isset($_POST['price'])) echo $_POST['price'] ;?>">
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
                    echo "<option class='prodcat' onclick=\"filterSelection('".$cat['id']."')\" value='".$cat['id']."'>".$cat['name']."</option>";
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
                    echo "<option  class='filterDiv ".$sub['parent_id']."' value='".$sub['id']."'>".$sub['name']."</option>";
                 }
               ?>
               </div>
            </select>
    </div>
  </div> 
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Made in</label>
    <div class="col-sm-8">
      <input type="text" name="country_made" class="form-control" id="inputEmail3" placeholder="Made in " value="<?php if(isset($_POST['country_made'])) echo $_POST['country_made'] ; ?>">
      <div class="err" style="color:red;"><?php if(isset($cerror)) echo $cerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Quantity</label>
    <div class="col-sm-8">
      <input type="number" name="stock" class="form-control" id="inputEmail3" value="<?php if(isset($_POST['stock'])) echo $_POST['stock'] ;?>">
      <div class="err" style="color:red;"><?php if(isset($qerror)) echo $qerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="image" class="col-sm-2 col-form-label">Select image to upload:</label>
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
</div>
</div>
<?php 
include "../includes/templates/footer.php"; 
}else{
  header("Location: index.php");
}
?>
