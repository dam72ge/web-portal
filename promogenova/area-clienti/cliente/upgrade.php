<?php
$url="../../"; $urlAdm="../";   
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// struttura html
$title="Admin ".$attivita." - Potenzia la tua Vetrina web";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<section>
<article>
<h1>Potenzia la tua Vetrina web</h1>
<h4 class="grigio">Scopri (ed eventualmente richiedi) le nuove opzioni delle Vetrine di <em>Promogenova</em></h4>

<p class="testo"><br /><br />

<b>PromoGenova.it</b>, offre ai Clienti la possibilit&agrave; di utilizzare al meglio le Vetrine web e le pagine del Portale, creando Eventi, inserendo Video e soprattutto intrecciando relazioni pi&ugrave; forti e costruttive sul territorio tramite i <em>social network</em>.
<br /><br /><br />
</p>


<h5>L'<span class="arancio">assistenza periodica indiretta</span>.</h5>
<p class="testo">
Se disponi di poco tempo o incontri difficolt&agrave;, puoi richiedere l'assistenza periodica nella gestione della tua Vetrina web: ogni mese, per e-mail o per telefono, Promogenova inserir&agrave; nuovi articoli e/o altre pubblicazioni su tua indicazione, facendo cos&igrave; risultare la Vetrina sempre aggiornata.<br /><br />
</p>

<!--
<h5>La <span class="arancio">promozione</span> fuori zona.</h5>
<p class="testo">
Attivando l'opzione, puoi ''piazzare'' articoli (prodotti o servizi) fuori dalla zona in cui opera la tua Attivit&agrave;, trasformandoli in <strong>promozioni</strong> espressamente rivolte a coloro che vi risiedono.<br /><br />
</p>
-->

<h5>Gli <span class="arancio">Eventi</span>.</h5>
<p class="testo">
Con questa opzione, puoi creare i tuoi <strong>Eventi</strong> (corsi, esibizioni, partecipazioni fiere o altre manifestazioni, ecc.), differenziandoli dagli Articoli ordinari. Gli eventi possono durare fino a 30 giorni, possono venire collocati in <strong>tutto il territorio</strong> nazionale, e talora possono essere promossi dal Portale e/o integrarsi con Progetti, reti associative e altre realt&agrave; sostenute dal Portale o con cui il Portale collabora attivamente.
<br/><br/></p>


</article>
</section>

<?php
include "../footer.php";
?>
