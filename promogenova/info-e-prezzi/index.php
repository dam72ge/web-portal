<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_infoprezzi.php"; $mysql=new mysql;
$infoprezzi=$mysql->infoprezzi($conn,"");

// struttura html
$title="Informazioni, condizioni e prezzi";
$metaDescription="Informazioni sui servizi, sulle condizioni, sulle proposte contrattuali e sui prezzi degli spazi sul portale Promogenova.";
$metaKeywords="prezzi promogenova, servizi promogenova, vetrine web promogenova, consulenze promogenova, servizi promogenova, assistenza promogenova";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Informazioni, condizioni e prezzi di Promogenova</h1>
<p>Vuoi saperne di pi&ugrave; sul portale? <a href="<?php print $url; ?>faq/" rel="index" ><img src="../lay/continua.png" alt="->" /> Clicca qui!</a><br /><br /></p>
</div>
<div class="colonna-1-4">
<p><img src="<?php print $url; ?>lay/contratto.jpg" alt="info" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="rosso">Men&ugrave; veloce</h4>
<p id="menu">
<a href="#vetrine-ordinarie">Vetrine web ordinarie</a> | 
<a href="#vetrine-speciali">Vetrine web speciali</a> | 
<a href="#optionals-vetrine">Optionals aggiuntivi per potenziare le vetrine</a> | 
<a href="#consulenze">Consulenze</a> | 
<a href="#servizi">Servizi</a> | 
<a href="#eventi">Speciale eventi</a> |
<a href="#pagine">Pagine facebook</a> |
<a href="#siti">Siti internet</a> |
<a href="#pagamenti">Tempi e modalit&agrave; di pagamento</a>
</p>
</div>
</div>


<!-- guida veloce -->
<div class="riga">
<div class="colonna-1-4">
<a href="vetrina-web-in-5-minuti.php"><h4 class="verde">La tua vetrina in 5 minuti</h4></a>
<p class="testo">Che cosa &egrave; una <em>vetrina web</em>, perch&eacute; &egrave; vantaggiosa, <strong>cosa occorre</strong>, quanto costa e quanto dura.</p>
<a href="vetrina-web-in-5-minuti.php"><img src="../lay/continua.png" alt="->" /> Leggi tutto</a>
</div>
<div class="colonna-1-4">
<a href="siti-internet-su-misura.php"><h4 class="verde">Siti internet su misura</h4></a>
<p class="testo">Per abbattere costi e tempi, <em>Promogenova</em> propone <strong>soluzioni gi&agrave; pronte</strong>, installabili rapidamente, e ti garantisce la prima assistenza e l'indicizzazione su <i>Google</i></p>
<a href="siti-internet-su-misura.php"><img src="../lay/continua.png" alt="->" /> Leggi tutto</a>
</div>
<div class="colonna-1-4">
<a href="servizi-alle-persone-e-alle-aziende.php"><h4 class="verde">Servizi alle persone e alle aziende</h4></a>
<p class="testo"><em>Promogenova</em> significa anche <strong>consulenze</strong>, informazioni utili sull'uso dei <em>social network</em>, <strong>corsi</strong> personalizzati, <strong>servizi</strong> fotografici e video</p>
<a href="servizi-alle-persone-e-alle-aziende.php"><img src="../lay/continua.png" alt="->" /> Leggi tutto</a>
</div>
<div class="colonna-1-4">
<a href="comunicazione-eventi-collaborazioni.php"><h4 class="verde">Comunicazione, eventi, collaborazioni</h4></a>
<p class="testo"><em>Promogenova</em> &egrave; <strong>anche</strong> supporto, partecipazione e diffusione di eventi e <strong>iniziative aperte</strong> e gratuite</p>
<a href="comunicazione-eventi-collaborazioni.php"><img src="../lay/continua.png" alt="->" /> Leggi tutto</a>
</div>
</div>


<!-- proposte -->
<div class="riga">
<div class="colonna-1-2">
<p><img src="../img/comunicazione.jpg" alt="comunicazione" class="scala" /></p>
</div>
<div class="colonna-1-2">
<a name="pagamenti"></a>
<h3 class="bianco sfTondo sfGrigio">Attenzione!</h3>
<p class="testo">
A scanso di equivoci, <em>Promogenova</em> richiede il <b>pagamento anticipato</b> di quanto dovuto per qualsiasi servizio o prestazione. La fattura verr&agrave; emessa <b>ad avvenuto versamento</b> e sar&agrave; consegnata firmata al cliente entro la settimana. 
<br /><br />
Per i <b>rinnovi</b> delle vetrine web: il versamento deve avvenire entro e non oltre la scadenza della vetrina, altrimenti la stessa sar&agrave; oscurata.
<br /><br /><br /><br />
</p>
</div>
</div>

<div class="riga">
<h2 class="actr nero">Proposte per l'anno <?php print date("Y");?></h2>
</div>

<div class="riga">
<div class="colonna-2-3">
<a name="vetrine-ordinarie"></a>
<?php
$mysql->proposte($infoprezzi,"vetrine","sfVerde");
?>

<a name="optionals-vetrine"></a>
<?php
$mysql->proposte($infoprezzi,"optionals","sfGrigio");
?>


<p>(*) Per attivare ognuna di queste opzioni occorre essere titolari di una vetrina. La durata e la validit&agrave; delle opzioni sono subordinate alla durata della vetrina; sar&agrave; possibile attivare una o pi&ugrave; opzioni dopo aver attivato la vetrina, ma il costo rimarr&agrave; invariato.</p>
</div>


<div class="colonna-1-3">
<a name="vetrine-speciali"></a>
<?php
$mysql->proposte($infoprezzi,"offerte-speciali","sfCeleste");
?>
</div>
</div>


<div class="riga">
<div class="colonna-1-3">
<a name="consulenze"></a>
<?php
$mysql->proposte($infoprezzi,"consulenze","sfRosso");
?>
</div>
<div class="colonna-1-3">
<a name="servizi"></a>
<?php
$mysql->proposte($infoprezzi,"servizi","sfBlu");
?>
</div>
<div class="colonna-1-3">
<a name="eventi"></a>
<?php
$mysql->proposte($infoprezzi,"eventi","sfViola");
?>
</div>
</div>

<div class="riga">
<div class="colonna-2-3">
<a name="pagine"></a>
<?php
$mysql->proposte($infoprezzi,"facebook","sfArancio");
?>
</div>
<div class="colonna-1-3">
<a name="siti"></a>
<?php
$mysql->proposte($infoprezzi,"siti","sfGiallo");
?>
</div>
</div>


<!--div class="riga">
<div class="colonna-1">
<a name="pagamenti"></a>
<h3 class="bianco sfTondo sfNero">Tempi e modalit&agrave; di pagamento</h3><br />
<p class="testo">
Promogenova richiede il <b>pagamento anticipato</b> di quanto dovuto per qualsiasi servizio o prestazione. La fattura verr&agrave; emessa <b>ad avvenuto versamento</b> e sar&agrave; consegnata firmata al cliente entro la settimana. 
<br /><br />
Per i <b>rinnovi</b> delle vetrine web: il versamento deve avvenire entro e non oltre la scadenza della vetrina, altrimenti la stessa sar&agrave; oscurata.
<br /><br /><br /><br />
</p>
</div>
</div-->

<?php
include "../config/footer.php";
?>
