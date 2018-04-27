<<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";

if (isset($_FILES['newImg']['name']) && $_FILES['newImg']['name']!="") {

        $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
        $file_size = $_FILES['newImg']['size'];// restituisce la grandezza del file
   
		// nome temporaneo       
        $nomedir="nuovafoto.".$ext;
        $urlFile=$url.$cartella."/foto/".$nomedir;

		// controlli
        if ($msgErr=="" && $file_size==0){
            $msgErr="Il server non riesce a caricare il file e/o a completare l'operazione. Prova a cambiare immagine.";
            }
        if ($msgErr==""){ $msgErr=$myobj->ctrlExtFile($ext,"jpg"); } // formato unico ammesso 
        if ($msgErr==""){ $msgErr=$myobj->ctrlPesoFile($file_size,2); } // limite peso 


   // se tutto ok, aggiungi subito al db
        if ($msgErr==""){
	       $sql = 
   		 "
	   	 INSERT INTO vetrine_foto
   	 	(id,idAttivita,foto,didasc) 
		    VALUES 
		    ( 
		    default,
		    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
		    'nuovafoto',
		    ''
		    )";
    		$query=mysqli_query($conn,$sql);
    // id nuovo
   		$idNuovoINS=mysqli_insert_id($conn);

		// nome definitivo       
        $nomedir=$idNuovoINS.".".$ext;
        $urlFile=$url.$cartella."/foto/".$nomedir;

	   // cambia nome file
	   rename($_FILES['newImg']['tmp_name'], $urlFile);
	   $loadImg=$nomedir;

	   // crea thumb
	   $dirFile=$url.$cartella."/foto/";
	   $myobj->creathumb($dirFile,$loadImg,200,200,$dirFile,"th_");
      $myobj->creathumb($dirFile,$loadImg,48,48,$dirFile,"ico_");

		// aggiorna db
      $sql="UPDATE vetrine_foto SET 
	  foto='".mysqli_real_escape_string($conn,stripslashes($loadImg))."'
	  WHERE id='".$idNuovoINS."'";
      $query=mysqli_query($conn,$sql);
      
   // passa automaticamente al prossimo step
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='fotoModif.php?id=".$idNuovoINS."';\n"; 
  echo "</script>";
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

<form id="nuovaImg" method="post" enctype="multipart/form-data" action="?">

  <p><input type="file" name="newImg" value="" style="width:250px; font-size:16px" /></p>
  <p><input type="submit" name="salva" value="CARICA" class="bottSubmit" /></p>

</form>
<?php
if (isset($msgErr) &&  $msgErr!=""){
    print "<br/><div class='rosso'>".$msgErr."</div>";
    }
?> 

<br /><br />
<p>Torna al <a href="foto.php">Menu foto</a> | Torna all'<a href="../">Inizio</a></p>
Passa a <a href="fotoMultiple.php">Foto multiple</a> se preferisci aggiungere <b>pi&ugrave; foto</b> per volta<br/><br/>

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
