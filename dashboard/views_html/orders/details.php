<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/orders.php"); ?>

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
    <form action="http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/orders/details.php?action=update&order_id=<?php echo $order['id']?>" method="POST">
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
            <?php switch($order['status']){
                case 'Canceled':
                    echo '<span class="badge badge-danger">Canceled</span>';
                    break;
                case 'Refunded':
                    echo '<span class="badge badge-warning">Refunded</span>';
                    break;
                default:
            ?>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary <?php if ($order['status'] == 'Processing') echo "active focus"; ?>">
              <input type="radio" name="status" value="Processing" <?php if ($order['status'] == 'Processing') echo "checked"; ?>> Processing
            </label>
            <label class="btn btn-secondary <?php if ($order['status'] == 'Pending') echo "active focus"; ?>">
              <input type="radio" name="status" value="Pending" <?php if ($order['status'] == 'Pending') echo "checked"; ?>> Pending
            </label>
            <label class="btn btn-secondary <?php if ($order['status'] == 'Delivered') echo "active focus"; ?>">
              <input type="radio" name="status" value="Delivered" <?php if ($order['status'] == 'Delivered') echo "checked"; ?>> Delivered
            </label>
            <label class="btn btn-secondary <?php if ($order['status'] == 'Refunded') echo "active focus"; ?>">
              <input type="radio" name="status" value="Refunded" <?php if ($order['status'] == 'Refunded') echo "checked"; ?>> Refunded
            </label>
            <?php if ($order['status'] != 'Delivered') { ?>
            <label class="btn btn-secondary <?php if ($order['status'] == 'Canceled') echo "active focus"; ?>">
              <input type="radio" name="status" value="Canceled" <?php if ($order['status'] == 'Canceled') echo "checked"; ?>> Canceled
            </label>
            <?php } ?>
        </div>
        <?php } ?>
        </td>
    </tr>
    <tr>
        <td>Payment Status</td>
        <td>
            <?php switch($order['payment_status']){ 
                case 'Paid':
                case 'Pending':   
            ?> 
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary <?php if ($order['payment_status'] == 'Pending') echo "active focus"; ?>">
              <input type="radio" name="payment_status" value="Pending" <?php if ($order['payment_status'] == 'Pending') echo "checked"; ?>> Pending
            </label>
            <label class="btn btn-secondary <?php if ($order['payment_status'] == 'Paid') echo "active focus"; ?>">
              <input type="radio" name="payment_status" value="Paid" <?php if ($order['payment_status'] == 'Paid') echo "checked"; ?>> Paid
            </label>
        </div>
        <?php break;
          default :
          echo "<span class='badge badge-warning'>".$order['payment_status']."</span>";
         } ?>
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
    <?php if($order['status'] != 'Canceled'){ ?>
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
                      <a class='sure' href='http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/orders/details.php?action=refund&order_id=".$order['id']."&itemid=".$item['product_id']."' title='Refund Item'><i class='fa-solid fa-person-walking-arrow-loop-left' style='padding:2px;color: red;background-color: white;border-radius:5px;'></i></a>
                  </td>";
          }else{
            echo "<td><span class='badge badge-danger'>Refunded</span>
                  </td>";
          }
          ?>
    </tr>
  <?php } ?>
  </tbody>
  <?php }else{ ?>
    <thead>
        <tr>
            <th>Item</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($order_items as $item) { ?>
            <tr style ="background-color:#e31b1b59;" >
                <td><?php echo $item['name'] ?></td>
                <td>$<?php echo number_format($item['price']) ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <?php } ?>
</table>
</div>
</div>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php");
