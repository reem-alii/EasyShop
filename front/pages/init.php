<?php 
include "../../dashboard/configration/connect.php";
include "../includes/templates/header.php";
include "../includes/functions/functions.php";
include "../includes/queries/queries.php";

session_start();
if(isset($_SESSION['user_id'])){
    //include "../includes/templates/navbar.php";
}
