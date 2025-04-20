<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/categories.php"); ?>

<div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <h1 class="text-center">Edit Category</h1>
<form action="http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/categories/edit.php?action=update&catid=<?php echo $row['id'] ;?>" method="POST">
  <div class="form-group row">
    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-8">
      <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Name" value="<?php echo $row['name']; ?>">
      <div class="err" style="color:red;"><?php if(isset($nerror)) echo $nerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="parent" class="col-sm-2 col-form-label">Parent:</label>
        <div class="col-sm-8">
            <select name="parent_id" id="parent">
              <option value="0" <?php echo $row['parent_id'] == 0 ? "selected" : ""  ;?> >No parent/ Main Category</option>
              <?php 
                 $cats = getMainCats() ;
                 foreach ($cats as $cat) {
                    echo "<option value='".$cat['id']."'
                    " . ($cat['id'] == $row['parent_id'] ? "selected" : "") . " >" . $cat['name']."</option>";
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
