<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// leggi db / crea eventuali thumb
$totFoto=0;
    $foto=array(
	"id" => array (""),
	"foto" => array ("")
    );

    $sql="SELECT id,foto FROM vetrine_foto WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $foto['id'][]=$q['id'];
    $foto['foto'][]=$q['foto'];
    
       $dirFile=$url.$cartella."/foto/";
       $imgFile=$dirFile."/".$q['foto'];
       $thumb=$url.$cartella."/foto/th_".$q['foto'];
       $icofoto=$url.$cartella."/foto/ico_".$q['foto'];
       if (file_exists($imgFile)) { 
       $totFoto++;
       if (!file_exists($thumb)) { 
       $myobj->creathumb($dirFile,$q['foto'],200,200,$dirFile,"th_");
       }
       if (!file_exists($icofoto)) { 
       $myobj->creathumb($dirFile,$q['foto'],48,48,$dirFile,"ico_");
       }
       }
   }

// struttura html
$title="Admin ".$attivita." - Foto";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Fotogallery</h4><br />
<?php
print "Gestisci la fotogallery della tua vetrina<br/><br/>";
print "<p><a href='fotoNuove.php'><input type='button' name='menu' value='AGGIUNGI FOTO' class='bottSubmit' /></a></p>";
print "<p><a href='../'><input type='button' name='menu' value='Inizio' class='bottSubmit' /></a></p>";

?>
<br /><br />
</div>
<div class="colonna-1-2">
<?php
if ($totFoto>0) { 
print "<p class='testo nero'></p>Finora hai pubblicato <b>".$totFoto." immagini</b>.<br/>Se vuoi rimuoverne o modificarne le didascalie, clicca sulle singole immagini.<br /><br /></p>";

for ($i=1;$i<count($foto['id']);$i++) {
	print "<a href='fotoModif.php?id=".$foto['id'][$i]."'><img src='".$url.$cartella."/foto/th_".$foto['foto'][$i]."' alt='' class='scala thumb'></a>";
}
}
?>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>

