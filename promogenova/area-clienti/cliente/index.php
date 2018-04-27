<?php
$url="../../"; $urlAdm="../";   
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// struttura html
$title="Admin ".$attivita." - Contratto e Privacy";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<section>
<article>
<h1>Contratto e Privacy</h1>
<h4 class="grigio">Informazioni generali sul Contratto, Limitazioni e rispetto della Privacy</h4>

<p class="testo">
<b>PromoGenova.it</b> fornisce i propri servizi in ottemperanza alle leggi vigenti, in conformit&agrave; alla normativa italiana e comunitaria in materia di vendita di spazio pubblicitario su internet. Coloro - siano essi Aziende o Privati - che vogliono inserire la propria Attivit&agrave; su <b>PromoGenova.it</b>, accettano e sottoscrivono il presente contratto impegnandosi a rispettarne le condizioni.
<br/><br/></p>

<h5 class="arancio">Fatturazione e Pagamenti</h5>
<p class="testo">
A fronte dei servizi forniti il Cliente corrisponder&agrave; a <b>PromoGenova.it</b> quanto dovuto in base ai listini e alle condizioni che caratterizzano l'offerta che il Cliente avr&agrave; scelto fra le diverse proposte. Le fatture verranno emesse con cadenza annuale. In caso di ritardato pagamento ricorreranno gli interessi di mora calcolati nella misura stabilita dalla legge. Decorso ulteriormente il termine di pagamento <b>PromoGenova.it</b> potr&agrave; sospendere, in modo totale o parziale, l'erogazione del servizio.
<br/><br/></p>

<h5 class="arancio">Possibilit&agrave; di recesso</h5>
<p class="testo">
Il presente contratto avr&agrave; la durata fissata dalle parti al momento della sottoscrizione; esso <b>NON</b> si intender&agrave; tacitamente rinnovato per ulteriori periodi.
<br/><br/></p>

<h5 class="arancio">Servizio clienti</h5>
<p class="testo">
Eventuali segnalazioni, reclami e richieste al servizio offerto da <b>PromoGenova.it</b> potranno essere effettuate via <i>e-mail</i> o per telefono. <b>PromoGenova.it</b> si impegna a risolverle in tempo reale (ove possibile).
<br/><br/></p>

<h5 class="arancio">Modifiche dei servizi in corso</h5>
<p class="testo">
<b>PromoGenova.it</b> si riserva di poter modificare e aggiornare le specifiche tecniche del servizio, nonch&egrave; di modificare di le presenti Condizioni di contratto, per sopravvenute e comprovate esigenze tecniche e/o gestionali che verranno tempestivamente comunicate ai clienti.
<br/><br/></p>

<h5 class="arancio">Sospensione del servizio</h5>
<p class="testo">
<b>PromoGenova.it</b> potr&agrave; sospendere in ogni momento i servizi in tutto o in parte, in caso di guasti alla rete e agli apparati di erogazione del servizio o di altri operatori, che siano dovuti a caso fortuito o a forza maggiore, nonch&egrave; nel caso di modifiche e/o manutenzioni comunicate al Cliente con almeno 5 giorni di preavviso.
<br/><br/></p>

<h5 class="arancio">Limitazione di responsabilit&agrave;</h5>
<p class="testo">
Il Cliente si assume ogni responsabilit&agrave; di veridicit&agrave; di quanto pubblicato nel proprio spazio pubblicitario, liberando in ogni modo <b>PromoGenova.it</b> da eventuali contestazioni.<br/>
Inoltre <b>PromoGenova.it</b> non risponder&agrave; di ritardi, malfunzionamenti, sospensioni e/o interruzioni nell'erogazione del servizio da:<br/><br/>
- errata utilizzazione del servizio da parte del Cliente;<br/>
- malfunzionamento degli apparecchi telefonici utilizzati dal Cliente;<br/>
- interruzione totale o parziale del servizio causato da un altro operatore;<br/>
- inadempimenti del Cliente a leggi o regolamenti applicabili.<br/>
<br/><br/></p>

<h5 class="arancio">Clausole di riservatezza (<i>Privacy</i>)</h5> 
<p class="testo">
<b>PromoGenova.it</b>, titolare del trattamento dei dati personali forniti dal Cliente mediante compilazione modulo di contratto, informa il Cliente, ai sensi e per gli effetti di cui al Decreto Legislativo 30 giugno 2003 n. 196, che i predetti dati personali saranno trattati, con l'ausilio di archivi cartacei e di strumenti informatici e telematici idonei a garantirne la massima sicurezza e riservatezza, al solo fine di dare esecuzione ai servizi. I predetti dati personali non saranno comunicati a soggetti diversi n&eacute; diffusi.
<br/><br/></p>

</article>
</section>

<?php
include "../footer.php";
?>
