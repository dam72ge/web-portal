<?php
// id
if (!isset($_GET['id'])) {
header ("location: index.php");
}
$id=$_GET['id'];

// redirect finale
$redirUrl="eventiModif.php?id=".$id;

$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// riconosci cliente
$cfrAtt=$mysql->cliente_eventi($id);
if ($idAttivita!=$cfrAtt) {
header ("location: $redirUrl ");
}

// elimina immagini evento
$urlFile=$url."eventi/locandine/".$ev_img;
if (file_exists($urlFile)) { unlink($urlFile);}   
$urlFile=$url."eventi/locandine/th_".$ev_img;
if (file_exists($urlFile)) { unlink($urlFile);}   
$urlFile=$url."/eventi/locandine/ico_".$ev_img;
if (file_exists($urlFile)) { unlink($urlFile);}   

// elimina dati db evento
$sql="DELETE FROM eventi WHERE id='".$id."'";
$query=mysqli_query($conn,$sql);      
$sql="DELETE FROM eventi_dateore WHERE id='".$id."'";
$query=mysqli_query($conn,$sql);      
$sql="DELETE FROM eventi_txt WHERE id='".$id."'";
$query=mysqli_query($conn,$sql);      
$sql="DELETE FROM eventi_zone WHERE id='".$id."'";
$query=mysqli_query($conn,$sql);      
$sql="DELETE FROM eventi_promot WHERE id='".$id."' AND idAttivita='".$idAttivita."'";

// azzera sessione nuovo evento
$ev_titolo=""; $_SESSION['ev_titolo']=""; 
$ev_testo=""; $_SESSION['ev_testo']="";
$ev_id=0; $_SESSION['ev_id']=0;
$ev_img=""; $_SESSION['ev_img']=""; 

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

$ev_idR=$idR; $_SESSION['ev_idR']=$ev_idR; 
$ev_idP=$idP; $_SESSION['ev_idP']=$ev_idP; 
$ev_idC=$idC; $_SESSION['ev_idC']=$ev_idC; 
$ev_idM=$idM; $_SESSION['ev_idM']=$ev_idM; 
$ev_idQ=$idQ; $_SESSION['ev_idQ']=$ev_idQ; 
$ev_luogo=""; $_SESSION['ev_luogo']="";

// ricomincia sessione
header("location: index.php");
?>
