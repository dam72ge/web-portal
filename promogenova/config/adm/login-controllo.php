<?php
$url="../../"; 
include "../mydb.php";

// tipo sessione
$tipoSess="Admin";
$admin="";
$timeAccesso=date('D d/m/Y H:i');

// ricevi login
$accesso=$_POST['admin'];
$msg="I dati inseriti non corrispondono. Riprova"; 
if ($accesso=="") { $msg="Dati non inseriti!"; }

// controlla login -> apri sessione
$sql="SELECT admin FROM admin";
$query=mysqli_query($conn,$sql);			
while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){ 
if($accesso==$row['admin']){ 
$msg="";
}
}

if($msg!=""){ 
$redirpag="login-errore.php?msg=".$msg;
header("location: $redirpag");
}


// predisponi variabili per amministrare anche le vetrine nell'area clienti
session_cache_limiter('no-store');
session_cache_expire(180);
session_start();
if(!isset($_SESSION['created'])){
session_regenerate_id();

$inc=$url."config/sessione_clienti_registra.php";
include $inc;

// admin
$_SESSION['admin']="s";
} 

// entra nell'admin
if ($msg==""){
$redirpag="index.php";
header("location: $redirpag");
} 
?>
