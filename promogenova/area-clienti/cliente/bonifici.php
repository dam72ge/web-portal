<?php
$url="../../"; $urlAdm="../";   
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// struttura html
$title="Admin ".$attivita." - Pagamenti on line (Bonifico)";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<section>
<article>
<h1>Pagamenti on line</h1>
<h4 class="grigio">Coordinate bancarie e procedura di conferma per il bonifico</h4>

<p class="testo"><br /><br />
<b>PromoGenova.it</b> &egrave; una ditta individuale. Le coordinate bancarie sono le seguenti:<br /><br />
<span class="verde">
Banca: UBI - BANCA REGIONALE EUROPEA<br />
IBAN:   IT  35Y  06906  01400  000000028288<br />
Conto N. 28288 - Intestato a: <strong>Daniele Amaglio</strong><br /></span>
<br /><br /><br />
</p>

<h5>Procedura di conferma per i <span class="arancio">Nuovi clienti</span></h5>
<p class="testo">
Una volta effettuato, il bonifico va confermato <strong>entro una settimana</strong> con messaggio di Posta elettronica a: <strong>info@promogenova.it</strong>.<br />Si prega di riportare con esattezza gli estremi e la data.
<br/><br/></p>

<h5>Procedura di conferma per i <span class="arancio">Clienti</span> da pi&ugrave; di un anno</h5>
<p class="testo">
L'avvenuto pagamento pu&ograve; essere comunicato in qualsiasi momento, senza limiti di tempo. 
<br/><br/></p>


</article>
</section>

<?php
include "../footer.php";
?>
