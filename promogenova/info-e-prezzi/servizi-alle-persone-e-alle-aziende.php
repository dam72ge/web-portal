<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_infoprezzi.php"; $mysql=new mysql;
$infoprezzi=$mysql->infoprezzi($conn,"");

// struttura html
$title="Servizi alle persone e alle aziende";
$metaDescription="Informazioni veloci sui servizi alle persone e alle aziende proposti da Promogenova.it";
$metaKeywords="siti internet, siti web, siti promogenova, pagine internet";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Servizi alle persone e alle aziende</h1><br/><br/>
<p class="testo"><em>Promogenova</em> significa anche <strong>consulenze</strong>, informazioni utili sull'uso dei <em>social network</em>, <strong>corsi</strong> personalizzati, <strong>servizi</strong> fotografici e video</p>
<br /><br /><br />
<h5 class="arancio">Siti e social network</h5>
<p class="testo">
Promogenova pu&ograve; fornirti gli strumenti utili all'analisi e all'ottimizzazione del tuo sito e della tua pagina facebook, aiutandoti ad approfondire le peculiarit&agrave; dei principali social network tenendo conto anche del loro utilizzo all'interno di obiettivi aziendali.
</p>
<br/><br/>
<h5 class="arancio">Consulenze e corsi personalizzati</h5>
<p class="testo">
Dalle basi della programmazione web alla gestione di un database on line, la creazione da zero di siti e di complesse strutture dinamiche: gli strumenti e le soluzioni utili nel lavoro.
</p>
<br/><br/>
<h5 class="arancio">Foto, video e diffusione in rete</h5>
<p class="testo">
Come continuare a diffondere un evento, dove pubblicare le proprie foto, come realizzare e poi diffondere un video? Impara con Promogenova!
</p>
<br/><br/>
</div>

<div class="colonna-1-4">
<p><img src="<?php print $url; ?>lay/contratto.jpg" alt="info" class="scala" /></p>
</div>
<div class="colonna-1-4">
<?php
$mysql->proposte($infoprezzi,"consulenze","sfRosso");
$mysql->proposte($infoprezzi,"servizi","sfBlu");
$mysql->proposte($infoprezzi,"eventi","sfViola");
$mysql->proposte($infoprezzi,"facebook","sfArancio");
?>
</div>
</div>

<?php
include "../config/footer.php";
?>
