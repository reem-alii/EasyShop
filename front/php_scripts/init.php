<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);


//set the value of a configuration directive
    ini_set('session.use_cookies', 'On'); // Use cookies to store session ID
	ini_set('session.use_trans_sid', 'Off'); // Disable passing session ID via URL (for security)
	ini_set('session.cookie_httponly', 'On'); // Prevent JavaScript from accessing session cookie (XSS protection)			
	ini_set('session.cache_expire', '60'); // Set browser cache expiration for session (in minutes)
    session_set_cookie_params(60*60*24*7); //Set session cookie to last 7 days
    ini_set('session.gc_maxlifetime',60*60*24*7); # Session lifetime of 7 days in second (before clean up)
    ini_set('session.gc_probability', 1);# Enable session garbage collection with a 1% chance of
    ini_set('session.gc_divisor', 100); # running on each session_start()
    ini_set('session.cookie_lifetime', 60*60*24*7);
    session_start(); # Start the session

	
    /*var_dump(session_save_path());
    var_dump(session_id());
    # Our own session save path; it must be outside the
    # default system save path so Debian's cron job doesn't
    # try to clean it up. The web server daemon must have
    # read/write permissions to this directory.
    session_save_path($_SERVER['DOCUMENT_ROOT']."" . '/sessions');*/

include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/configration/connect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/front/includes/templates/header.php");
include_once($_SERVER['DOCUMENT_ROOT']."/front/includes/functions/functions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/front/includes/queries/queries.php");
include_once($_SERVER['DOCUMENT_ROOT']."/front/includes/templates/navbar.php");

