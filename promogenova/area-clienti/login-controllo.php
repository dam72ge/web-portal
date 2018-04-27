<?php
session_start();
$url=""; 
include "../config/mydb.php";
require_once "../config/class_layout.php"; $myobj=new pagina;

// tipo sessione
$tipoSess="Area clienti";
$admin="";
$timeAccesso=date('D d/m/Y i:s');

// già loggato come admin?
if (isset($_SESSION['admin'])){
$idAttivita=$_SESSION['admin_id'];
$utente=$_SESSION['admin_ut'];
$pwd=$_SESSION['admin_pwd'];
//print $utente.", ".$pwd."<br />"; exit;
}
else {
$idAttivita=0;
$utente=$_POST['utente'];
$pwd=$_POST['pwd'];
}

// ricevi variabili utente, pwd
$msg="";

//print "OK - ".$utente.", ".$pwd."<br />"; exit;

if ($utente=="" | $pwd=="") { $msg="Dati non inseriti!"; }

// controlla login -> apri sessione
if ($msg==""){ 
$sql="SELECT idAttivita,dataReg FROM att_clienti WHERE utente='".mysqli_real_escape_string($conn,stripslashes($utente))."' AND pwd='".mysqli_real_escape_string($conn,stripslashes($pwd))."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$idAttivita=$row['idAttivita'];
$dataReg=$row['dataReg'];
if($row['idAttivita']=="" ){ 
    $msg="I dati inseriti non corrispondono. Riprova"; 
    }
}

// controlla oscuramento e data
if ($msg=="" && !isset($_SESSION['admin'])){
$sql="SELECT osc,dataScad,dataAvv,dataOsc FROM att_scad WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);

if($msg=="" && $row['osc']!="n" ){ 
    $msg="L'account e' stato provvisoriamente disattivato da Promogenova.it"; 
    }
}
if ($msg=="" && !isset($_SESSION['admin'])){ 
$oggi=date('Ymd');
$idAvv=$row['dataAvv'];
$idScad=$row['dataScad'];
$idOsc=$row['dataOsc'];
$fd=substr($idOsc,6,2)."/".substr($idOsc,4,2)."/".substr($idOsc,0,4);
if($msg=="" && $oggi>$idOsc){ $msg="L'account e' stato rimosso definitivamente il ".$fd; }				
}

// messaggio errore --> REDIRECT 
if ($msg!="" && !isset($_SESSION['admin'])){ 
$redirpag="login-errore.php?msg=".$msg;
header("location: $redirpag");
}

// RECUPERA TUTTI I DATI DEL CLIENTE
$attivita="";
$sql="SELECT attivita FROM attivita WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$attivita=$myobj->mb_convert_encoding($row['attivita']);

$sql="SELECT pwd,dataReg,vetrOmaggio,creaEventi,assistPeriod,creaPromo FROM att_clienti WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$pwd=$row['pwd'];
$dataReg=$row['dataReg'];
$vetrOmaggio=$row['vetrOmaggio'];
$creaEventi=$row['creaEventi'];
$assistPeriod=$row['assistPeriod'];
$creaPromo=$row['creaPromo'];

$sql="SELECT telefono,email,nota FROM att_clienti_contatti WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$clienteTel=$row['telefono'];
$clienteEmail=$row['email'];
$clienteNota=$row['nota'];

$sql="SELECT mappa FROM att_map WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$mappa=$row['mappa'];

$sql="SELECT indirizzo,nciv,cap,idR,idP,idC,idM,idQ,altro FROM att_indirizzi WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$indirizzo=$row['indirizzo'];
$nciv=$row['nciv'];
$cap=$row['cap'];
$idR=$row['idR'];
$idP=$row['idP'];
$idC=$row['idC'];
$idM=$row['idM'];
$idQ=$row['idQ'];
$altraZona=$row['altro'];
$regione="";
if ($idR>0) {
$sql="SELECT regione FROM regioni WHERE idR='".$idR."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$regione=$row['regione'];
}
$provincia=""; $sigla="";
if ($idP>0) {
$sql="SELECT provincia,sigla FROM province WHERE idP='".$idP."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$provincia=$row['provincia'];
$sigla=$row['sigla'];
}
$comune=""; 
if ($idC>0) {
$sql="SELECT comune FROM comuni WHERE idC='".$idC."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$comune=$row['comune'];
}
$municipio=""; 
if ($idM>0) {
$sql="SELECT municipio FROM municipi WHERE idM='".$idM."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$municipio=$row['municipio'];
}
$quartiere=""; 
if ($idQ>0) {
$sql="SELECT quartiere FROM quartieri WHERE idQ='".$idQ."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$quartiere=$row['quartiere'];
}

$sql="SELECT ragsoc,partitaiva,codfisc FROM att_ragsoc WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$ragsoc=$row['ragsoc'];
$partitaiva=$row['partitaiva'];
$codfisc=$row['codfisc'];

$sql="SELECT osc,dataScad,dataAvv,dataOsc FROM att_scad WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$osc=$row['osc'];
$dataScad=$row['dataScad'];
$dataAvv=$row['dataAvv'];
$dataOsc=$row['dataOsc'];

$sql="SELECT cartella,logo FROM vetrine WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$cartella=$row['cartella'];
$logo=$row['logo'];

$sql="SELECT chisiamo FROM vetrine_chisiamo WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$chisiamo=$row['chisiamo'];

$sql="SELECT orari FROM vetrine_orari WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);			
$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
$orari=$row['orari'];

// registra dati nella sessione
if ($msg==""){
session_cache_limiter('no-store');
session_cache_expire(180);
session_start();
if(!isset($_SESSION['created'])){
session_regenerate_id();
$_SESSION['created']=TRUE;
}

$inc="../config/sessione_clienti_registra.php";
include $inc;
// admin
// $_SESSION['admin'] NON dichiarata --> accesso a areaclienti come admin! 
} 

// entra nell'admin
if ($msg==""){
$redirpag="../area-clienti/index.php";
header("location: $redirpag");
} 
?>
