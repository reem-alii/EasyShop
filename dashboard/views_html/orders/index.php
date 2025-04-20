<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/orders.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Orders Table</h1>
<table class="table" style="background-color:#7d9a741f">
  <thead>
    <tr>
      <th>order n.</th>
      <th>Full Name</th>
      <th>Phone</th>
      <th>Address</th>
      <th>Order Status</th>
      <th>Order Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($orders as $order) {
    ?>    
        <tr>
        <td><?php echo $order['order_number'] ?> </td>
        <td><?php echo $order['full_name'] ?> </td>
        <td><?php echo $order['phone'] ?> </td>
        <td><?php echo $order['address'] ?> </td>
        <td><?php echo $order['status'] ?> </td>
        <td><?php echo $order['created_at'] ?> </td>
        <td>  <a href="http://".$_SERVER ['HTTP_HOST']."/dashboard/views_html/orders/index.php?action=delete&order_id=<?php echo $order['id'] ?>"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-xmark" style="color:black;"></i></a>
              <a href="http://".$_SERVER ['HTTP_HOST']."/dashboard/views_html/orders/details.php?action=details&order_id=<?php echo $order['id'] ?>"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-arrow-up-right-from-square" style="color:black;"></i></a>

              <?php if ($order['status'] != 'Canceled' && $order['status'] != 'Delivered' && $order['status'] != 'Refunded' ){ ?>
                <a href="http://".$_SERVER ['HTTP_HOST']."/dashboard/views_html/orders/index.php?action=cancel&order_id=<?php echo $order['id'] ?>"
                      class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #ff7675; margin-left: 4px;">
                      <i class="fa-solid fa-ban" style="color:black;"></i></a>
              <?php } ?>  
              </td>
    <?php } ?>
  </tbody>
</table>
</div>
</div>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php");
