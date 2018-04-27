<?php
session_start();
if (!isset($_SESSION['admin'])){
$msg="Accesso negato."; 
$redirpag=$url."login-errore.php?msg=".$msg;
header("location: $redirpag");
}
$db=$urlAdm."mydb.php"; include $db;

// classe layout
$classe=$urlAdm."class_layout.php";
require_once $classe; $myobj=new pagina;

$classe=$urlAdm."class_db.php";
require_once $classe; $db=new db;

// data oggi
$oggi= date('Ymd');
// admin
print "<a href='".$urlAdm."adm/index.php'><h1>Admin portale</a>";
?>
