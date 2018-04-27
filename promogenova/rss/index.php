<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;

// struttura html
$title="RSS";
$metaDescription="Ricerche commerciali e suggerimenti di ricerca sul portale Promogenova.it";
$metaKeywords="aggiornamenti promogenova, novit&agrave; promogenova, rss promogenova, really simple syndication";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>RSS Promogenova</h1>
<p class="testo">Come rimanere sempre aggiornati su tutte le novit&agrave; pubblicate su <strong>Promogenova</strong>.</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-4">
<p><img src="<?php print $url; ?>lay/rss.png" alt="rss" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="nero">Novit&agrave; in tempo reale</h4>
<p class="testo arancio">I Feed danno informazione in tempo reale delle novit&agrave; di <strong>Promogenova</strong> in maniera veloce anche <strong>quando non stai visitando il portale</strong>.<br /><br /><br /></p>
</p>
</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<h4 class="bianco sfTondo sfBlu">Feed</h4><br />
<h5><a href="feed-vetrine.php"><img src="../lay/feed.png" alt="feed" /> Vetrine</a> </h5>
<p>Le Vetrine web che via via si aggiungono sul portale, con le presentazioni, i contatti, le foto e gli articoli delle Attivit&agrave; che le gestiscono.<br /><br /></p>
<h5><a href="feed-articoli.php"><img src="../lay/feed.png" alt="feed" /> Articoli</a> </h5>
<p>Segnalazione in tempo reale degli articoli (servizi e prodotti) che via via che vengono pubblicati nelle Vetrine delle Attivit&agrave; presenti sul portale.<br /><br /></p>
<h5><a href="feed-marchi.php"><img src="../lay/feed.png" alt="feed" /> Marchi</a> </h5>
<p>Segnalazione in tempo reale dei marchi via via che vengono aggiunti nelle vetrine dalle Attivit&agrave; presenti sul portale.<br /><br /></p>
<h5><a href="feed-eventi.php"><img src="../lay/feed.png" alt="feed" /> Eventi</a> </h5>
<p>Tutti gli eventi pubblicati dal Portale e quelli creati dalle Attivit&agrave; che ne fanno parte.<br /><br /></p>
<h5><a href="feed-video.php"><img src="../lay/feed.png" alt="feed" /> Video</a> </h5>
<p>Le novit&agrave; dal canale Youtube.<br /><br /></p>
<h5><a href="feed-album.php"><img src="../lay/feed.png" alt="feed" /> Album</a> </h5>
<p>Le raccolte di immagini pubblicate e condivise da Promogenova sui vari <i>social network</i>.<br /><br /></p>
<h5><a href="feed-reti.php"><img src="../lay/feed.png" alt="feed" /> Reti & Progetti</a> </h5>
<p>Gruppi, associazioni, laboratori ecc. che operano per la riqualificazione dei territori mediante progetti aperti, mirati alla socializzazione, alla produzione e alla diffusione della cultura, del volontariato, della partecipazione attiva.<br /><br /></p>
<h5><a href="feed-download.php"><img src="../lay/feed.png" alt="feed" /> Area download</a> </h5>
<p>Documenti, immagini e materiale vario caricato dal portale e messo a disposizione di tutti i visitatori.<br /><br /></p>
<br /><br /><br />
</div>
<div class="colonna-1-2">
<h4 class="bianco sfTondo sfVerde">Novit&agrave; sempre a portata di mouse</h4><br />
<p class="testo">
Il <i>Really simple syndication</i> (RSS) &egrave; un sistema per la distribuzione di contenuti che ti permette di ricevere in ogni momento sul computer le ultime novit&agrave; pubblicate da <i>Promogenova</i>. <b>Il servizio &egrave;  gratuito e non richiede nessuna registrazione</b>.<br/><br/>I <i>feed</i> RSS di <i>Promogenova</i> comprendono il titolo, il sommario e l'indirizzo internet (<i>url</i>) di tutto ci&ograve; che viene pubblicato sul portale. Potrai cos&igrave; decidere di essere <b>sempre aggiornato</b> sulle notizie che pi&ugrave; ti interessano in modo semplice e immediato.<br /><br />Per accedere al servizio Rss &egrave; sufficiente una connessione a Internet e un lettore (detto anche "aggregatore") che consenta di ricevere i canali Rss (<i>feed</i>) delle notizie che pi&ugrave; interessano. Puoi scaricare da Internet diversi lettori sia gratuiti che a pagamento.<br /><br />Il sistema &egrave; da anni in voga su blog e siti d'informazione.<br/><br/><br/>
</p>
</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<h4 class="bianco sfTondo sfArancio">Feed su Firefox</h4><br />
<p class="testo">Su Firefox i <strong>feed</strong> di Promogenova appariranno a cascata nella cartella salvata nei Segnalibri, cos&igrave; come in figura:<br /><br />
<img src="esempio-firefox.JPG" alt="esempio-firefox" class="scala" />
<br /><br /><br />  
</p>
</div>
<div class="colonna-1-2">
<h4 class="bianco sfTondo sfRosso">Feed su altri servizi</h4><br />
<p class="testo">Clicca col tasto destro del mouse sul pulsante arancione o sul titolo del <i>feed</i> corrispondente al canale al quale intendi iscriverti e scegli ''copia collegamento''. Se usi <i>SharpReader</i>, nel campo ''Address'' incolla l'indirizzo appena copiato e premi ''Subscribe''. Se invece utilizzi <i>FeedReader</i>, clicca sul pulsante ''new feed'' e incolla l'indirizzo appena copiato. Clicca su ''next" e poi ''finish''.
<br/><br/><br/></p>
</div>
</div>


<?php
include "../config/footer.php";
?>
