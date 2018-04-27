<?php
define ('UA_SEED','WEBAPP');
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
$redirpag="login-errore.php?msg=".$msg;
header("location: $redirpag");
}
}

if (isset($_SESSION['admin'])){

include "../sessione_clienti_leggi.php";
    
/*
$tipoSess=$_SESSION['tipoSess'];
$timeAccesso=$_SESSION['timeAccesso'];
$attivita=$_SESSION['attivita'];
$idAttivita=$_SESSION['idAttivita'];
$utente=$_SESSION['utente'];
$cartella=$_SESSION['cartella'];
$dataReg=$_SESSION['dataReg']; // registrazione attività
$dataScad=$_SESSION['dataScad']; // scadenza contratto
$dataAvv=$_SESSION['dataAvv']; // avviso scadenza contratto (2 settimane prima)
$dataOsc=$_SESSION['dataOsc']; // oscuramento definitivo (1 mese dopo scadenza contratto)
*/

}
else{
session_destroy();
// effettua redirect
$url="../../";
header ("location: $url");
}
?>

<h1>Admin portale</h1>
<?php
print "Data e ora accesso: ".$timeAccesso."<br /><br />";
?>
<a href="inizio.php">Amministra il Portale</a><br />
<a href="login-clienti.php">Passa all'Area clienti</a><br />
<a href="logout.php">Esci dall'Admin</a><br />

