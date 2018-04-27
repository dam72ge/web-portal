<?php
$url="../"; $urlAdm="";   
include "inc/apri.php";
include "../config/mydb.php";

// carica elementi comuni layout
require_once "../config/class_layout.php"; $myobj=new pagina;

// struttura html
$title="Admin ".$attivita;
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "head.php";
include "header-nav.php";
?>


<div class="riga">
<div class="colonna-1-2">
<h1 class="rosso">Benvenuto!</h1>
<p class="riquadro">
<?php
$oggi=date("Ymd"); $msg="";
if($oggi>=$dataAvv){ $msg="Ti informiamo che il tuo contratto scadr&agrave; a breve (vedi riquadro qui sotto). A partire dalla data di scadenza, avrai ancora un mese esatto di tempo per effettuare il rinnovo, dopo di che la tua Vetrina verr&agrave; rimossa insieme a tutto ci&ograve; che hai inserito sul Portale."; }		
if($oggi>$dataScad){ $msg="Il Tuo contratto risulta scaduto (vedi riquadro qui sotto). Ti informiamo che in caso di mancato versamento e/o comunicazione non saranno concesse ulteriori proroghe e la Vetrina verr&agrave; rimossa insieme a tutto ci&ograve; che hai inserito sul Portale." ; }	
if ($msg!=""){
print "<span='rosso'>Attenzione! <br/><br/>".$msg."<br/>Se desideri ricevere maggiori informazioni, contattaci per via telefonica o per posta elettronica, oppure clicca su <i>Assistenza</i> e inviaci un messaggio.<br/><br/>Grazie per la cortese attenzione,<br/><b>Promogenova.it</b></span>";
}
else{
print "Benvenuto nella Pagina di amministrazione (<em>Admin</em>) della tua Vetrina web. Clicca sulle <strong>Icone</strong> e/o sulle varie <strong>voci del Men&ugrave;</strong> posto in alto a destra per gestire i tuoi dati e tutte le tue attivit&agrave; sul portale.";
}
?>
</p>
</div>

<div class="colonna-1-4">
<a name="articoli"></a>
<h4 class="nero">Men&ugrave; Articoli</h4><hr/>
Schede informative su prodotti, servizi, promozioni, iniziative ricorrenti e/o tutto ci&ograve; che meglio rappresenta il tuo lavoro.<br/><br/>

<table><tr><td>
	<p><a href="articoli/nuovo.php"><img src="../img/nuovodoc.png" class="sx" /> CREA NUOVO</a><br/>
	Aggiungi nuovo articolo (5 passaggi + anteprima, pubblica o salva in bozza)</p>
</td></tr></table>

<!--p><a href="articoli/newform.php"><img src="../img/tabelle.png"/> Aggiungi nuovo al volo</a></p-->
<table><tr><td>
	<p><a href="articoli/index.php"><img src="../img/schedario.png" class="sx" /> GESTISCI</a><br/>
	Correggi, modifica, elimina gli articoli salvati e quelli in bozza</p>
</td></tr></table>
<br /><br />

<a name="eventi"></a>
<h4 class="nero">Men&ugrave; Eventi</h4><hr/>
Manifestazioni, sagre, feste, iniziative non ricorrenti limitate a una data o a un periodo di tempo.<br/><br/>
<?php
if ($creaEventi=="s") {
?>
<table><tr><td>
	<p><a href="eventi/nuovo.php"><img src="../img/calendar.png" class="sx" /> CREA NUOVO</a><br/>
	Aggiungi nuovo evento (4 passaggi + anteprima, pubblica)</p>
</td></tr></table>
<!--p><a href="eventi/newform.php"><img src="../img/tabelle.png"/> Aggiungi nuovo al volo</a></p-->
<table><tr><td>
	<p><a href="eventi/index.php"><img src="../img/eventi.png" class="sx" /> Gestione eventi</a><br/>
	Correggi, modifica, elimina gli eventi pubblicati</p>
	</p>
</td></tr></table>
<?php
}
else{
	print "<span class='rosso'>Opzione non attivata</span>";
}
?>
<br /><br />
</div>

<div class="colonna-1-4">
<a name="media"></a>
<h4 class="nero">Media</h4><hr/>
Gestisci immagini e video inerenti alla tua attivit&agrave;<br/><br/>
<table><tr><td>
	<p><a href="vetrina/foto.php"><img src="../img/gallery.png" class="sx" /> Fotogallery</a><br/>
	Carica foto e relative didascalie sulla vetrina</p>
</td></tr></table>
<table><tr><td>
	<p><a href="vetrina/video.php"><img src="../img/youtube.png" class="sx" /> Video</a><br/>
	Se hai un canale Youtube, aggiungi i tuoi video!</p>
</td></tr></table>
<br /><br />

<a name="assist"></a>
<h4 class="nero">Assistenza</h4><hr/>
<table><tr><td>
<p><a href="cliente/assistenza.php"><img src="../img/help.png" class="sx" /> Richiedi assistenza</a><br />
Invia un messaggio privato a Promogenova (per segnalazioni, problemi, ecc.)<br /><br /></p>
</td></tr></table>

<a name="stat"></a>
<h4 class="nero">Statistiche</h4><hr/>
<table><tr><td>
<p><a href="cliente/statistiche.php"><img src="../img/misur.png" class="sx" /> Statistiche indicative</a><br />
Visualizza il numero degli accessi unici totalizzati dalla tua vetrina<br /><br /><br /></p>
</td></tr></table>

