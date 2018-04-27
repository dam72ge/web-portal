<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;

// struttura html
$title="Natura, linee e obbiettivi del portale Promogenova";
$metaDescription="Presentazione del portale web Promogenova. Natura, linee e obbiettivi.";
$metaKeywords="che cosa &egrave; promogenova, portali web, portali commerciali, portali eventi, obbiettivi promogenova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Tutto quello che c'&egrave; da sapere su Promogenova</h1>
<p class="testo">Natura, linee e obbiettivi del portale.</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-4">
<p><img src="<?php print $url; ?>img/pinguini.jpg" alt="portale" title="carini e coccolosi?" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="nero">F.A.Q.</h4>
<p id="menu">
<a href="#questo-portale">Che cos'&egrave; Promogenova</a> | 
<a href="#obbiettivi">Obbiettivi del portale</a> | 
<a href="#etica">Principi etici e linee di condotta</a> | 
<a href="#faq">FAQ (risposte a domande ricorrenti)</a>
</p>
</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<a name="questo-portale"></a>
<h4 class="bianco sfTondo sfRosso">Che cos'&egrave; Promogenova?</h4><br />
<p class="testo">
Promogenova nasce nel 2009 come portale d'informazione e promozione commerciale incentrato sulla semplicit&agrave; e sull'immediatezza comunicativa. L'idea era quella di fornire spazi e servizi d'alta qualit&agrave; a bassissimo costo ai singoli negozi di prossimit&agrave; sparsi nei vari quartieri di Genova, mettendoli in comunicazione tra loro e creando reti di quartiere. Con il passare del tempo e con il crescere in misura esponenziale dei contatti sul territorio e sui social network, con l'intrecciarsi sempre pi&ugrave; fitto di relazioni e di progetti in collaborazione con realt&agrave; vive e propositive, dentro e fuori Genova, il portale &egrave; andato via via allargando la visuale sua e dei propri clienti, fino a trasformarsi in vero e proprio portale di comunicazione dotato di connotati e obbiettivi chiari.<br /><br /></p>
</div>
<div class="colonna-1-2">
<a name="obbiettivi"></a>
<h4 class="bianco sfTondo sfVerde">Obbiettivi</h4><br />
<p class="testo">
Muovendo dalla naturale propensione a fare da ''tramite'' tra attivit&agrave; commerciali e cittadini, Promogenova si propone di ''fare rete'' in larga scala, coinvolgendo gruppi, associazioni, artisti e in genere 
tutti coloro che operano positivamente sul territorio e per il territorio, producendo cultura ed eventi, e con essi il pi&ugrave; ampio coinvolgimento e la sensibilizzazione sui temi dell'ambiente, del lavoro, dell'innovazione tecnologica a servizio delle persone (e non solo del profitto).   
<br /><br /></p>
</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<a name="etica"></a>
<h4 class="bianco sfTondo sfGiallo">Principi etici e linee di condotta</h4><br />
<p class="testo">
Promogenova garantisce ascolto e disponibilit&agrave; a chi si mostra altrettanto disponibile, capace di rispettare le persone e l'altrui lavoro.<br />
Promogenova sostiene unicamente i propri clienti e non fa pubblicit&agrave; a gratis.<br />
Promogenova non ricorre allo spam n&eacute; accetta di riceverne; analogamente, evita le comunicazioni aggressive, spersonalizzate, mirate unicamente al profitto.<br />
Promogenova non sostiene personalit&agrave; e gruppi politici, non si occupa di iniziative e temi sindacali o religiosi, non gradisce affiliazioni di alcun genere. Non intrattiene n&eacute; intende intrattenere rapporti di alcun tipo con attivit&agrave; e persone legate o in qualche modo riconducibili a centri scommesse, compraoro, armerie, centri commerciali, club privati, agenzie interinali.<br />
<br /><br /></p>
</div>
<div class="colonna-1-2">
<a name="faq"></a>
<h4 class="bianco sfTondo sfBlu">FAQ - Risposte a domande ricorrenti</h4><br />
<p class="nero">
<span class="viola">Siete un sito d'informazione? </span> - No. Promogenova non &egrave; un periodico e non pubblica notizie.<br /><br />
<span class="viola">Perch&egrave; non trovo <b>tutti</b> i negozi della mia citt&agrave;?</span> - Promogenova non &egrave; un doppione di servizi gi&agrave; esistenti (elenchi di numeri e negozi), ma ospita unicamente le pubblicazioni delle Attivit&agrave; che vi aderiscono nella zona in cui essi operano.<br /><br />
<span class="viola">Chi siete?</span> - Promogenova non &egrave; una societ&agrave;, ma fa capo a una ditta individuale. Chi desiderasse maggiori informazioni, pu&ograve; inviare un <a href="contattaci.php" rel="nofollow">messaggio</a> e/o risalirvi tramite il numero della Partita I.V.A..<br /><br />
<span class="viola">Pubblicate annunci cerca/offro lavoro? </span> - No. Promogenova non &egrave; un sito di annunci.<br /><br />
<span class="viola">State cercando personale? Posso mandarvi il mio <i>curriculum</i>? </span> - Al momento Promogenova non cerca personale e - a scanso di equivoci - non &egrave; un'agenzia interinale n&eacute; intrattiene alcun genere di rapporto con agenzie interinali.<br /><br />
<span class="viola">Perch&eacute; non trovo la vostra e-mail e il vostro numero di telefono?</span> - Tutte le comunicazioni verso Promogenova vanno effettuate tramite <a href="contattaci.php" rel="nofollow">messaggio</a>.<br /><br />
<span class="viola">Fate vendita diretta e/o indiretta?</span> - No. Su Promogenova si trovano esclusivamente informazioni sulle Attivit&agrave; e sui loro articoli, e non &egrave; previsto alcun tipo di vendita tramite il portale.<br /><br />
<span class="viola">Vendete connessioni internet?</span> - No.<br /><br />
<span class="viola">Accettate pubblicit&agrave; e/o scambi di banner pubblicitari?</span> - No.<br /><br />
<span class="viola">Perch&egrave; non accettate agenzie interinali, armerie, centri scommesse, centri commerciali e compraoro?</span> Promogenova non cerca il profitto ad ogni costo (umano e sociale anzitutto), ma bens&igrave; sostiene e s'impegna attivamente per un commercio eticamente responsabile, rispettoso della dignit&agrave; delle persone e a misura d'ambiente.<br /><br />
<span class="viola">Partecipate a campagne di solidariet&agrave; e simili?</span> - No.<br /><br />
<span class="viola">Come si fa ad apparire sulle pagine ''Reti e Progetti''? Devo pagare qualcosa?</span> - Queste pagine (schede informative) sono totalmente gratuite e vengono interamente redatte da Promogenova. Per avere una di queste pagine occorre: 1) non avere alcuna finalit&agrave; di lucro,  2) essere (o rappresentare nella sua interezza, in accordo con tutti i componenti) un gruppo o un laboratorio i cui requisiti rispondano a quelli illustrati sulla pagina <b>Reti e Progetti</b>, 3) avere finalit&agrave; e pratiche che siano in sintonia con i principi etici e le linee di condotta del portale, 4) mettersi in <a href="contattaci.php" rel="nofollow">contatto</a> diretto con Promogenova e presentare il proprio progetto. Per modificare o rimuovere la pagina, sar&agrave; poi sufficiente inviare un <a href="contattaci.php" rel="nofollow">messaggio</a> a Promogenova.<br /><br />

<br /><br /></p>
</div>
</div>


<?php
include "../config/footer.php";
?>
