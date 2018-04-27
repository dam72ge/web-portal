<?php
// id
if (!isset($_GET['id'])) {
header ("location: index.php");
}
$id=$_GET['id'];

$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// riconosci cliente
$cfrAtt=$mysql->cliente_eventi($conn,$id,$idAttivita);
if ($idAttivita!=$cfrAtt) {
header ("location: index.php");
}

// leggi db
    $sql="SELECT eventi.id,titolo,testo,anno,dataInizio,oreInizio,dataFine,oreFine,dataAvv,dataOsc
    FROM eventi,eventi_txt,eventi_dateore 
    WHERE eventi.id=eventi_dateore.id 
    AND eventi.id=eventi_txt.id  
    AND eventi.id='".$id."'";
    $query=mysqli_query($conn,$sql);
    $singolo=mysql_fetch_array($query);
    
// apri sessione
$ev_titolo=$singolo['titolo']; $_SESSION['ev_titolo']=$singolo['titolo'];
$ev_testo=$singolo['testo']; $_SESSION['ev_testo']=$singolo['testo'];
$ev_dataInizio=$singolo['dataInizio']; $_SESSION['ev_dataInizio']=$singolo['dataInizio'];
$ev_oreInizio=$singolo['oreInizio']; $_SESSION['ev_oreInizio']=$singolo['oreInizio'];
$ev_dataFine=$singolo['dataFine']; $_SESSION['ev_dataFine']=$singolo['dataFine'];
$ev_oreFine=$singolo['oreFine']; $_SESSION['ev_oreFine']=$singolo['oreFine'];
$ev_dataAvv=$singolo['dataAvv']; $_SESSION['ev_dataAvv']=$singolo['dataAvv'];
$ev_dataOsc=$singolo['dataOsc']; $_SESSION['ev_dataOsc']=$singolo['dataOsc'];
$ev_anno=$singolo['anno']; $_SESSION['ev_anno']=$singolo['anno'];
$ev_id=$id; $_SESSION['ev_id']=$id;

 // cerca img
    $sql="SELECT img
    FROM media,media_link 
    WHERE media.idMedia=media_link.idMedia
    AND media_link.id='".$id."'";
    $query=mysqli_query($conn,$sql);
    $singoloImg=mysql_fetch_array($query);
$ev_img=$singoloImg['img']; $_SESSION['ev_img']=$singolo['img'];  


// luogo evento
$ev_luogo="";

    $sql1="SELECT idR,idP,idC,idM,idQ
    FROM eventi_zone 
    WHERE id='".$id."'";
    $query1=mysqli_query($conn,$sql1);
    $zona=mysqli_fetch_array($query1,MYSQLI_ASSOC);
    $ev_idR=$zona['idR']; $_SESSION['ev_idR']=$ev_idR; 
    $ev_idP=$zona['idP']; $_SESSION['ev_idP']=$ev_idP; 
    $ev_idC=$zona['idC']; $_SESSION['ev_idC']=$ev_idC; 
    $ev_idM=$zona['idM']; $_SESSION['ev_idM']=$ev_idM; 
    $ev_idQ=$zona['idQ']; $_SESSION['ev_idQ']=$ev_idQ; 

    // ricarica elenchi
    $regioni=$myobj->regioni("","ORDER BY idR ASC");
    $province=$myobj->province("","ORDER BY idP ASC");
    $comuni=$myobj->comuni("","ORDER BY idC ASC");
    $municipi=$myobj->municipi("","ORDER BY idM ASC");
    $quartieri=$myobj->quartieri("","ORDER BY idQ ASC");
    
    if($ev_idR>0){$ev_luogo.=" Regione ".$regioni['regione'][$ev_idR];} else{$ev_luogo.="Tutta Italia ";}
    if($ev_idP>0){$ev_luogo.=" Provincia di ".ucwords($province['provincia'][$ev_idP]);} else{$ev_luogo.="Tutte le Province ";}
    if($ev_idC>0){$ev_luogo.=" Comune di ".ucwords($comuni['comune'][$ev_idC]);} else{$ev_luogo.="Tutti i Comuni ";}
    if($ev_idM>0){$ev_luogo.=" Municipio ".$municipi['municipio'][$ev_idM];} else{$ev_luogo.="Tutti i Municipi ";}
    if($ev_idQ>0){$ev_luogo.=" ".$quartieri['quartiere'][$ev_idQ];} else{$ev_luogo.=" ";}

