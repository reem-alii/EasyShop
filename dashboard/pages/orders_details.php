<?php
session_start();
if(isset($_SESSION['admin_id'])){
include "init.php";
$order_id = $_GET['order_id'];
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
$stmt->execute(array($order_id));
$order = $stmt->fetch();

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Order Details Table</h1>
<table class="table" style="background-color:#7d9a741f">
  <thead>
    <tr>
      <th>key</th>
      <th>Value</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <td>Order ID</td>
        <td><?php echo $order['id']; ?></td>
    </tr>
    <tr>
        <td>User ID</td>
        <td><?php echo $order['user_id']; ?></td>
    </tr>
    <tr>
        <td>Customer Name</td>
        <td><?php echo $order['full_name']; ?></td>
    </tr>
    <tr>
        <td>Customer Email</td>
        <td><?php echo $order['email']; ?></td>
    </tr>
    <tr>
        <td>Customer Phone</td>
        <td><?php echo $order['phone']; ?></td>
    </tr>
    <tr>
        <td>Customer Address</td>
        <td><?php echo $order['address']; ?></td>
    </tr>
    <tr>
        <td>Total Cost</td>
        <td><?php echo $order['total_cost']; ?></td>
    </tr>
    <tr>
        <td>Order Number</td>
        <td><?php echo $order['order_number']; ?></td>
    </tr>
    <tr>
        <td>Order Status</td>
        <td><?php echo $order['status']; ?></td>
    </tr>
    <tr>
        <td>Payment Status</td>
        <td><?php echo $order['payment_status']; ?></td>
    </tr>
    <tr>
        <td>Order Created_at Date</td>
        <td><?php echo $order['created_at']; ?></td>
    </tr>
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