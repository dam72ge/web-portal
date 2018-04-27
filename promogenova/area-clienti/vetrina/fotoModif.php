<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// id
if(!isset($_GET['id'])){
	header("location: foto.php");
}
$id=$_GET['id'];
// seleziona foto
$sql="SELECT idAttivita,foto,didasc FROM vetrine_foto WHERE id='".$id."'";
$query=mysqli_query($conn,$sql);			
$q=mysqli_fetch_array($query,MYSQLI_ASSOC);
$foto=$q['foto'];
$didasc=$q['didasc'];
if($idAttivita!=$q['idAttivita']){
header("location: foto.php");
}

// reg su db
$msgErr="";
$msgSalv="";


// img: data+estensione
$loadImg="";
if (isset($_FILES['newImg']['name'])){
    // controlli    
   $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));

   $file_size = $_FILES['newImg']['size'];// restituisce la grandezza del file
   //print $ext." - ".$_FILES['newImg']['name']." - ".$_FILES['newImg']['size']." - ".$file_size; exit;
   
   if ($msgErr=="" && $_FILES['newImg']['name']==""){
    $msgErr="Non hai caricato alcun file!";
    }
   if ($msgErr=="" && $file_size==0){
    $msgErr="Il server non riesce a caricare il file e/o a completare l'operazione. Prova a cambiare immagine.";
    }
   if ($msgErr==""){ $msgErr=$myobj->ctrlExtFile($ext,"jpg"); }// formato unico ammesso 
   if ($msgErr==""){ $msgErr=$myobj->ctrlPesoFile($file_size,2); }// limite peso 


   // copia il file
   if ($msgErr==""){
   $nomedir = $_FILES['newImg']['name'];
   $nomedir=trim(strtolower($nomedir));
   $lunghezza=strlen($nomedir);
   if ($lunghezza>120){ $nomedir=substr($nomedir,0,120); }
   $nomedir= @preg_replace("/[^\w\.]/", "_", $nomedir);
   $nomedir=$nomedir;
   $urlFile=$url.$cartella."/foto/".$nomedir;
   // salva file
   @rename($_FILES['newImg']['tmp_name'], $urlFile);
   $loadImg=$nomedir;
   // crea thumb 
   $dirFile=$url.$cartella."/foto/";
   $myobj->creathumb($dirFile,$loadImg,200,200,$dirFile,"th_");
    }
}

// RIMUOVI
if (isset($_POST['selImg']) && $_POST['selImg']=="s") {
   $urlFile=$url.$cartella."/foto/".$foto;
   if (file_exists($urlFile)) { unlink($urlFile);}
   $urlFile=$url.$cartella."/foto/th_".$foto;
   if (file_exists($urlFile)) { unlink($urlFile);}
   $loadImg==""; 
      $sql="DELETE FROM vetrine_foto WHERE id='".$id."'";
      $query=mysqli_query($conn,$sql);      
      $_POST['upd']="rimossa";
      $msgSalv="La foto &egrave; stata rimossa.";
}

// MODIFICA 
if (isset($_POST['upd']) && $_POST['upd']=="s") {
    
    // immagine
    if ($loadImg==""){
    $loadImg=$foto;
    }

    // SALVATAGGIO
    if ($msgErr==""){

      $sql="UPDATE vetrine_foto SET 
	  foto='".mysqli_real_escape_string($conn,stripslashes($loadImg))."',
	  didasc='".mysqli_real_escape_string($conn,stripslashes($_POST['didasc']))."'
	  WHERE id='".$id."'";
      $query=mysqli_query($conn,$sql);
      
      $msgSalv="Le modifiche sono state salvate.";
    }
}


// struttura html
$title="Admin ".$attivita." - Foto #".$id;
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Modifica foto</h4><br />
<?php
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {

        print "<form id='modifFoto' method='post' enctype='multipart/form-data' action='?id=".$id."' class='riquadro'>";
        if ($foto!="") {
            print "<p><img src='".$url.$cartella."/foto/".$foto."' alt='foto' class='scala' /></p>";
            print "<label>Rimuovere questa foto?</label><br />";
            print "<select name='selImg' option='1'>";
            print "<option value='n' selected>No, mantienila</option>";
            print "<option value='s'>S&igrave;, rimuovila dal database</option>";
            print "</select></p>";
        } 
        else{            
            print "<input type='file' name='newImg' value='' class='bottFile' /></p>";
            print "<p class='button'>Carica un banner</p>";
        } 

        print "<p><label>Didascalia</label><br /><textarea name='didasc' rows='3' cols='30'>".$didasc."</textarea></p>";
        print "<input type='hidden' name='upd'' value='s' />";
        print "<p><input type='submit' name='salva' value='SALVA' class='bottSubmit' /></p>";
        print "</form>";

}
else{
print "<h2 class='verde'>".$msgSalv."</h2>";
if($_POST['upd']!="rimossa"){ print " <a href='?id=".$id."'>Visualizza e modifica di nuovo</a>";}
}
?>
<p>Torna al <a href="foto.php">Menu foto</a> | Torna all'<a href="../">Inizio</a></p>
</div>
<div class="colonna-1-2">
<p class="testo">Per essere accettata, l'immagine deve essere in formato JPG e non deve pesare pi&ugrave; di 2 MB.<br /><br />
</p>
<p>
Altre foto (clicca sulle singole immagini per selezionare):<br /><br />
<?php
// link altre foto
    $sql1="SELECT id,foto FROM vetrine_foto WHERE idAttivita='".$idAttivita."' AND id!='".$id."' ORDER BY id ASC";
    $query1=mysqli_query($conn,$sql1);			
    while($altre=mysqli_fetch_array($query1,MYSQLI_ASSOC)){    
       print "<a href='fotoModif.php?id=".$altre['id']."'><img src='".$url.$cartella."/foto/ico_".$altre['foto']."' alt='' class='thumb'></a>";
   }

?>
</p>
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
