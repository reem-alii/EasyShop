<div>
        <div class="header-dark">
            <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
                <div class="container"><a class="navbar-brand" href="http://localhost/EasyShop/front/views_html/index.php">EasyShop</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse"
                        id="navcol-1">
                        <ul class="nav navbar-nav">
                            <li class="nav-item" role="presentation"><a class="nav-link" href="#">Link</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="#">LinK</a></li>
                            <li class="dropdown"><a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">Categories </a>
                                 <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" role="presentation" href="http://localhost/EasyShop/front/views_html/products.php?catid=0">All</a>
                            <?php 
                                $cats = getAllCats();
                                foreach($cats as $cat){
                                    echo '<a class="dropdown-item" role="presentation" href="http://localhost/EasyShop/front/views_html/products.php?catid='.$cat['id'].'">'.$cat['name'].'</a>';
                                }
                            ?>
                                 </div>
                            </li>
                        </ul>
                        <form class="form-inline mr-auto" target="_self">
                           <!-- <div class="form-group"><label for="search-field"><i class="fa fa-search"></i></label><input class="form-control search-field" type="search" name="search" id="search-field"></div>-->
                        </form>
                         <?php 
                         if(isset($_SESSION['user_id'])){
                            echo '<span class="navbar-text"></span><a class="btn btn-light action-button" role="button" href="http://localhost/EasyShop/front/php_scripts/logout.php">Logout</a></div>';
                            echo '<div class="nav-item" role="presentation" style="font-size: 25px;"><a class="nav-link" href="http://localhost/EasyShop/front/views_html/profile.php"><i class="fa-solid fa-circle-user"></i></a></div>';
                         }else{ 
						    echo '<span class="navbar-text"></span><a class="btn btn-light action-button" role="button" href="http://localhost/EasyShop/front/views_html/login_signup.php">Sign Up/Login</a></div>';
                         } ?>
                          <div class="nav-item" role="presentation" style="font-size: 25px;"><a class="nav-link" href="http://localhost/EasyShop/front/views_html/cart.php"><i class="fa-solid fa-cart-shopping"></i></a></div>

                </div>
            </nav>