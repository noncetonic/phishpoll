<?php
session_name("phishpollLogin");
session_start();
if (!$_SESSION['signed_in']) {
	$_SESSION['flash_error'] = "Please sign in";
	header("Location: /admin/login.php");
	exit; // IMPORTANT: Be sure to exit here!
}
?>
