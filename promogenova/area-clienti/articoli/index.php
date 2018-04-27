<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// leggi db / crea eventuali thumb
$articoli=$mysql->elenco_articoli($idAttivita,$url,$cartella);
$totArticoli=$articoli['totArticoli'][0];

// struttura html
$title="Admin ".$attivita." - Articoli";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1 class="rosso">Articoli</h1>
<p>Prodotti, articoli, servizi, forniture e in genere tutto ci&ograve; che normalmente offri ai tuoi clienti o puoi mettere loro a disposizione, senza limitazioni di tempo.<br /><br /></p>
<p><a href="nuovo.php"><input type="button" name="crea" value="CREA NUOVO" class="bottSubmit" /></a><br /> Clicca sul bottone qui sopra se desideri aggiungere un nuovo articolo.<br /><br /><br /></p>
<?php
if ($totArticoli>0) { 
print "<p class='testo riquadro'>Finora hai pubblicato <strong>".$totArticoli." articoli</strong>.<br /> Per modificare un articolo clicca sopra il titolo.</p>"; 
} 
?>
<br /><br />
</div>
<div class="colonna-1-2">
<?php
if ($totArticoli>0) { 
for ($i=1;$i<count($articoli['idArt']);$i++) {
	print "<p><a href='articoliModif.php?idArt=".$articoli['idArt'][$i]."'>";
        $icoart=$url.$cartella."/articoli/ico_".$articoli['img'][$i];
        if (file_exists($icoart) && $articoli['img'][$i]!=""){
        print "<img src='".$url.$cartella."/articoli/ico_".$articoli['img'][$i]."' alt='' class='sx thumb'>";
        }
 
    //$txtConv=$myobj->mb_convert_encoding($articoli['titolo'][$i]);
    print "<h5>".ucfirst($articoli['titolo'][$i])."</h5></a>";

    print "Stato dell'articolo: ";
    if ($articoli['osc'][$i]=="n") {
        print "<span class='verde'>Attivo</span> (Visibile a tutti)";	
        }
        else{
        print "<span class='rosso'>DISATTIVATO (Visibile solo a te)</span>";	
        }
    
        print " - Pubblicazione: ".$myobj->visData($articoli['dataReg'][$i])."<br /><br /></p>";
        }
}
?>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>

