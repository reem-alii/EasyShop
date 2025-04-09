<?php
session_start();
if(isset($_SESSION['admin_id'])){
include "init.php";
error_reporting(E_ALL);
ini_set('display_errors',1);
$stmt = $pdo->prepare('SELECT * FROM orders');
$stmt->execute();
$orders = $stmt->fetchAll();
$count = $stmt->rowCount();

// Delete Order 
$action = isset($_GET['action']) ? $_GET['action'] : NULL;
if($action == 'delete'){
    $id = intval($_GET['order_id']) ;
    $stmt = $pdo->prepare('DELETE FROM orders WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: orders_index.php');
    exit;
}
// Cancel Order
if ($action == 'cancel'){
  $id = intval($_GET['order_id']) ;
  $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = $id");
  $stmt->execute(array('Canceled'));
  returnItemsToStock($id);
  header('Location: orders_index.php');
  exit;
}

?>
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
        echo '<tr>';
        echo '<td>'.$order['order_number'].'</td>';
        echo '<td>'.$order['full_name'].'</td>';
        echo '<td>'.$order['phone'].'</td>';
        echo '<td>'.$order['address'].'</td>';
        echo '<td>'.$order['status'].'</td>';
        echo '<td>'.$order['created_at'].'</td>';
        echo '<td>
              <a href="orders_index.php?action=delete&order_id='.$order['id'].'"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-xmark" style="color:black;"></i></a>
              <a href="orders_details.php?order_id='.$order['id'].'"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-arrow-up-right-from-square" style="color:black;"></i></a>';
              if ($order['status'] != 'Canceled' && $order['status'] != 'Delivered' ){
                echo  '<a href="orders_index.php?action=cancel&order_id='.$order['id'].'"
                      class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #ff7675; margin-left: 4px;">
                      <i class="fa-solid fa-ban" style="color:black;"></i></a>';
              }   
        echo '</td>';
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