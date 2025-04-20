<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/products.php"); ?>

<div class="container">
 <div class="row">
 <div class="col-md-8 create-prod">
      <h1 class="text-center">Edit Product</h1>
  <form action="http://localhost/EasyShop/dashboard/views_html/products/edit.php?action=update&prodid=<?php echo $row['id'] ;?>" method="POST" enctype="multipart/form-data">
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
include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php");
