<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/products.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Products Table</h1>
            <a class="btn btn-outline-success" href="http://".$_SERVER ['HTTP_HOST']."/dashboard/views_html/products/create.php">Create Product <i class="fa-solid fa-bag-shopping"></i></a><br><br>
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
    ?>
        <tr>
        <td><?php echo $prod['id'] ?></td>
        <td><?php echo $prod['name']  ?></td>
        <td><?php echo $prod['price'] ?></td>
        <td><?php echo $cat['name'] ?></td>
        <td>
    <?php        
        if ($prod['approve'] == 1 ){
    ?>        
           <span class="badge badge-pill badge-success">Approved</span>
    <?php
        }else {
    ?>
           <a href="http://".$_SERVER ['HTTP_HOST']."/dashboard/views_html/products/index.php?action=approve&prodid=<?php echo $prod['id'] ?>" class="badge badge-pill badge-warning">Not Approved </a>
    <?php }?>
        </td>
        <td><?php echo $prod['stock'] ?></td>
        <td>
              <a href="http://".$_SERVER ['HTTP_HOST']."/dashboard/views_html/products/index.php?action=delete&prodid=<?php echo $prod['id'] ?>"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-eraser" style="color:black;"></i></a>
              <a href="http://".$_SERVER ['HTTP_HOST']."/dashboard/views_html/products/edit.php?action=edit&prodid=<?php echo $prod['id'] ?>"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-file-pen" style="color:black;"></i></a>
              <a href="http://".$_SERVER ['HTTP_HOST']."/dashboard/views_html/products/show.php?action=show&prodid=<?php echo $prod['id'] ?>"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-arrow-up-right-from-square" style="color:black;"></i></a>
        </td>
    <?php  } ?>
  </tbody>
</table>
</div>
</div>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php");
