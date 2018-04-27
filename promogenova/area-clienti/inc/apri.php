<?php
define ('UA_SEED','WEBAPP');
$idAttivita=0;
$utente="";
// apri sessione e controlla dati
session_start();

// controllo sicurezza
if (!isset($_SESSION['user_agent'])){ $_SESSION['user_agent']=md5($_SERVER['HTTP_USER_AGENT'].UA_SEED);}
else{
if ($_SESSION['user_agent']!=md5($_SERVER['HTTP_USER_AGENT'].UA_SEED)){
// violazione sicurezza!
session_destroy();
session_unset();
setcookie(session_name(),'',time()-3600);
$_SESSION=array();
$msg="Accesso negato."; 
$redirpag=$urlAdm."login-errore.php?msg=".$msg;
header("location: $redirpag");
}
}

// accesso come admin
if (isset($_SESSION['admin'])){
//print "sei loggato anche come ADMIN<br />";
if ($_SESSION['utente']==""){$_SESSION['utente']="*admin*"; $_SESSION['idAttivita']=0;}
}

if (isset($_SESSION['idAttivita']) && isset($_SESSION['utente'])){

$inc=$url."config/sessione_clienti_leggi.php";
include $inc;
}
if ($utente==""){
session_destroy();
// effettua redirect
$url=$urlAdm."../login-clienti.php";
header ("location: $url");
}
?>