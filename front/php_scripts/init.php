<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);


//set the value of a configuration directive
    ini_set('session.use_cookies', 'On'); // Use cookies to store session ID
	ini_set('session.use_trans_sid', 'Off'); // Disable passing session ID via URL (for security)
	ini_set('session.cookie_httponly', 'On'); // Prevent JavaScript from accessing session cookie (XSS protection)			
	//ini_set('session.cache_expire', '60'); // Set browser cache expiration for session (in minutes)
    ini_set('session.gc_maxlifetime', 60*60*24*7); // Set session max lifetime before cleanup (in seconds)
    session_set_cookie_params(60*60*24*7); // Set session cookie to last 7 days 
	//var_dump(session_save_path());
    session_start();
    //var_dump(session_id());

include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/configration/connect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/front/includes/templates/header.php");
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/front/includes/functions/functions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/front/includes/queries/queries.php");
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/front/includes/templates/navbar.php");

