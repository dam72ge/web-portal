<?php
// LOGOUT
$url="../";
session_start();
session_destroy();
session_unset();
setcookie(session_name(),'',time()-3600);
$_SESSION=array();
// effettua redirect
header ("location: $url");
?>
