<?php
session_start();
if(isset($_SESSION['admin_id'])){
include "init.php";
error_reporting(E_ALL);
ini_set('display_errors',1);
$order_id = $_GET['order_id'];
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
$stmt->execute(array($order_id));
$order = $stmt->fetch();
$order_items = getOrderItems($order_id);

// Edit order details 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $order['id'];
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $payment_status = $_POST['payment_status'];

    $errors_array = [];
    $errors_array = orderValidation($full_name, $phone, $address, $errors_array);
    $errors_array = statusValidation($status, $payment_status, $errors_array);
    if(empty($errors_array)){
        $stmt = $pdo->prepare("UPDATE orders SET full_name = ?, phone = ?, address = ?, status = ?, payment_status = ?
                                WHERE id = $id");
         $stmt->execute(array($full_name, $phone, $address, $status, $payment_status));
         header('Location: orders_details.php?order_id='.$id);
         exit;
    }else{
        foreach($errors_array as $err){
            echo '<div class="alert alert-danger">'.$err.'</div>';
        }
    }
}
// Refund Item 
if(isset($_GET['action']) && $_GET['action'] == 'refund'){
    $item_id = $_GET['itemid'];
    $product = findProduct($item_id);
    refundItem($order_id, $item_id, $product['price']);
    header('Location: orders_details.php?order_id='.$order_id);
    exit;
}


?>
<div class="container" style="max-width: 1300px;">
    <div class="row">
        <div class="col-md-6">
            <h1 class="text-center">Order Details</h1>
<table class="table" style="background-color:#7d9a741f">
  <thead>
    <tr>
      <th>key</th>
      <th>Value</th>
    </tr>
  </thead>
  <tbody>
    <form action="orders_details.php?order_id=<?php echo $order['id']?>" method="POST">
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
        <td><input type="text" name="full_name" value="<?php echo $order['full_name']; ?>"></td>
    </tr>
    <tr>
        <td>Customer Email</td>
        <td><?php echo $order['email']; ?></td>
    </tr>
    <tr>
        <td>Customer Phone</td>
        <td><input type="text" name="phone" value="<?php echo $order['phone']; ?>"></td>
    </tr>
    <tr>
        <td>Customer Address</td>
        <td><input type="text" name="address" value="<?php echo $order['address']; ?>"></td>
    </tr>
    <tr>
        <td>Total Cost</td>
        <td>$<?php echo number_format($order['total_cost']); ?></td>
    </tr>
    <tr>
        <td>Order Number</td>
        <td><?php echo $order['order_number']; ?></td>
    </tr>
    <tr>
        <td>Order Status</td>
        <td>
            <input type="text" name="status" value="<?php echo $order['status']; ?>">
            <small id="HelpBlock" class="form-text">Status can only be: Processing, Pending, Delivered.</small>
        </td>
    </tr>
    <tr>
        <td>Payment Status</td>
        <td>
            <input type="text" name="payment_status" value="<?php echo $order['payment_status']; ?>">
            <small id="HelpBlock" class="form-text">Status can only be: Pending, Completed, Failed or Canceled.</small>
        </td>
    </tr>
    <tr>
        <td>Order Created_at Date</td>
        <td><?php echo $order['created_at']; ?></td>
    </tr>
  </tbody>
</table>
<div class="text-center"><button type="submit" class="btn btn-success">Save Changes</button></div>
</form>
</div>
<div class="col-md-6">
            <h1 class="text-center">Order Items</h1>
<table class="table" style="background-color:#7d9a741f">
  <thead>
    <tr>
      <th>Item</th>
      <th>Price</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
   <?php foreach($order_items as $item) { ?>
    <tr <?php echo $item['status'] == 1 ? 'style="background-color: #b8e994"' : 'style="background-color: #ff7675"' ?>>
           <td><?php echo $item['name'] ?></td>
           <td>$<?php echo number_format($item['price']) ?></td>
          <?php 
          if($item['status'] == '1'){
            echo "<td><span class='badge badge-success'>Approved</span>
                      <a class='sure' href='orders_details.php?order_id=".$order_id."&action=refund&itemid=".$item['product_id']."' title='Refund Item'><i class='fa-solid fa-person-walking-arrow-loop-left sure' style='padding:2px;color: red;background-color: white;border-radius:5px;'></i></a>
                  </td>";
          }else{
            echo "<td><span class='badge badge-danger'>Refunded</span>
                  </td>";
          }
          ?>
    </tr>
  <?php } ?>
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