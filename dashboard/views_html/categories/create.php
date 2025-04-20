<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/categories.php"); ?>

<div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <h1 class="text-center">Create Category</h1>
<form action="http://localhost/EasyShop/dashboard/views_html/categories/create.php?action=insert" method="POST">
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-8">
      <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Name" value="<?php if(isset($_POST['name'])) echo $_POST['name'] ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="parent" class="col-sm-2 col-form-label">Parent:</label>
        <div class="col-sm-8">
            <select name="parent_id" id="parent">
              <option value="0" selected>No parent/ Main Category</option>
              <?php 
                 $cats = getMainCats() ;
                 foreach ($cats as $cat) {
                    echo "<option value='".$cat['id']."'>".$cat['name']."</option>";
                 }
               ?>
            </select>
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
include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php");
