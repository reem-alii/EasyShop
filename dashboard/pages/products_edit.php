<?php
session_start();
if(isset($_SESSION['admin_id'])){
  include "init.php";
  //error_reporting(E_ALL);
  //ini_set('display_errors',1);
   if($_SERVER['REQUEST_METHOD']== 'POST'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $des = $_POST['description'];
    $price = intval($_POST['price']);
    $image = $_FILES['image'];
    $cat = $_POST['cat_id'];
    echo $cat ;
    //$sub = $_POST['subcat_id'];
    $country = $_POST['country_made'];

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
    //start image validation 
    $imgerror = "";
    if($image){
      if ($image["size"] > 400000) {
        $errors_array [] = "image size must be less than 400 KB";
        $imgerror .= "image size is too large/";
      }
      $image_path = "../../public/images/" . basename($image["name"]);
      $imgtype =  strtolower(pathinfo($image_path,PATHINFO_EXTENSION));
      if (!in_array($imgtype, ['jpg', 'png', 'jpeg'])){
        $errors_array [] = "image must be in jpg, png or jpeg format";
        $imgerror .= "Invalid, only JPG, JPEG, PNG files are allowed/";
      }
      if (file_exists($image_path)) {
        $errors_array [] = "image already exists, change image name";
        $imgerror .= "image already exists, change image name/";
      }
      if(!move_uploaded_file($image["tmp_name"], $image_path)){
        $errors_array [] = "image failed to upload";
        $imgerror .= "image failed to upload/" . $image['error'];
      }
    }
    if (empty($errors_array) && $image) {
      $stmt = $pdo->prepare("UPDATE products SET name = :zname, description = :zdes, price = :zprice, Image = :zimg, country_made = :zcountry, cat_id = :zcat 
      WHERE id = $id");
      $stmt->execute(array(
        'zname'    => $name,
        'zdes'     => $des,
        'zprice'   => $price,
        'zimg'     => $image_path,
        'zcat'     => $cat,
        'zcountry' => $country,
      ));
      $_POST = [];
      echo "<div class='alert alert-success'>Product Updated successfully</div>";
    }else{
    $stmt = $pdo->prepare("UPDATE products SET name = :zname, description = :zdes, price = :zprice, country_made = :zcountry, cat_id = :zcat 
      WHERE id = $id");
      $stmt->execute(array(
        'zname'    => $name,
        'zdes'     => $des,
        'zprice'   => $price,
        'zcountry' => $country,
        'zcat'     => $cat,
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
 <div class="col-md-8">
      <h1 class="text-center">Edit Product</h1>
  <form action="products_edit.php?prodid=<?php echo $row['id'] ;?>" method="POST" enctype="multipart/form-data">
  <div class="form-group row">
    <input type="hidden" name="id" value="<?php echo $row['id'] ;?>">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-8">
      <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Name" value="<?php echo $row['name'] ;?>">
      <div class="err" style="color:red;"><?php echo $nerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-8">
      <textarea name="description" class="form-control" id="inputEmail3"><?php echo $row['description'] ;?></textarea>
      <div class="err" style="color:red;"><?php echo $derror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Price</label>
    <div class="col-sm-8">
      <input type="text" name="price" class="form-control" id="inputEmail3" placeholder="Price in numbers" value="<?php echo $row['price'] ;?>">
      <div class="err" style="color:red;"><?php echo $perror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="cat" class="col-sm-2 col-form-label">Category:</label>
        <div class="col-sm-8">
            <select name="cat_id" id="cat">
              <?php 
                 $cats = getCats() ;
                 foreach ($cats as $cat) {
                    echo "<option class='prodcat' value='".$cat['id']."'" ;
                    echo $cat['id'] == $row['cat_id'] ? "selected" : "";
                    echo ">".$cat['name']."</option>";
                 }
               ?>
            </select>
    </div>
  </div>
  <!--<div class="form-group row">
    <label for="subcat" class="col-sm-2 col-form-label">Sub Cat.(optional):</label>
        <div class="col-sm-8">
            <select name="subcat_id" id="subcat">
                <div class="prodsubcats">
              <?php 
                 foreach ($data as $subcat) {
                    echo "<option  value='".$subcat['id']."'>".$subcat['name']."</option>";
                 }
               ?>
               </div>
            </select>
    </div>
  </div> -->
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Made in</label>
    <div class="col-sm-8">
      <input type="text" name="country_made" class="form-control" id="inputEmail3" placeholder="Made in " value="<?php echo $row['country_made'] ;?>">
      <div class="err" style="color:red;"><?php echo $cerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="image" class="col-sm-2 col-form-label">Select image to upload(optional):</label>
     <div class="col-sm-8">
       <input type="file" name="image" id="image">
       <div class="err" style="color:red;"><?php echo $imgerror ; ?></div>
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