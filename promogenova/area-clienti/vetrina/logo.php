<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";
$msgSalv="";


// banner: data+estensione
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
   $nomeImg="logo.".$ext;
   $dirFile=$url.$cartella."/";
   $urlFile=$url.$cartella."/".$nomeImg;
   // salva file
   @rename($_FILES['newImg']['tmp_name'], $urlFile);
   // crea thumb e icona

       $thumb=$url.$cartella."/th_".$nomeImg;
       if (!file_exists($thumb)) { 
       $myobj->creathumb($dirFile,$nomeImg,200,200,$dirFile,"th_");
       }
       $icofoto=$url.$cartella."/ico_".$nomeImg;
       if (!file_exists($icofoto)) { 
       $myobj->creathumb($dirFile,$nomeImg,48,48,$dirFile,"ico_");
       }

    $loadImg=$nomeImg;
    }
}

// RIMUOVI SOLO IMG
if (isset($_POST['selImg']) && $_POST['selImg']=="s") {
   $urlFile=$url.$cartella."/".$logo;
   if (file_exists($urlFile)) { unlink($urlFile);}
   
   $loadImg==""; $_POST['oldImg']="";
      $sql="UPDATE vetrine SET 
	  logo=''
	  WHERE idAttivita='".$idAttivita."'";
      $query=mysqli_query($conn,$sql);
      
      $_SESSION['logo']=""; 
      $logo="";      
      $_POST['upd']="n";
      $msgSalv="Il logo &egrave; stato rimosso.";
}

// MODIFICA 
if (isset($_POST['upd']) && $_POST['upd']=="s") {
    
    // immagine
    if ($loadImg==""){
    $loadImg=$logo;
    }

    // SALVATAGGIO
    if ($msgErr==""){

      $sql="UPDATE vetrine SET 
	  logo='".mysqli_real_escape_string($conn,stripslashes($loadImg))."'
	  WHERE idAttivita='".$idAttivita."'";
      $query=mysqli_query($conn,$sql);
      
      $_SESSION['logo']=$loadImg; 
      $logo=$loadImg;      
      $_POST['id']=0;
      $msgSalv="Le modifiche sono state salvate.";
    }
}


// struttura html
$title="Admin ".$attivita." - Logo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Logo</h4><br />
<?php
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($logo!="") {
if ($msgSalv=="") {

        print "<form id='modifLogo' method='post' enctype='multipart/form-data' action='?' class='riquadro'>";
        if ($logo!="") {
            print "<p><img src='".$url.$cartella."/".$logo."' alt='logo' class='scala' /><br />";
            print "<label>Rimuovere questo logo?</label><br />";
            print "<select name='selImg' option='1'>";
            print "<option value='n' selected>No, mantienilo</option>";
            print "<option value='s'>S&igrave;, rimuovilo dal database</option>";
            print "</select></p>";
        } 
        else{            
            print "<input type='file' name='newImg' value='' class='bottFile' /></p>";
            print "<p class='button'>Carica un banner</p>";
        } 

        print "<input type='hidden' name='upd'' value='s' />";
        print "<p><input type='submit' name='salva' value='SALVA' class='bottSubmit' /></p>";
        print "</form>";
        print "<p><a href='../'>Torna all'inizio</a></p>";
}
else{
print "<h2 class='verde'>".$msgSalv."</h2>";
print "<a href='../'>Torna al Men&ugrave; principale</a> oppure <a href='?'>Visualizza e modifica di nuovo.</a><br /><br />";	
}
}
if ($logo=="") {
?>
<h5 class="verde">Aggiungi un Logo</h5>
<form id="nuovoLogo" method="post" enctype="multipart/form-data" action="?">
  <input type="file" name="newImg" value="" />
  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<p>Torna all'<a href="../">Inizio</a></p>
<br /><br /><br />
<?php
}
?>
</div>
<div class="colonna-1-2">
<p class="testo">Per essere accettata, l'immagine deve essere in formato JPG e non deve pesare pi&ugrave; di 2 MB.<br />
</p>
<p>Campi obbligatori: nessuno.
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
