<?php
// idArt
if (!isset($_GET['idArt'])) {
header ("location: index.php");
}
$idArt=$_GET['idArt'];

// redirect finale
$redirUrl="articoliModif.php?idArt=".$idArt;

$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// riconosci cliente
$cfrAtt=$mysql->cliente_articolo($conn,$idArt);
if ($idAttivita!=$cfrAtt) {
header ("location: $redirUrl ");
}

// elimina immagini articolo
$urlFile=$url.$cartella."/articoli/".$art_img;
if (file_exists($urlFile)) { unlink($urlFile);}   
$urlFile=$url.$cartella."/articoli/th_".$art_img;
if (file_exists($urlFile)) { unlink($urlFile);}   
$urlFile=$url.$cartella."/articoli/ico_".$art_img;
if (file_exists($urlFile)) { unlink($urlFile);}   

// elimina dati db articolo
$sql="DELETE FROM articoli WHERE idArt='".$idArt."'";
$query=mysqli_query($conn,$sql);      
$sql="DELETE FROM articoli_dat WHERE idArt='".$idArt."'";
$query=mysqli_query($conn,$sql);      
$sql="DELETE FROM articoli_txt WHERE idArt='".$idArt."'";
$query=mysqli_query($conn,$sql);      

if ($art_promozione=="s") {
$sql="DELETE FROM articoli_promo WHERE idArt='".$idArt."'";
$query=mysqli_query($conn,$sql);      
}

// azzera sessione nuovo articolo
$art_titolo=""; $_SESSION['art_titolo']=""; 
$art_testo=""; $_SESSION['art_testo']=""; 
$art_img=""; $_SESSION['art_img']=""; 
$art_idMacro=""; $_SESSION['art_idMacro']=""; 
$art_macro=""; $_SESSION['art_macro']=""; 
$art_promozione="n"; $_SESSION['promozione']="n"; 
$art_idR=$idR; $_SESSION['art_idR']=$art_idR; 
$art_idP=$idP; $_SESSION['art_idP']=$art_idP; 
$art_idC=$idC; $_SESSION['art_idC']=$art_idC; 
$art_idM=$idM; $_SESSION['art_idM']=$art_idM; 
$art_idQ=$idQ; $_SESSION['art_idQ']=$art_idQ; 
$art_dataReg=""; $_SESSION['art_dataReg']="";
$art_id=0; $_SESSION['art_id']=0;
$art_osc="s"; $_SESSION['art_osc']="s";

// ricomincia sessione
header("location: index.php");
?>
