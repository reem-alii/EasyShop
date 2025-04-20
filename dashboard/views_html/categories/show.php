<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/categories.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="show">
               <div class="card">
                 <img src="https://t4.ftcdn.net/jpg/00/81/38/59/360_F_81385977_wNaDMtgrIj5uU5QEQLcC9UNzkJc57xbu.jpg" alt="Denim Jeans" style="width:100%">
                 <h1 class="text-center"><?php echo $row['name'] ; ?></h1>
                 <h4 class="text-center"><?php echo $parent ; ?></h4>
                 <?php
                    if($subs){
                        echo "<p class='text-center'><strong>Sub Cats.:</strong>";
                       foreach($subs as $sub){
                            echo '<span class="badge badge-pill badge-warning" style="color:black;">'.$sub['name'].'</span>';
                       }
                       echo "</p>";
                    }   
                 ?>
                 <p class="text-center"><a href="http://localhost/EasyShop/dashboard/views_html/categories/index.php?action=delete&catid=<?php echo $row['id'] ; ?>"
                     class="btn btn-secondary confirm" data-inline="true" style="background-color: #e83d2bc4;">
                     <i class="fa-solid fa-eraser" style="color:black;"></i></a>
                     <a href="http://localhost/EasyShop/dashboard/views_html/categories/edit.php?action=edit&catid=<?php echo $row['id'] ; ?>"
                     class="btn btn-secondary" data-inline="true" style="background-color: #0fbd0980;">
                     <i class="fa-solid fa-file-pen" style="color:black;"></i></a>
                 </p>
                </div>
            </div>
        </div>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php");