</div>
</div>
	
<div class="riga">
<div class="colonna-1-4">
<a name="vetrina"></a>
<h4 class="nero">Vetrina</h4><hr/>
<p><a href="vetrina/logo.php"><img src="../img/logoattivita.png"/> Logo</a></p>
<p><a href="vetrina/chisiamo.php"><img src="../img/notes.png"/> Chi siamo</a></p>
<p><a href="vetrina/orari.php"><img src="../img/clock.png"/> Orari</a></p>
<p><a href="vetrina/parole.php"><img src="../img/messages_dock.png"/> Parole chiave</a></p>
<p><a href="vetrina/marchi.php"><img src="../img/skype.png"/> Marchi</a></p>
<br /><br />
</div>
<div class="colonna-1-4">
<a name="contatti"></a>
<h4 class="nero">I tuoi contatti</h4><hr/>
<p><a href="utente/telef.php"><img src="../img/phone.png"/> Numeri telefono</a></p>
<p><a href="utente/email.php"><img src="../img/contacts.png"/> E-mail</a></p>
<p><a href="utente/social.php"><img src="../img/facebook.png"/> Profili social</a></p>
<p><a href="utente/siti.php"><img src="../img/browser.png"/> Siti e pagine</a></p>
<br /><br />
<a name="indirizzo"></a>
<h4 class="nero">Il tuo indirizzo</h4><hr/>
<p><a href="utente/indirizzo.php"><img src="../img/maps.png"/> Vedi indirizzo</a></p>
<br /><br />
</div>
<div class="colonna-1-4">
<a name="dati"></a>
<h4 class="nero">I tuoi dati</h4><hr/>
<p><a href="utente/ragsoc.php"><img src="../img/negozio.png"/> Tipo Attivit&agrave;</a></p>
<p><a href="utente/pivacodfisc.php"><img src="../img/cartella.png"/> Part. IVA / Cod. Fisc.</a></p>
<p><a href="utente/password.php"><img src="../img/settings.png"/> Cambia password</a></p>
<p><a href="utente/dati-riservati.php"><img src="../img/contacts_dock.png"/> Contatti riservati</a></a></p>
<br /><br />
</div>
<div class="colonna-1-4">
<a name="contratto"></a>
<h2 class="verde">Contratto e scadenze</h2><br/>
<p class="riquadro">
<?php
if ($vetrOmaggio=="n") {
print "Data prima registrazione: <b>".$myobj->visData($dataReg)."</b><br />";
print "<span class='nero'>Data scadenza: <b>".$myobj->visData($dataScad)."</b></span><br />";
print "Avviso scadenza: ".$myobj->visData($dataAvv)."<br />";
print "Data oscuramento definitivo: ".$myobj->visData($dataOsc)."<br />";
}
if ($assistPeriod=="s") { print "Optional: <span class='verde'>Assistenza periodica</span><br />"; }
if ($vetrOmaggio=="s") { print "Optional: <span class='verde'>Vetrina OMAGGIO</span> con scadenza <span class='nero'><strong>".$myobj->visData($dataScad)."</strong></span><br />"; }
if ($creaEventi=="s") { print "Optional: <span class='verde'>Puoi creare EVENTI</span><br />"; } else { print "Limitazioni: <span class='rosso'>NON puoi creare eventi</span><br />"; }
/*
if ($creaPromo=="s") { print "Optional: <span class='verde'>Puoi PROMUOVERE i tuoi articoli anche fuori dalla tua zona</span><br />"; } else { print "Limitazioni: <span class='rosso'>NON puoi promuovere articoli fuori dalla tua zona</span><br />"; }
*/
?>
</p>
<br /><br /><br /><hr/><br />
<p><a href="cliente/index.php"><img src="../img/messaggi.png" class="sx" /> Info e Condizioni generali</a><br />Informazioni generali sul Contratto, Limitazioni e rispetto della Privacy<br /><br /></p>
<p><a href="cliente/bonifici.php"><img src="../img/piggy-bank.png" class="sx" /> Pagamenti on line</a><br />Coordinate bancarie e procedura di conferma per il bonifico<br /><br /></p>
<p><a href="cliente/upgrade.php"><img src="../img/snap.png" class="sx" /> Potenzia la tua Vetrina</a><br />
Scopri (ed eventualmente richiedi) le <strong>nuove opzioni</strong> delle Vetrine di Promogenova<br /><br /><br /></p>
<br /><br />
</div>
</div>


<section>
<aside>
<a href="#inizio"><img src="../img/su.jpg" alt="torna su" title="TORNA SU" /></a>
</aside>
<article>
<a name="uscita"></a>
<h3>Uscite dall'Area clienti</h3><br />
<p><a href="<?php print $url.$cartella; ?>"><img src="../img/exit.png" class="sx" /> Esci provvisoriamente</a><br />
Per uscire senza chiudere la sessione. Potrai tornare in qualsiasi momento da ogni pagina del Portale, semplicemente cliccando sulla voce <strong>Area Clienti</strong> nel me&ugrave; posto in alto a destra.<br /><br /></p>
<p><a href="<?php print $urlAdm; ?>logout.php"><img src="../img/home.png" class="sx" /> Chiudi ed esci</a><br />
Chiudi ed esci definitivamente. Per tornare sull'<em>Area clienti</em>, dovrai immettere nome e password.<br /><br /></p>
<br /><br />
</article>
</section>


<?php
include "footer.php";
?>
