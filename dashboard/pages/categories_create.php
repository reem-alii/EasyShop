<?php
session_start();
if(isset($_SESSION['admin_id'])){
  include "init.php";
   if($_SERVER['REQUEST_METHOD']== 'POST'){
    $name = $_POST['name'];
    $parent_id = intval($_POST['parent_id']);

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
    $name_unique = uniqueValue('categories','name', $name);
    if($name_unique > 0){
      $errors_array [] = "name must be unique";
      $nerror =  "name must be unique";
    }
    if (empty($errors_array)) {
      $stmt = $pdo->prepare("INSERT INTO categories(name, parent_id) 
      VALUES(:zname, :zparent)");
      $stmt->execute(array(
        'zname' => $name,
        'zparent' => $parent_id
      ));
      $_POST = [];
      echo "<div class='alert alert-success'>Category added successfully</div>";
    }
   }

?>
<div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <h1 class="text-center">Create Category</h1>
<form action=<?php echo $_SERVER['PHP_SELF']?> method="POST">
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-8">
      <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Name" value="<?php echo $_POST['name'] ? $_POST['name'] : "" ?>">
      <div class="err" style="color:red;"><?php echo $nerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="parent" class="col-sm-2 col-form-label">Parent:</label>
        <div class="col-sm-8">
            <select name="parent_id" id="parent">
              <option value="0" selected>No parent/ Main Category</option>
              <?php 
                 $cats = getCats() ;
                 foreach ($cats as $cat) {
                    echo "<option value='".$cat['id']."'>".$cat['name']."</option>";
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