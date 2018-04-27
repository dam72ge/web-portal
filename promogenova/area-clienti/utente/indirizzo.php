<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;


// struttura html
$title="Admin ".$attivita." - Indirizzo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Indirizzo</h4><br />
<p>Il tuo attuale indirizzo:
<?php
print "<h3 class='nero'>".$indirizzo." ".$nciv."<br />";
print $cap." ".$comune." (".$sigla.")</h3>";
print "Regione: <span class='viola'>".$regione."</span><br />";
if ($municipio!="") { print "Municipio: <span class='verde'>".$municipio."</span><br />"; }
if ($quartiere!="") { print "Quartiere: <span class='arancio'>".$quartiere."</span><br />"; }
?>
</p>
<br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">

<?php
if ($mappa!="") {
	print $mappa."<br/><br/>";
//print "<iframe width='425' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='".$mappa."'></iframe><br /><br />";	
}
?>


Se il presente indirizzo &egrave; sbagliato o lo hai cambiato, mandaci un messaggio e provvederemo a cambiare la mappa.
<br /><br /><br /><br /><br /><br /><br /><br />
</p>
</div>
</div>
<?php
include "../footer.php";
?>
