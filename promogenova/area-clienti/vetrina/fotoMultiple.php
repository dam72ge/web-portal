<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$imgCaricate=0;
$msgErr=array("");
$fileSalv=array("");

// data+estensione
if (isset($_FILES['userfile']['name'])){

  for($i=0;$i<count($_FILES['userfile']);$i++){
  $msgErr[$i]="";
  $fileSalv[$i]="";

    // controlli    
   $ext=strtolower(pathinfo($_FILES['userfile']['name'][$i],PATHINFO_EXTENSION));
   $file_size = $_FILES['userfile']['size'][$i];// restituisce la grandezza del file
   if ($msgErr[$i]=="" && $_FILES['userfile']['name'][$i]==""){
   $msgErr[$i]="Non hai caricato alcun file!";
   }
   if ($msgErr[$i]=="" && $file_size==0){
   $msgErr[$i]="Il server non riesce a caricare il file e/o a completare l'operazione. Prova a cambiare immagine.";
   }
   if ($msgErr[$i]==""){ $msgErr[$i]=$myobj->ctrlExtFile($ext,"jpg"); }// formato unico ammesso 
   if ($msgErr[$i]==""){ $msgErr[$i]=$myobj->ctrlPesoFile($file_size,2); }// limite peso 

   // nome del file
   if ($msgErr[$i]==""){
   $nomedir = $_FILES['userfile']['name'][$i];
   $nomedir=trim(strtolower($nomedir));
   $lunghezza=strlen($nomedir);
   if ($lunghezza>120){ $nomedir=substr($nomedir,0,120); }
   $nomedir= @preg_replace("/[^\w\.]/", "_", $nomedir);
   $nomedir=$nomedir;
   $urlFile=$url.$cartella."/foto/".$nomedir;

   // no doppioni
   $sqldopp="SELECT foto FROM vetrine_foto WHERE foto LIKE '".$nomedir."'";
   $querydopp=mysqli_query($conn,$sqldopp);
   $dopp=mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
   if ($dopp['foto']!=""){ $msgErr[$i]="Esiste gi&agrave; un file con questo nome!"; }
   } 

   // salva file
   if ($msgErr[$i]==""){ 
   @rename($_FILES['userfile']['tmp_name'][$i], $urlFile);
   $loadImg=$nomedir;
   // crea thumb
   $dirFile=$url.$cartella."/foto/";
   $myobj->creathumb($dirFile,$loadImg,200,200,$dirFile,"th_");
   $n=$i+1;
   $fileSalv[$i]="File numero ".$n." caricato.";
   // aggiungi db
       $sql = 
    "
    INSERT INTO vetrine_foto
    (id,idAttivita,foto,didasc) 
    VALUES 
    ( 
    default,
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '".mysqli_real_escape_string($conn,stripslashes($loadImg))."',
    ''
    )";
    $query=mysqli_query($conn,$sql);
    // id nuovo
   	$idNuovoINS=mysqli_insert_id($conn);
   }
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
<h4>Aggiungi foto</h4><br />
<?php
if (!isset($_POST['upd'])){
?>
<form id="nuovoLogo" method="post" enctype="multipart/form-data" action="?">
  <p><input type="file" name="userfile[]" value="" style="width:250px; font-size:16px" /></p>
  <p><input type="file" name="userfile[]" value="" style="width:250px; font-size:16px" /></p>
  <p><input type="file" name="userfile[]" value="" style="width:250px; font-size:16px" /></p>
  <p><input type="file" name="userfile[]" value="" style="width:250px; font-size:16px" /></p>
  <p><input type="file" name="userfile[]" value="" style="width:250px; font-size:16px" /></p>
  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="INVIA" class="bottSubmit" onclick="javascript:this.disabled=true;this.value='Loading...';document.nomeForm.submit();" /> 
  <input type="reset" name="reset" value="ANNULLA" class="bottSubmit" /></p>
</form>
<?php
}
  else{

  for($i=0;$i<5;$i++){
    $n=$i+1;

    if ($fileSalv[$i]!=""){
    print "<p><span class='verde'><strong>".$fileSalv[$i]."</strong></span></p>";
    } 
        
    if ($msgErr[$i]!=""){
    print "<p><span class='rosso'>Fle numero ".$n.": ".$msgErr[$i]."</span></p>";
    } 

  }
  
  print "<br /><br /><p class='testo'>Clicca <a href='foto.php'>QUI</a> se vuoi aggiungere didascalie, rimuovere e/o modificare le immagini che hai pubblicato, oppure clicca <a href='fotoNuove.php'>QUI</a> se desideri caricare altre immagini ancora.</p>";
}
?>
<br /><br />
<p>Torna al <a href="foto.php">Menu foto</a> | Torna all'<a href="../">Inizio</a></p>
Passa a <a href="fotoNuove.php">Foto singole</a> se preferisci aggiungere <b>una sola foto</b> per volta<br/><br/>
</div>
<div class="colonna-1-2">
<p class="testo">Scegli con cura le tue <span class="nero"><strong>foto</strong></span>: esse sono una sorta di <span class="verde">biglietto da visita della tua Attivit&agrave;</span>. Cerca di pubblicare le pi&ugrave; significative, dai risalto a quelle che caratterizzano maggiormente e ''raccontano'' meglio il tuo negozio o la tua professione.<br /><br />
Per essere accettata, ogni singola immagine deve essere in formato JPG e non deve pesare pi&ugrave; di 2 MB.<br />
</p>
<p>Campi obbligatori: nessuno.
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
