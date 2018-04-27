<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";


// tab: eventi
    $sql = 
    "
    INSERT INTO eventi
    (id,home,titolo,img) 
    VALUES 
    ( 
    '',
    'n',
    '".mysqli_real_escape_string($conn,stripslashes($ev_titolo))."',
    ''
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovo=mysqli_insert_id($conn);

   $_SESSION['ev_id']=$idNuovo;

// se sono state caricate immagini, cambia nomi e adegua il db
if ($ev_img!="") {

	// media, medialink
    $sql = 
    "
    INSERT INTO media
    (idMedia,img) 
    VALUES 
    ( 
    '',
    ''
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo media
   	$idNuovoMedia=mysqli_insert_id($conn);
   	
	// salva file -> nuovo nome = id media
   $dirFile=$url.$cartella."/";
   $urlFile=$url.$cartella."/".$ev_img;
   $ext=strtolower(pathinfo($urlFile,PATHINFO_EXTENSION));
   $nuovoNome=$idNuovoMedia.".".$ext;
   $nuovoFile=$url."/locandine/".$nuovoNome;
   if (file_exists($urlFile)) { rename($urlFile,$nuovoFile); }   
   $urlFile=$url.$cartella."/th_".$ev_img;
   $nuovoFile=$url."/locandine/th_".$nuovoNome;
   if (file_exists($urlFile)) { rename($urlFile,$nuovoFile); }   
   $urlFile=$url.$cartella."/ico_".$ev_img;
   $nuovoFile=$url."/locandine/ico_".$nuovoNome;
   if (file_exists($urlFile)) { rename($urlFile,$nuovoFile); }   
   $ev_img=$nuovoNome;
   $_SESSION['ev_img']=$nuovoNome;

	// aggiorna media
   $sql="UPDATE media SET  
   img='".$nuovoNome."' 
   WHERE idMedia='".$idNuovoMedia."'";
   $query=mysqli_query($conn,$sql);

	// aggiorna eventi
   $sql="UPDATE eventi SET  
   img='".mysqli_real_escape_string($conn,stripslashes($ev_img))."' 
   WHERE id='".$idNuovo."'";
   $query=mysqli_query($conn,$sql);

   $_SESSION['ev_img']="";

	// media link
    $sql = 
    "
    INSERT INTO media_link
    (idML,idMedia,id,idAlbum,idVideo) 
    VALUES 
    ( 
    '',
    '".$idNuovoMedia."',
    '".$idNuovo."',
    '0',
    '0'
    )";
    $query=mysqli_query($conn,$sql);
}

// tab: eventi_txt
    $sql = 
    "
    INSERT INTO eventi_txt
    (id,testo) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '".mysqli_real_escape_string($conn,stripslashes($ev_testo))."' 
    )";
    $query=mysqli_query($conn,$sql);

// tab: eventi_link
    $sql = 
    "
    INSERT INTO eventi_link
    (id,url) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    ''
    )";
    $query=mysqli_query($conn,$sql);

// tab: eventi_promot
    $sql = 
    "
    INSERT INTO eventi_promot
    (idEvento,id,idAttivita,idRete) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '0'
    )";
    $query=mysqli_query($conn,$sql);

// tab: eventi_zone
    $sql = 
    "
    INSERT INTO eventi_zone
    (id,idR,idP,idC,idM,idQ) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '".mysqli_real_escape_string($conn,stripslashes($ev_idR))."',    
    '".mysqli_real_escape_string($conn,stripslashes($ev_idP))."',    
    '".mysqli_real_escape_string($conn,stripslashes($ev_idC))."',    
    '".mysqli_real_escape_string($conn,stripslashes($ev_idM))."',    
    '".mysqli_real_escape_string($conn,stripslashes($ev_idQ))."'    
    )";
    $query=mysqli_query($conn,$sql);

// tab: eventi_dateore
    $sql = 
    "
    INSERT INTO eventi_dateore
    (id,anno,dataInizio,oreInizio,dataFine,oreFine,dataAvv,dataOsc) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '".mysqli_real_escape_string($conn,stripslashes($ev_anno))."', 
    '".mysqli_real_escape_string($conn,stripslashes($ev_dataInizio))."', 
    '".mysqli_real_escape_string($conn,stripslashes($ev_oreInizio))."', 
    '".mysqli_real_escape_string($conn,stripslashes($ev_dataFine))."', 
    '".mysqli_real_escape_string($conn,stripslashes($ev_oreFine))."', 
    '".mysqli_real_escape_string($conn,stripslashes($ev_dataAvv))."', 
    '".mysqli_real_escape_string($conn,stripslashes($ev_dataOsc))."'
    )";
    $query=mysqli_query($conn,$sql);

    
// se evento viene pubblicato on line subito, tutti i dati nella sessione vengono azzerati 
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

$ev_idR=$idR; $_SESSION['ev_idR']=$ev_idR; 
$ev_idP=$idP; $_SESSION['ev_idP']=$ev_idP; 
$ev_idC=$idC; $_SESSION['ev_idC']=$ev_idC; 
$ev_idM=$idM; $_SESSION['ev_idM']=$ev_idM; 
$ev_idQ=$idQ; $_SESSION['ev_idQ']=$ev_idQ; 
$ev_luogo=""; $_SESSION['ev_luogo']="";

// torna a eventi
//header("location: index.php");  
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='index.php';\n"; 
  echo "</script>"; 
?>
