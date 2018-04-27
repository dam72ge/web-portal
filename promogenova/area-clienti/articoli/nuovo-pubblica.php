<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";

// controllo doppioni
$sqldopp="SELECT titolo FROM articoli WHERE titolo LIKE '".$art_titolo."'";
$querydopp=@mysqli_query($conn,$sqldopp);
$dopp=@mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
if ($dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un articolo con questo titolo!"; }

// controllo campi vuoti (titolo, categoria, testo)
if ($art_macro=="") { $msgErr="non &egrave; stata selezionata una categoria commerciale.";}
if ($art_testo=="") { $msgErr="manca il testo.";}
if ($art_titolo=="") { $msgErr="non &egrave; stato inserito il titolo.";}

// struttura html
$title="Admin ".$attivita." - Nuovo articolo - Step 5 di 5: Anteprima e Pubblicazione";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Articolo - Passaggio 5 di 5: Pubblicazione</h4>
<a href="nuovo.php">1 Titolo</a> | 
<a href="nuovo-testo.php">2 Testo</a> | 
<a href="nuovo-immagine.php">3 Immagine</a> | 
<a href="nuovo-categoria.php">4 Categoria comm.le</a> | 
<a href="nuovo-pubblica.php">5 Anteprima e Pubblicazione</a>
<br /><br /><br />

<?php 
if ($msgErr=="") {
?>
<p class="testo">Scegli che cosa vuoi fare del nuovo articolo:</p><br />
<p><a href="salva.php"><input type="button" name="bozza" value="SALVA IN BOZZA" class="bottSubmit" /></a><br /> Scelta consigliata. Potrai rivedere e correggere l'articolo prima di pubblicarlo <em>on line</em></p>
<p><a href="online.php"><input type="button" name="online" value="PUBBLICA" class="bottSubmit" /></a><br /> Pubblica subito. L'articolo sar&agrave; immediatamente visibile <em>on line</em></p>
<?php
}
else{
print "<p class='testo'>L'articolo non pu&ograve; venire salvato n&eacute; pubblicato perch&eacute; incompleto: <span class='rosso'>".$msgErr."</span>.<br /><br /></p>";   
}
?>

<p><a href="cancella.php"><input type="button" name="bozza" value="CANCELLA" class="bottSubmit" /></a><br /> Cancella tutti i dati finora inseriti e ricomincia daccapo.</p>

<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p>&nbsp;&nbsp;Anteprima dell'Articolo</p>
<div class="riquadro">
<?php 
if ($art_img!="") {
print "<img src='".$url.$cartella."/th_".$art_img."' alt='antep' title='anteprima immagine allegata' class='dx thumb scala'>";	
}
print "<h4><span class='grigio'>[Titolo:]</span> <span class='viola'>".$art_titolo."</span></h4>"; 
print "<span class='grigio'>[Categoria:]</span> <span class='arancio'>".ucfirst($art_macro)."</span><br />";
print "<br /><br />";
print "<span class='grigio'>[Testo:]</span><span class='testo'>".$art_testo."</span>";
?>
<br /><br />
</div>
<br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
