<?php
session_start();
$idAttivita=$_POST['idAttivita'];
include "../mydb.php";

// recupera utente e password
$sql="SELECT utente,pwd FROM att_clienti WHERE idAttivita='".mysqli_real_escape_string($conn,stripslashes($idAttivita))."'";
$query=mysqli_query($conn,$sql);			
$riga=mysqli_fetch_array($query,MYSQLI_ASSOC);

if (isset($_SESSION['admin'])){
$_SESSION['admin_id']=$idAttivita;
$_SESSION['admin_ut']=$riga['utente'];
$_SESSION['admin_pwd']=$riga['pwd'];
$redirpag="../../area-clienti/login-controllo.php";
header("location: $redirpag");
}

?>
