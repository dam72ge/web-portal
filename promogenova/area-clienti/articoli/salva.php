<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// data
$art_dataReg=date('Ymd'); $_SESSION['art_dataReg']=date('Ymd');

// tab: articoli
    $sql = 
    "
    INSERT INTO articoli
    (idArt,dataReg,osc,img,titolo) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($art_dataReg))."',
    '".mysqli_real_escape_string($conn,stripslashes($art_osc))."',
    '".mysqli_real_escape_string($conn,stripslashes($art_img))."',
    '".mysqli_real_escape_string($conn,stripslashes($art_titolo))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovo=mysql_insert_id();

   $_SESSION['art_id']=$idNuovo;
   $_SESSION['art_osc']=$art_osc;

// se sono state caricate immagini, cambia nomi e adegua il db
if ($art_img!="") {
   $dirFile=$url.$cartella."/";
   $urlFile=$url.$cartella."/".$art_img;
   $ext=strtolower(pathinfo($urlFile,PATHINFO_EXTENSION));
   $nuovoNome=$idNuovo.".".$ext;
   $nuovoFile=$url.$cartella."/articoli/".$nuovoNome;
   if (file_exists($urlFile)) { rename($urlFile,$nuovoFile); }   
   $urlFile=$url.$cartella."/th_".$art_img;
   $nuovoFile=$url.$cartella."/articoli/th_".$nuovoNome;
   if (file_exists($urlFile)) { rename($urlFile,$nuovoFile); }   
   $urlFile=$url.$cartella."/ico_".$art_img;
   $nuovoFile=$url.$cartella."/articoli/ico_".$nuovoNome;
   if (file_exists($urlFile)) { rename($urlFile,$nuovoFile); }   

   $art_img=$nuovoNome;
   $_SESSION['art_img']=$nuovoNome;

   $sql="UPDATE articoli SET  
   img='".mysqli_real_escape_string($conn,stripslashes($art_img))."' 
   WHERE idArt='".$idNuovo."'";
   $query=mysqli_query($conn,$sql);
   
   $_SESSION['art_img']="";
}

// tab: articoli_dat
    $sql = 
    "
    INSERT INTO articoli_dat
    (idArt,idVecchio,idMacro,idAttivita) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '',
    '".mysqli_real_escape_string($conn,stripslashes($art_idMacro))."',
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."'    
    )";
    $query=mysqli_query($conn,$sql);

/*
// tab: articoli_promo
if ($creaPromo=="s" && $idR!=$art_idR && $idP!=$art_idP && $idC!=$art_idC && $idM!=$art_idM && $idQ!=$art_idQ) {
    $sql = 
    "
    INSERT INTO articoli_promo
    (idArt,idAttivita,idR,idP,idC,idM,idQ) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '".mysqli_real_escape_string($conn,stripslashes($art_idR))."',    
    '".mysqli_real_escape_string($conn,stripslashes($art_idP))."',    
    '".mysqli_real_escape_string($conn,stripslashes($art_idC))."',    
    '".mysqli_real_escape_string($conn,stripslashes($art_idM))."',    
    '".mysqli_real_escape_string($conn,stripslashes($art_idQ))."'    
    )";
    $query=mysqli_query($conn,$sql);
}
*/
    
// tab: articoli_txt
    $sql = 
    "
    INSERT INTO articoli_txt
    (idArt,testo) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '".mysqli_real_escape_string($conn,stripslashes($art_testo))."'
    )";
    $query=mysqli_query($conn,$sql);
    
    
// se articolo viene pubblicato on line subito, tutta i dati nella sessione vengono azzerati 
if ($art_osc=="n") {
$art_titolo=""; $_SESSION['art_titolo']=""; 
$art_testo=""; $_SESSION['art_testo']="";
$art_img=""; $_SESSION['art_img']="";  
$art_idMacro=""; $_SESSION['art_idMacro']=""; 
$art_macro=""; $_SESSION['art_macro']=""; 
$art_idR=$idR; $_SESSION['art_idR']=$art_idR; 
$art_idP=$idP; $_SESSION['art_idP']=$art_idP; 
$art_idC=$idC; $_SESSION['art_idC']=$art_idC; 
$art_idM=$idM; $_SESSION['art_idM']=$art_idM; 
$art_idQ=$idQ; $_SESSION['art_idQ']=$art_idQ; 
$art_promozione="n"; $_SESSION['promozione']="n";
$art_dataReg=""; $_SESSION['art_dataReg']="";
$art_id=0; $_SESSION['art_id']=0;
$art_osc="s"; $_SESSION['art_osc']="s";
}

// torna a articoli
//header("location: index.php");  
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='index.php';\n"; 
  echo "</script>"; 
?>
