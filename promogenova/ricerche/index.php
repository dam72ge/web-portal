<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;

// struttura html
$title="Ricerche commerciali";
$metaDescription="Ricerche commerciali e suggerimenti di ricerca sul portale Promogenova.it";
$metaKeywords="ricerca commerciale, ricerche commerciali, ricerca per categorie, ricerca per marchi, ricerca per articoli, promogenova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Ricerche commerciali</h1>
<p class="testo">Come e cosa trovare su <strong>Promogenova</strong>.</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-2">
<p><img src="<?php print $url; ?>img/commerce.jpg" alt="vetrina" class="scala" /></p>
</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<h2 class="rosso">Categorie commerciali</h2>
<p class="testo">Poche e intuitive, le categorie commerciali permettono di trovare velocemente gli <strong>articoli</strong> (servizi e prodotti) pubblicati dalle Attivit&agrave; presenti su <em>Promogenova</em>.</p>
<p><a href="<?php print $url; ?>ricerche/categorie-commerciali.php" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
<h2 class="rosso">Articoli</h2>
<p class="testo">I servizi e i prodotti, dalle novit&agrave; all'usato, dalle rimanenze alle forniture, con o senza sconti, in offerta o in promozione, ecc: l'elenco di <strong>tutti gli articoli pubblicati</strong> da tutte le Attivit&agrave; presenti su <em>Promogenova</em>.</p>
<p><a href="<?php print $url; ?>ricerche/tutti-gli-articoli.php" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
<h2 class="rosso">Parole chiave</h2>
<p class="testo">Le parole chiave sono <strong>tag di ricerca</strong> che consentono di trovare facilmente le vetrine Attivit&agrave; presenti su <em>Promogenova</em>.</p>
<p><a href="<?php print $url; ?>ricerche/parole-chiave.php" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
</div>
<div class="colonna-1-2">
<h2 class="rosso">Vetrine</h2>
<p class="testo">Le <em>vetrine web</em> sono <strong>pagine</strong> realizzate per offrire maggiori informazioni ai visitatori e ai clienti sulle Attivit&agrave; presenti su <em>Promogenova</em>. In ognuna di esse si possono trovare, oltre alla breve descrizione dell'Attivit&agrave, interessanti gallerie fotografiche, schede sui marchi trattati, orari, contatti telefonici, ecc..</p>
<p><a href="<?php print $url; ?>vetrine-web/" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
<h2 class="rosso">Eventi delle Attivit&agrave;</h2>
<p class="testo">Le ultimissime novit&agrave; sui <strong>corsi</strong>, le <strong>dimostrazioni</strong> e le <strong>manifestazioni</strong> organizzate, promosse e/o partecipate dalle Attivit&agrave; presenti su <em>Promogenova</em>.</p>
<p><a href="<?php print $url; ?>attivita/index.php#eventi" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
<h2 class="rosso">Marchi</h2>
<p class="testo">Elenco di <strong>tutti i Marchi</strong> trattati da tutte Attivit&agrave; presenti su <em>Promogenova</em>.</p>
<p><a href="<?php print $url; ?>ricerche/tutti-i-marchi.php" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
</div>
</div>



<?php
include "../config/footer.php";
?>
