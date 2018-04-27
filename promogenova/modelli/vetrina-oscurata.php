<?php
$url="../"; 
include "../config/mydb.php";
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_vetrina.php"; $mysql=new mysql; 
require_once "../config/class_articoli.php"; $myart=new myart; 

// struttura html
$title="Pagina non attiva";
$metaDescription="";
$metaKeywords="";
$metaRobots="NOINDEX, NOFOLLOW";

include "../config/head.php";
include "../config/header-nav.php";

$msgID=""; $msg="";
if (isset($_GET['msgID']) && $_GET['msgID']!="") {
$msgID=$_GET['msgID'];
}
switch ($msgID){ 
	case "no-cartella": 
    $msg="La <em>vetrina web</em> non &egrave; raggiungibile perch&eacute; stata rimossa definitivamente.";
	break;

	case "no-idAttivita": 
    $msg="L'Attivit&agrave; e/o la <em>vetrina</em> potrebbero essere state rimosse dal database.";
	break;

	case "no-dataOsc": 
    $msg="L'Attivit&agrave; e/o la <em>vetrina web</em> risultano al momento non raggiungibili per mancato rinnovo contrattuale.";
	break;

	case "oscurato": $msg="La <em>vetrina web</em> risulta al momento <strong>oscurata</strong> da <em>Promogenova.it</em>.";
	break;

	case "scaduto": $msg="La <em>vetrina web</em> risulta al momento disattivata in attesa di rinnovo contrattuale da parte dell'Attivit&agrave;."; 
	break;

	default : $msg="La <em>vetrina web</em> potrebbe trovarsi temporaneamente in manutenzione o in attesa di rinnovo contrattuale da parte dell'Attivit&agrave;."; 
}

?>
<section>
<article>
<h1 class="rosso">
Attenzione! Questa pagina non &egrave; attiva.
</h1>
<p class="testo">
<br /><br />
<?php print $msg; ?>
<br /><br /><br /><br /><br />
</p>
</article>
</section>


<?php
include "../config/footer.php";
?>
