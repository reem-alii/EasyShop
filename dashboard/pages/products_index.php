<?php
session_start();
if(isset($_SESSION['admin_id'])){
include "init.php";
$stmt = $pdo->prepare('SELECT * FROM products');
$stmt->execute();
$products = $stmt->fetchAll();
$count = $stmt->rowCount();

// Delete Product 
$action = isset($_GET['action']) ? $_GET['action'] : NULL;
if($action == 'delete'){
    $id = isset($_GET['prodid']) ? intval($_GET['prodid']) : 0;
    $pro = $pdo->prepare("SELECT * FROM products WHERE id = $id");
    $pro->execute();
    $product = $pro->fetch();
    unlink($product['Image']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: products_index.php');
    exit();
}

// Approve Product
if($action == 'approve'){
    $id = isset($_GET['prodid']) ? intval($_GET['prodid']) : 0;
    $stmt = $pdo->prepare('UPDATE products SET approve = 1 WHERE id = ?');
    $stmt->execute(array($id));
    header('Location: products_index.php');
    exit();
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Products Table</h1>
            <a class="btn btn-outline-success" href="products_create.php">Create Product <i class="fa-solid fa-bag-shopping"></i></a><br><br>
<table class="table" style="background-color:#7d9a741f">
  <thead>
    <tr>
      <th>id</th>
      <th>Name</th>
      <th>Price</th>
      <th>Category</th>
      <th>Approval</th>
      <th>Stock</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($products as $prod) {
        $cat = findCat($prod['cat_id']);
        echo '<tr>';
        echo '<td>'.$prod['id'].'</td>';
        echo '<td>'.$prod['name'] .'</td>';
        echo '<td>'.$prod['price'].'</td>';
        echo '<td>'. $cat['name'].'</td>';
        echo '<td>';
        if ($prod['approve'] == 1 ){
          echo '<span class="badge badge-pill badge-success">Approved</span>';
        }else {
            echo '<a href="products_index.php?action=approve&prodid='.$prod['id'].'" class="badge badge-pill badge-warning">Not Approved </a>';
        }
        echo '</td>';
        echo '<td>'. $prod['stock'].'</td>';
        echo '<td>
              <a href="products_index.php?action=delete&prodid='.$prod['id'].'"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-eraser" style="color:black;"></i></a>
              <a href="products_edit.php?prodid='.$prod['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-file-pen" style="color:black;"></i></a>
              <a href="products_show.php?prodid='.$prod['id'].'"
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