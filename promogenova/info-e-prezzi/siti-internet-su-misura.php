<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_infoprezzi.php"; $mysql=new mysql;
$infoprezzi=$mysql->infoprezzi($conn,"");

// struttura html
$title="Siti internet su misura";
$metaDescription="Informazioni veloci sui siti internet proposti da Promogenova.it";
$metaKeywords="siti internet, siti web, siti promogenova, pagine internet";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Siti internet su misura</h1><br/><br/>
<p class="testo">Promogenova propone due tipi di siti: statico e dinamico. Entrambe le soluzioni sono ideate per abbattere costi e tempi, possono venire realizzate rapidamente e garantiscono, oltre alla prima assistenza, una buona indicizzazione su Google.</p>
<br /><br /><br />
<h5 class="arancio">Sito statico</h5>
<p class="testo">
Per definizione, il sito statico &egrave; quello che, una volta realizzato e messo in rete, non viene pi&ugrave; modificato n&eacute; aggiornato, se non con l'intervento del programmatore. Promogenova consiglia caldamente questa soluzione a tutti coloro che non hanno tempo o voglia di aggiornare i propri siti, bens&igrave; mirano esclusivamente a rendersi reperibili in rete.
I tempi previsti per la messa in rete sono solitamente inferiori alla settimana; mentre i costi, sia pur sempre contenuti, variano a seconda del numero di pagine e dell'intervento grafico.<br/><br/>
Esempio di nostre realizzazioni: <a href="http://www.maieuticacmd.it/">http://www.maieuticacmd.it</a>
</p>
<br/><br/>
<h5 class="arancio">Sito dinamico</h5>
<p class="testo">
Se desideri un sito aggiornabile con tuoi contenuti e gestibile completamente in ogni sua parte, pronto e funzionale in tempi record, Promogenova ti propone l'installazione guidata e assistita del pacchetto  <i>Wordpress</i>, nonché un aiuto concreto per i primi passi (gestione complessiva, inserimento articoli, ecc.).
</p>
<br/><br/>
</div>

<div class="colonna-1-4">
<p><img src="<?php print $url; ?>lay/contratto.jpg" alt="info" class="scala" /></p>
</div>
<div class="colonna-1-4">
<?php
$mysql->proposte($infoprezzi,"siti","sfGiallo");
?>
</div>
</div>

<?php
include "../config/footer.php";
?>
