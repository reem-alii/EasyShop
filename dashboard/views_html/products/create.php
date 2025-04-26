<?php include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/php_scripts/products.php"); ?>

<div class="container create-prod">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <h1 class="text-center">Create Product</h1>
<form action="http://<?= $_SERVER ['HTTP_HOST'] ?>/EasyShop/dashboard/views_html/products/create.php?action=insert" method="POST" enctype="multipart/form-data">
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
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/includes/templates/footer.php");
