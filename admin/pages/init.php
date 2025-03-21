<?php 
include "../configration/connect.php";
include "../includes/templates/header.php";
include "../includes/functions/functions.php";
session_start();
if(isset($_SESSION['admin_id'])){
    include "../includes/templates/navbar.php";
}
