<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/categories.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Categories Table</h1>
            <a class="btn btn-outline-success" href="http://<?= $_SERVER ['HTTP_HOST'] ?>/dashboard/views_html/categories/create.php">Create Category <i class="fa-solid fa-tag"></i> </a><br><br>
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
    <?php foreach ($cats as $cat) { ?>
        <tr>
       <?php if($cat['parent_id'] == 0){ ?>
              <td class="bold" style="font-weight:bold; color: #44553f; font-style: italic ;"><?php echo $cat['id'] ?></td>
              <td class="bold" style="font-weight:bold; color: #44553f; font-style: italic ;"><?php echo $cat['name'] ?></td>
              <td> <div class="no" style="font-style: italic;color: #166227;" >No parent(Main Category)</div> </td>
        <?php }else{ ?>
              <td><?php echo $cat['id'] ?></td>
              <td><?php echo $cat['name'] ?></td>
              <td> <?php $parent = findCat($cat['parent_id']);
                        echo $parent['name'] ; ?>
              </td>
        <?php } ?>
              <td>
        <?php
            $subs = getSubCats($cat['id']);
            if (count($subs) > 0){
                foreach($subs as $sub){
                    echo $sub['name']?><div class="slash" style="display:inline;"><span> / </span></div>
        <?php   }
            }else{  echo 'No sub categories';  }   
        ?>
            </td>
            <td>
              <a href="http://<?= $_SERVER ['HTTP_HOST'] ?>/dashboard/views_html/categories/index.php?action=delete&catid=<?php echo $cat['id']?>"
              class="btn btn-secondary btn-sm confirm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-trash" style="color:black;"></i></a>
              <a href="http://<?= $_SERVER ['HTTP_HOST'] ?>/dashboard/views_html/categories/edit.php?action=edit&catid=<?php echo $cat['id'] ?>"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-pen" style="color:black;"></i></a>
              <a href="http://<?= $_SERVER ['HTTP_HOST'] ?>/dashboard/views_html/categories/show.php?action=show&catid=<?php echo $cat['id'] ?>"
              class="btn btn-secondary btn-sm" data-inline="true" style="background-color: #7d9a74;">
              <i class="fa-solid fa-arrow-up-right-from-square" style="color:black;"></i></a>
        
            </td>
        <?php  }?>
  </tbody>
</table>
</div>
</div>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php");
