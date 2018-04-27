<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// leggi db / crea eventuali thumb
$eventi=$mysql->elenco_eventi($conn,$idAttivita,$url);
$totEventi=$eventi['totEventi'][0];

// struttura html
$title="Admin ".$attivita." - Eventi";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1 class="rosso">Eventi</h1>
<p>Appuntamenti, corsi, esibizioni, manifestazioni, performance e in genere tutto ci&ograve; che può accadere in un certo punto ad un certo momento.<br /><br /></p>
<p><a href="nuovo.php"><input type="button" name="crea" value="CREA NUOVO" class="bottSubmit" /></a><br /> Clicca sul bottone qui sopra se desideri aggiungere un nuovo evento.<br /><br /><br /></p>
<?php
if ($totEventi>0) { 
print "<p class='testo riquadro'>Finora hai pubblicato <strong>".$totEventi." eventi</strong>.<br /> Per modificare o cancellare un evento clicca sopra il titolo.</p>"; 
} 
?>
<br /><br />
</div>
<div class="colonna-1-2">
<?php
if ($totEventi>0) { 
for ($i=1;$i<count($eventi['id']);$i++) {
	print "<p><a href='eventiModif.php?id=".$eventi['id'][$i]."'>";
        $icoart=$url."locandine/ico_".$eventi['img'][$i];
        if (file_exists($icoart) && $eventi['img'][$i]!=""){
        print "<img src='".$url."locandine/ico_".$eventi['img'][$i]."' alt='' class='sx thumb'>";
        }
    print "<h5>".ucfirst($eventi['titolo'][$i])."</h5></a>";
    if (isset($eventi['dataInizio'][$i])) {
    print " - Periodo evento: dalle ore ".$eventi['oreInizio'][$i];
            if ($eventi['dataInizio'][$i]==$eventi['dataFine'][$i]) {
            print " alle ore ".$eventi['oreFine'][$i]." del giorno <strong>".$myobj->visData($eventi['dataFine'][$i])."</strong>";    
            }
            else {
            print " del <strong>".$myobj->visData($eventi['dataInizio'][$i])."</strong> alle ore ".$eventi['oreFine'][$i]." del <strong>".$myobj->visData($eventi['dataFine'][$i])."</strong>";
            }	
    print "<br /><br /><br /></p>";        
            
    }
    
}
}
?>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>

