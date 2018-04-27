<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// azzera sessione nuovo articolo
$art_titolo=""; $_SESSION['art_titolo']=""; 
$art_testo=""; $_SESSION['art_testo']=""; 

$urlFile=$url.$cartella."/".$art_img;
if (file_exists($urlFile)) { unlink($urlFile);}   
$urlFile=$url.$cartella."/th_".$art_img;
if (file_exists($urlFile)) { unlink($urlFile);}   
$urlFile=$url.$cartella."/ico_".$art_img;
if (file_exists($urlFile)) { unlink($urlFile);}   
$art_img=""; $_SESSION['art_img']=""; 

$art_idMacro=""; $_SESSION['art_idMacro']=""; 
$art_macro=""; $_SESSION['art_macro']=""; 

$art_idR=$idR; $_SESSION['art_idR']=$art_idR; 
$art_idP=$idP; $_SESSION['art_idP']=$art_idP; 
$art_idC=$idC; $_SESSION['art_idC']=$art_idC; 
$art_idM=$idM; $_SESSION['art_idM']=$art_idM; 
$art_idQ=$idQ; $_SESSION['art_idQ']=$art_idQ; 

$art_dataReg=""; $_SESSION['art_dataReg']="";
$art_id=0; $_SESSION['art_id']=0;
$art_osc="s"; $_SESSION['art_osc']="s";

// ricomincia sessione
header("location: nuovo.php");
?>