<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";

// controllo campi vuoti (titolo, categoria, testo)
if ($ev_testo=="") { $msgErr="manca il testo.";}
if ($ev_titolo=="") { $msgErr="non &egrave; stato inserito il titolo.";}

// struttura html
$title="Admin ".$attivita." - Nuovo evento - Step 6 di 6: Anteprima e Pubblicazione";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Evento - Passaggio 6 di 6: Pubblicazione</h4>
<a href="nuovo.php">1 Titolo</a> | 
<a href="nuovo-date.php">2 Date</a> | 
<a href="nuovo-luogo.php">3 Luogo</a> | 
<a href="nuovo-testo.php">4 Testo</a> | 
<a href="nuovo-immagine.php">5 Immagine</a> | 
<a href="nuovo-pubblica.php">6 Anteprima e Pubblicazione</a>
<br /><br /><br />

<?php 
if ($msgErr=="") {
?>
<p class="testo">Scegli che cosa vuoi fare del nuovo evento:</p><br />
<p><a href="salva.php"><input type="button" name="online" value="PUBBLICA" class="bottSubmit" /></a><br /> Pubblica subito. L'evento sar&agrave; immediatamente visibile <em>on line</em></p>
<?php
}
else{
print "<p class='testo'>L'evento non pu&ograve; venire salvato n&eacute; pubblicato perch&eacute; incompleto: <span class='rosso'>".$msgErr."</span>.<br /><br /></p>";   
}
?>

<p><a href="cancella.php"><input type="button" name="cancella" value="CANCELLA" class="bottSubmit" /></a><br /> Cancella tutti i dati finora inseriti e ricomincia daccapo.</p>

<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p>&nbsp;&nbsp;Anteprima dell'Articolo</p>
<div class="riquadro">
<?php 
if ($ev_img!="") {
print "<img src='".$url.$cartella."/th_".$ev_img."' alt='antep' title='anteprima immagine allegata' class='dx thumb scala'>";	
}
print "<h4><span class='grigio'>[Titolo:]</span> <span class='viola'>".$ev_titolo."</span></h4>"; 

print "<span class='grigio'>[Periodo:]</span> ";
//print $_SESSION['ev_dataInizio'].", ".$_SESSION['ev_oreInizio']."<br />";
//print $_SESSION['ev_dataFine'].", ".$_SESSION['ev_oreFine']."<br />";
print "Dalle ore ".$ev_oreInizio." del <span class='arancio'>".$myobj->visData($ev_dataInizio)."</span> ";
print "alle ore ".$ev_oreFine." del <span class='arancio'>".$myobj->visData($ev_dataFine)."</span><br />";
print "<br />";
print "<span class='grigio'>[Luogo:]</span> <span class='verde'>".ucfirst($ev_luogo)."</span><br />";
print "<br /><br />";
print "<span class='grigio'>[Testo:]</span><span class='testo'>".$ev_testo."</span>";
?>
<br /><br />
</div>
<br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
