<?php
session_start();
if(isset($_SESSION['admin_id'])){
  include "init.php";
  if($_SERVER['REQUEST_METHOD']== 'POST'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $parent_id = $_POST['parent_id'];
     
    //validation 
    $errors_array = [];
    if (strlen($name) < 3 || strlen($name) > 20){
      $errors_array [] = "name must be between 3 and 20 characters";
      $nerror =  "name must be between 3 and 20 characters";
    }
    if (!is_numeric($parent_id)) {
      $errors_array [] = "Invalid category";
      $perror =  "Invalid category";
    }
    $name_unique = uniqueValue('categories', 'name', $name, $id);
    if($name_unique > 0){
      $errors_array [] = "name must be unique";
      $nerror =  "name must be unique";
    }
    if (empty($errors_array)) {
      $stmt = $pdo->prepare("UPDATE categories SET name = :zname, parent_id = :zparent
                             WHERE id = $id");
      $stmt->execute(array(
        'zname' => $name,
        'zparent' => $parent_id
      ));
      $_POST = [];
      echo "<div class='alert alert-success'>Category Updated successfully</div>";
    }
   
 }   
   if($_SERVER['REQUEST_METHOD']== 'GET' || $_SERVER['REQUEST_METHOD']== 'POST'){
    $id = $_GET['catid'];
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
   }


?>
<div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <h1 class="text-center">Edit Category</h1>
<form action="categories_edit.php?catid=<?php echo $row['id'] ;?>" method="POST">
  <div class="form-group row">
    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-8">
      <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Name" value="<?php echo $row['name']; ?>">
      <div class="err" style="color:red;"><?php echo $nerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="parent" class="col-sm-2 col-form-label">Parent:</label>
        <div class="col-sm-8">
            <select name="parent_id" id="parent">
              <option value="0" <?php echo $row['parent_id'] == 0 ? "selected" : ""  ;?> >No parent/ Main Category</option>
              <?php 
                 $cats = getCats() ;
                 foreach ($cats as $cat) {
                    echo "<option value='".$cat['id']."'
                    " . ($cat['id'] == $row['parent_id'] ? "selected" : "") . " >" . $cat['name']."</option>";
                 }
               ?>
            </select>
      <div class="err" style="color:red;"><?php echo $eerror ; ?></div>
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