$_SESSION['ev_luogo']=$ev_luogo; 

// struttura html
$title="Admin ".$attivita." - Evento ".$id." - ".$ev_titolo;
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h3 class="rosso">Modifica evento n.ro <?php print $id; ?></h3><br />
<p class="testo">
<?php
print "<p class='testo'>Puoi cambiare l'evento, annullarlo, tornare al Men&ugrave; Eventi o tornare all'inizio.<br /><br /></p>";  

print "Modifiche:<br /><br />";
//print "<a href='cambia-titolo.php?id=".$id."'><span class='verde'>Titolo</span></a><br />";
//print "<a href='cambia-date.php?id=".$id."'><span class='verde'>Date e orari</span></a><br />";
//DISATTIVATO! print "<a href='cambia-luogo.php?id=".$id."'><span class='verde'>Luogo</span></a><br />";
//print "<a href='cambia-testo.php?id=".$id."'><span class='verde'>Testo</span></a><br />";
//print "<a href='cambia-immagine.php?id=".$id."'><span class='verde'>Immagine</span></a><br />";
print "<p><a href='cambia-titolo.php?id=".$id."'><input type='button' name='titolo' value='Titolo' class='bottSubmit' /></a></p>";
print "<p><a href='cambia-date.php?id=".$id."'><input type='button' name='date' value='Date e orari' class='bottSubmit' /></a></p>";
print "<p><a href='cambia-testo.php?id=".$id."'><input type='button' name='testo' value='Testo' class='bottSubmit' /></a></p>";
print "<p><a href='cambia-immagine.php?id=".$id."'><input type='button' name='immagine' value='Immagine' class='bottSubmit' /></a></p>";
print "<br /><br />";

print "Azioni sull'evento:<br/><br/>";  
print "<p><a href='elimina.php?idArt=".$id."'><input type='button' name='elimina' value='Annulla evento' class='bottSubmit' /></a></p>";
print "<p><a href='index.php'><input type='button' name='menu' value='Menu Eventi' class='bottSubmit' /></a></p>";
print "<p><a href='../index.php'><input type='button' name='inizio' value='Inizio' class='bottSubmit' /></a></p>";
//print "<h4><a href='elimina.php?id=".$id."'>Eliminalo</a></h4>";
//print "<h4><a href='index.php'>Torna al Men&ugrave; eventi</a></h4>";
?>

<br /><br />
</div>
<div class="colonna-1-2">
<p>&nbsp;&nbsp;Anteprima dell'Evento</p>
<div class="riquadro">
<?php 
if ($ev_img!="") {
print "<img src='".$url."locandine/th_".$ev_img."' alt='antep' title='immagine allegata' class='dx thumb scala'>";	
}
$txtConv=$myobj->mb_convert_encoding($ev_titolo);
print "<h4><span class='viola'>".$txtConv."</span></h4>";

print "<span class='grigio'>Periodo: </span> ";
print "Dalle ore ".$ev_oreInizio." del ";
if ($ev_dataInizio!="") { print "<span class='arancio'>".$myobj->visData($ev_dataInizio)."</span> "; }
print "alle ore ".$ev_oreFine." del ";
if ($ev_dataFine!="") { print "<span class='arancio'>".$myobj->visData($ev_dataFine)."</span> "; }
print "</span><br />";
print "<br />";

print "<span class='grigio'>Luogo: </span> ";
$txtConv=$myobj->mb_convert_encoding($ev_luogo);
print "<span class='verde'>".ucfirst($txtConv)."</span> <span class='rosso'>[non modificabile]</span><br />";
print "<br /><br />";
$txtConv=$myobj->mb_convert_encoding($ev_testo);
print "</span><span class='testo'>".$txtConv."</span>";
?>
<br /><br />
<br /><br />
</div>
</div>
</div>
<?php
include "../footer.php";
?>

