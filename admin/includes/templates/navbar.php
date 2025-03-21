<?php
session_start();
?>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color:#5b8058c7;">
  <a class="navbar-brand" ><strong>EasyShop</strong></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="../pages/dashboard.php">Home</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="../pages/admins_index.php">Admins</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="../pages/users_index.php">Users</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="../pages/categories_index.php">Categories</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="../pages/products_index.php">Products</a>
      </li>
      <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Account
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="../pages/logout.php">Logout</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>
  </div>
</nav>