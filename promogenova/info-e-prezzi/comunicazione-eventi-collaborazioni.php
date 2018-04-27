<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_infoprezzi.php"; $mysql=new mysql;
$infoprezzi=$mysql->infoprezzi($conn,"");

// struttura html
$title="Comunicazione, eventi e collaborazioni";
$metaDescription="Informazioni veloci su come Promogenova.it tratta comunicazione, eventi e collaborazioni";
$metaKeywords="comunicazione, eventi, collaborazioni, campagne, diffusione, pubblicizzazione";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Comunicazione, eventi e collaborazioni</h1><br/><br/>
<p class="testo">
Ferme restando la natura e la finalit&agrave; squisitamente commerciali del portale, Promogenova &egrave; solito condividere e diffondere sui propri canali social anche contenuti altrui, purch&egrave; non finalizzati alla vendita o alla proposizione di servizi alternativi o concorrenziali.<br/>
Nelle nostre pagine, cerchiamo dunque, di selezionare con cura e di dare spazio anche a iniziative finalizzate a sensibilizzare, creare sinergie (in primo luogo con lo stesso portale e i suoi clienti) e valorizzare il territorio. Valutiamo quindi attentamente ogni tipo di segnalazione a seconda di come e quanto l'iniziativa o l'evento possa coinvolgere il portale stesso e i suoi clienti, e se possieda i seguenti requisiti:<br/>
- assenza di finalit&agrave; e contenuti politici, religiosi, sindacali;<br/>
- segnalazione almeno una settimana prima;<br/>
- totale gratuit&agrave; e apertura al pubblico (NON devono quindi prevedere un costo o un contributo per partecipare, siano essi un biglietto d'ingresso o la quota partecipativa richiesta ai bancarellisti) al di l&agrave; delle finalit&agrave; della singola iniziativa o dell'evento (p.es. beneficienza), l'organizzazione della stessa NON deve prevedere un budget, neanche minimo, destinabile in pubblicit&agrave; o in compensi vari (ossia: se l'iniziativa è gratuita, tutti coloro che partecipano e divulgano devono farlo gratuitamente).<br/>
Dopo di che, se l'iniziativa NON rispetta uno dei requisiti, ma pu&ograve; coinvolgere direttamente il portale e/o clienti del portale (p.es. con loghi in locandina, agevolazioni per la partecipazione ecc.), Promogenova pu&ograve; considerare l'eventualit&agrave; di pubblicare e di appoggiare comunque gratuitamente l'iniziativa stessa; in tutti gli altri casi, Promogenova si comporta come qualunque altro media o professionista, presentando le proprie proposte: il portale offre, in alcuni casi con forti sconti, un'ampia gamma di servizi che comprendono anche la pubblicizzazione di eventi.
</p>
<br /><br /><br />
</div>

<div class="colonna-1-2">
<p><img src="<?php print $url; ?>lay/contratto.jpg" alt="info" class="scala" /></p>
</div>
</div>

<?php
include "../config/footer.php";
?>
