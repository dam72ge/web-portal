<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// azzera sessione nuovo evento
$ev_titolo=""; $_SESSION['ev_titolo']=""; 
$ev_testo=""; $_SESSION['ev_testo']=""; 

$ev_id=0; $_SESSION['ev_id']=0;

$ev_anno=0; $_SESSION['ev_anno']=0;
$ev_dataInizio=""; $_SESSION['ev_dataInizio']="";
$ev_oreInizio=""; $_SESSION['ev_oreInizio']="";
$ev_dataFine=""; $_SESSION['ev_dataFine']="";
$ev_oreFine=""; $_SESSION['ev_oreFine']="";
$ev_dataAvv=""; $_SESSION['ev_dataAvv']="";
$ev_dataOsc=""; $_SESSION['ev_dataOsc']="";

$_SESSION['ev_anno']=date("Y");
$_SESSION['ev_dataInizio']=date("Ymd");
$_SESSION['ev_oreInizio']=date("H").":00";
$_SESSION['ev_dataFine']=date("Ymd");
$_SESSION['ev_oreFine']=date("H").":00";
$_SESSION['ev_dataAvv']="";
$_SESSION['ev_dataOsc']="";


$urlFile=$url.$cartella."/".$ev_img;
if (file_exists($urlFile)) { unlink($urlFile);}   
$urlFile=$url.$cartella."/th_".$ev_img;
if (file_exists($urlFile)) { unlink($urlFile);}   
$urlFile=$url.$cartella."/ico_".$ev_img;
if (file_exists($urlFile)) { unlink($urlFile);}   
$ev_img=""; $_SESSION['ev_img']=""; 

$ev_idR=$idR; $_SESSION['ev_idR']=$ev_idR; 
$ev_idP=$idP; $_SESSION['ev_idP']=$ev_idP; 
$ev_idC=$idC; $_SESSION['ev_idC']=$ev_idC; 
$ev_idM=$idM; $_SESSION['ev_idM']=$ev_idM; 
$ev_idQ=$idQ; $_SESSION['ev_idQ']=$ev_idQ; 

$ev_luogo=""; $_SESSION['ev_luogo']="";

// ricomincia sessione
header("location: nuovo.php");
?>