<?php
session_start();
if(isset($_SESSION['admin_id'])){
include "init.php";
$stmt = $pdo->prepare('SELECT * FROM categories');
$stmt->execute();
$cats = $stmt->fetchAll();
$count = $stmt->rowCount();

// Delete Category 
$action = isset($_GET['action']) ? $_GET['action'] : NULL;
if($action == 'delete'){
    $id = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: categories_index.php');
    exit();
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Categories Table</h1>
            <a class="btn btn-outline-success" href="categories_create.php">Create Category <i class="fa-solid fa-tag"></i> </a><br><br>
<table class="table" style="background-color:#7d9a741f">
  <thead>
    <tr>
      <th>id</th>
      <th>Name</th>
      <th>Parent</th>
      <th>Sub. Categories</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($cats as $cat) {
        echo '<tr>';
        if($cat['parent_id'] == 0){
              echo '<td class="bold" style="font-weight:bold; color: #44553f; font-style: italic";>' . $cat['id'] . '</td>';
              echo '<td class="bold" style="font-weight:bold; color: #44553f; font-style: italic";>' . $cat['name'] . '</td>';
              echo '<td> <div class="no" style="font-style: italic;color: #166227;" >No parent(Main Category)</div> </td>';
        }else{
              echo '<td>' . $cat['id'] . '</td>';
              echo '<td>' . $cat['name'] . '</td>';
              $parent = findCat($cat['parent_id']);
              echo '<td>'.$parent['name'].'</td>' ;
        }
        echo '<td>';
            $subs = getSubCats($cat['id']);
            if (count($subs) > 0){
                foreach($subs as $sub){
                    echo $sub['name'].'<div class="slash" style="display:inline;"><span> / </span></div>';
                }
            }else{
                echo 'No sub categories';
            }    
        echo '</td>';
        echo '<td>
              <a href="categories_index.php?action=delete&catid='.$cat['id'].'"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-trash" style="color:black;"></i></a>
              <a href="categories_edit.php?catid='.$cat['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-pen" style="color:black;"></i></a>
              <a href="categories_show.php?catid='.$cat['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-arrow-up-right-from-square" style="color:black;"></i></a>
        
        </td>';
      }
    ?>
  </tbody>
</table>
</div>
</div>
</div>

<?php include "../includes/templates/footer.php";
}else{
  header('Location: index.php');
}
?>