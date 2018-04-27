<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_infoprezzi.php"; $mysql=new mysql;
$infoprezzi=$mysql->infoprezzi($conn,"");

// struttura html
$title="La tua vetrina web in 5 minuti";
$metaDescription="Informazioni veloci sulle vetrine web proposte da Promogenova.it";
$metaKeywords="vetrine web, vetrine promogenova, pagine internet, pubblicità";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>La tua vetrina web in 5 minuti</h1><br/><br/>
<p class="testo">La vetrina &egrave; una via di mezzo tra una pagina e un sito, attivabile in mezza giornata e gestibile autonomamente o in maniera assistita. La vetrina ti permette di offrire le informazioni essenziali ai visitatori sulla tua Attivit&agrave;, oltre che di promuoverti tramite il tuo lavoro inserendo via via i tuoi articoli (le pagine-schede informative dei tuoi prodotti, servizi, ecc.).</p>
<br /><br /><br />
<h5 class="arancio">Cosa occorre per attivare una vetrina</h5>
<p class="testo">
- Una partita IVA e/o un codice fiscale<br/>
- Telefono, e-mail e altri tuoi contatti<br/>
- 15-20 minuti del tuo tempo per vederci di persona e imbastirela tua <i>vetrina web</i><br/>
</p>
<br/><br/>
<h5 class="arancio">Cosa ottieni</h5>
<p class="testo">
- Autonomia completa, senza interventi di programmatori: una volta messa <i>on line</i> la vetrina, puoi aggiungere subito foto, articoli, contatti, ecc.<br/>
- Rintracciabilit&agrave; sul motore di ricerca <a href="http://www.google.com">Google</a>, con buoni piazzamenti<br/>
- Visibilit&agrave; su pc, notebook, smartphone, ipad, ecc.<br/>
- Prima assistenza e suggerimenti pratici sull'amministrazione della vetrina e sull'inserimento di articoli<br/>
- Non devi rapportarti a un centralino telefonico, ma con persone<br/>
- Contatti, idee e spunti per valorizzarti maggiormente, in maniera sempre positiva e propositiva<br/>
</p>
<br/><br/>
<h5 class="arancio">Quanto costa e quanto dura</h5>
<p class="testo">
- Da <b>cinquanta euro</b> in su (le vetrine sono tutte uguali e standardizzate, ma Promogenova le distingue a seconda delle dimensioni dell'Attivit&agrave;, adeguando i prezzi)<br/>
- Pagamento anticipato con fattura immediata<br/>
- Eventuale rinnovo: una volta all'anno, senza bollettini<br/>
</p>
</div>

<div class="colonna-1-4">
<p><img src="<?php print $url; ?>lay/contratto.jpg" alt="info" class="scala" /></p>
</div>
<div class="colonna-1-4">
<?php
$mysql->proposte($infoprezzi,"vetrine","sfVerde");
?>
</div>
</div>

<?php
include "../config/footer.php";
?>
