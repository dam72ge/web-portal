<?php
$url=""; 
include "config/mydb.php";

// carica elementi comuni layout
require_once "config/class_layout.php"; $myobj=new pagina;
require_once "config/class_attivita.php"; $mysql=new mysql;

$attivita=$mysql->elenco_attivita($conn,$url,"idAttivita DESC, attivita ASC");

// struttura html
$title="Homepage";
$metaDescription="Promogenova.it &egrave; il portale che mette in rete. Eventi, vetrine web, consulenze e comunicazione su Genova e fuori";
$metaKeywords="vetrine web, eventi, comunicazione, pubblicit&agrave;, genova, liguria";
$metaRobots="ALL";

//opengraph
$opengraph="s";
$og_title="Promogenova.it"; 
$og_url="http://www.promogenova.it/";
$og_image="img/logo.png";

//twitter
$twitter="s";
$twitter_title="Promogenova.it"; 
$twitter_url="http://www.promogenova.it/";
$twitter_image="img/logo.png";

include "config/head.php";
include "config/header-nav.php";

// data oggi
$oggi=date('Ymd');
?>

<div class="riga">
<div class="colonna-1-5">
<p class="testo">
<strong>Promogenova</strong> mette in rete le persone e il loro lavoro, stimola l'incontro tra realt&agrave; che operano sul territorio e per il territorio, promuove la partecipazione attiva, la produzione e la diffusione di cultura, l'etica nel commercio e una comunicazione pi&ugrave; a misura di cittadino.
<!--
<b>Promogenova.it</b> ti aiuta a trovare con pochi click le offerte pi&ugrave; convenienti sotto casa. I prodotti e i servizi, l'usato, i saldi, le rimanenze delle aziende e delle attivit&agrave; promotrici sono raccolti e presentati in modo semplice e intuitivo, delegazione per delegazione e quartiere per quartiere.
-->
<!--
<br /><br />
Vuoi saperne di pi&ugrave;?<br /> <a href="faq/index.php"><img src="lay/continua.png" alt="->" /> Clicca qui!</a>
-->
</div>

<div class="colonna-1-5">
	<a href="attivita/" rel="index"><h3 class="rosso actr">Attivit&agrave;</h3></a>
	<p class="actr"><a href="attivita/" rel="index">
	<img src="lay/home_vetrine.jpg" alt="attivita" class="scala"><br/>
	Ricerca commerciale per vetrine, categorie, prodotti, servizi, marchi, foto
	</a>
	</p>

</div>
<div class="colonna-1-5">
	<a href="territorio/" rel="index"><h3 class="verde actr">Territorio</h3></a>
	<p class="actr"><a href="territorio/" rel="index">
	<img src="lay/home_lanterna.jpg" alt="territorio" class="scala"><br/><br/>
	Ricerca nel territorio: Regioni, Province, Comuni, Municipi e Quartieri
	</a>
	</p>

</div>
<div class="colonna-1-5">
	<a href="media/" rel="index"><h3 class="blu actr">Media</h3></a>
	<p class="actr"><a href="media/" rel="index">
	<img src="lay/home_media.jpg" alt="media" class="scala"><br/><br/>
	Eventi, video, album, RSS, locandine, file da scaricare
	</a>
	</p>
</div>

<div class="colonna-1-5">
	<a href="reti/" rel="index"><h3 class="nero actr">Reti</h3></a>
	<p class="actr"><a href="reti/" rel="index">
	<img src="lay/home_lego.jpg" alt="lego" class="scala"><br/><br/>
	Collaborazioni, idee, progetti
	</a>
	</p>

</div>
</div>

<a name="proposte"></a>
<div class="riga">
<div class="colonna-1-4">
<h3 class="bianco sfTondo sfGiallo">Promogenova non &egrave; il solito portale</h3>
<p><img src="img/caricamento-notte.jpg" alt="caricamento-notte.jpg" class="scala"></p>
<b>Promogenova.it</b> segue un codice etico e mira anzitutto a valorizzare le persone e il loro lavoro.<br/><br/>
Vuoi saperne di pi&ugrave;?<br /> <a href="faq/index.php"><img src="lay/continua.png" alt="->" /> Clicca qui!</a>

<br /><br />
</div>
<div class="colonna-1-4">
<h3 class="bianco sfTondo sfArancio">Promogenova ha una marcia in pi&ugrave;!</h3>
<p class="testo">
<b>Promogenova.it</b> Ti propone una presenza di qualit&agrave; sul web e un'alta rintracciabilit&agrave; sui motori di ricerca, a costi davvero competitivi, con autonomia gestionale completa oppure con varie opzioni di assistenza diretta, durata contrattuale di un anno non tacitamente rinnovabile (NO bollettini!) e varie possibilit&agrave; di pagamento, sempre con regolare fattura.<br /><br />
<a href="info-e-prezzi/" rel="index" style="font-size:28px; text-align:left"><img src="lay/continua.png" alt="->"> Clicca QUI per scoprire le nostre proposte!</a>
</p>
</div>
<div class="colonna-1-4">
<h3 class="bianco sfTondo sfCeleste">Mettiti in rete su Promogenova!</h3>
<p class="testo">
<b>Diventare Clienti di Promogenova.it &egrave; facile</b>: bastano i dati della tua Attivit&agrave; i tuoi contatti e appena 20 minuti del tuo tempo per conoscerci. Per iniziare subito o avere maggiori informazioni, lasciaci un <a href="faq/contattaci.php">messaggio</a> oppure cercaci sui social network!
</p>

<p class="actr">
<img src="img/logo-institution-big.png" alt="logo-institution-big.png" class="scala" title="Promogenova.it" />
<br /><br />
</p>
</div>
<div class="colonna-1-4">
<a name="social"></a>
<h3 class="bianco sfTondo sfViola">Promogenova sui social</h3>
<p><b>Promogenova</b> &egrave; presente sui maggiori <i>social network</i><br/><br/></p>
<p>
<a href="http://www.facebook.com/promogenova" title="Promogenova.it - Pagina su Facebook"><img src="lay/facebook.png" class="thumb" alt="f"/></a>
<a href="http://twitter.com/promogenova" title="Promogenova su Twitter"><img src="lay/twitter.png" class="thumb" alt="t"/></a>
<a href="http://plus.google.com/u/0/103140042063670371403" title="Promogenova su Google plus"><img src="lay/googleplus.png" class="thumb" alt="g"/></a>
<a href="http://www.linkedin.com/company/promogenova-it" title="Promogenova - Pagina aziendale su Linkedin"><img src="lay/linkedin.png" class="thumb" alt="in"/></a>
<a href="http://www.youtube.com/user/promogenova?sub_confirmation=1" title="Promogenova - Canale su YouTube (video)"><img src="lay/youtube.png" class="thumb" alt="yt"/></a> 
<a href="http://www.pinterest.com/promogenova" title="Promogenova su Pinterest (immagini)"><img src="lay/pinterest.png" class="thumb" alt="p"/></a> 
<a href="http://instagram.com/promogenova" title="Promogenova su Instagram (immagini)"><img src="lay/instagram.png" class="thumb" alt="i"/></a> 
<a href="http://www.flickr.com/photos/101423608@N05" title="Promogenova su Flickr (immagini)"><img src="lay/flickr.png" class="thumb" alt="fl"/></a> 
<a href="http://vimeo.com/user30524635" title="Promogenova su Vimeo (video)"><img src="lay/vimeo.png" class="thumb" alt="v"/></a> 
<a href="http://foursquare.com/promogenova" title="Promogenova su Foursquare (luoghi)"><img src="lay/foursquare.png" class="thumb" alt="fq"/></a> 
<a href="http://promogenova.tumblr.com" title="Promogenova su Tumblr (blog)"><img src="lay/tumblr.png" class="thumb" alt="t"/></a> 
<a href="http://www.openstreetmap.org/user/Promogenova" title="Promogenova su Open Street Map (mappe)"><img src="lay/osm.png" class="thumb" alt="osm"/></a>
<a href="http://profile.yahoo.com/NWAZBRF6N3YOLTNTSK4KUN6H24/" title="Promogenova su Yahoo"><img src="lay/yahoo.png" class="thumb" alt="yh"/></a>
<a href="http://www.promogenova.it/rss" title="RSS Promogenova (news)"><img src="lay/rss.png" class="thumb" alt="rss"/></a> 
</p>
</div>
</div>

<a name="eventi"></a>
<div class="riga">
<div class="colonna-1-4">
<h2 class="bianco sfTondo sfVerde">Eventi segnalati da Promogenova</h2>
<p><br /><br /><img src="lay/bigdoc.png" alt="bigdoc" class="scala" /><br /><br /><br />
Desideri pubblicizzare i tuoi eventi su Promogenova?<br /> <a href="info-e-prezzi/" rel="index"><img src="lay/continua.png" alt="->"/> Diventa nostro cliente!</a><br /><br />

Vuoi visualizzare tutti gli altri eventi?<br />
<a href="eventi/" rel="index"><img src="lay/continua.png" alt="->"/> Clicca qui</a></p>
</div>

<?php
  $conta=0;
  $oggi=date("Ymd");
	 $sql="SELECT eventi.id,titolo,testo,anno,dataInizio,oreInizio,dataFine,oreFine,dataAvv,dataOsc,media.img
     FROM eventi,eventi_dateore,eventi_txt,eventi_home,media,media_link
     WHERE eventi.id=eventi_home.id
     AND eventi.id=eventi_dateore.id 
     AND eventi.id=eventi_txt.id 
     AND media_link.idMedia=media.idMedia 
     AND media_link.id=eventi.id
     ORDER BY eventi_home.idEv ASC";
    $query=mysqli_query($conn,$sql);			
    while($eventi=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    if ($conta<3) { 
        print "<div class='colonna-1-4'>";
        
        $locandina=$url."locandine/".$eventi['img'];
        if ($eventi['img']!="" && file_exists($locandina)) {
        print "<br /><a href='eventi/?id=".$eventi['id']."'><img src='locandine/th_".$eventi['img']."' alt='locandina_".$eventi['id']."' class='scala' /></a><br /><br />";
	   }

        $titolo=$myobj->mb_convert_encoding($eventi['titolo']);
        print "<a href='eventi/?id=".$eventi['id']."'><h4 class='rosso'>".ucfirst($titolo)."</h4></a>"; // bianco sfTondo sfViola
        print "<p>";        
            if ($eventi['dataInizio']!="") {
            print " Periodo evento: dalle ore ".$eventi['oreInizio'];
                if ($eventi['dataInizio']==$eventi['dataFine']) {
                print " alle ore ".$eventi['oreFine']." del <strong>".$myobj->visData($eventi['dataFine'])."</strong>";    
                }
                else {
                print " del <strong>".$myobj->visData($eventi['dataInizio'])."</strong> alle ore ".$eventi['oreFine']." del <strong>".$myobj->visData($eventi['dataFine'])."</strong>";
                }	
            print "</p>";        
            }
        $testo=$myobj->mb_convert_encoding($eventi['testo']);
        $testo=substr($testo,0,300);
        $testo=strip_tags($testo);
        print "<span class='nero'>".nl2br($testo)."</span><br/>";
        print "<br/><a href='eventi/?id=".$eventi['id']."'>Vai alla pagina</a><br /><br />";
        
        if ($oggi>=$eventi['dataInizio'] && $oggi<=$eventi['dataFine']) {
            print "<span class='bianco sfVerde'> <b>IN CORSO!</b></span><br />"; }
        if ($oggi>=$eventi['dataAvv'] && $oggi<$eventi['dataInizio']) {
            print "<span class='rosso sfGiallo'> <b>IMMINENTE!</b></span><br />"; }
        
        /*
        if ($oggi>$eventi['dataFine'] && $oggi<$eventi['dataOsc']) {
            print "<span class='bianco sfGrigio'> <b>CHIUSO RECENTEMENTE</b></span><br />"; }
        if ($oggi>=$eventi['dataOsc']) {
            print "<span class='nero sfGrigio'> <b>PASSATO</b></span><br />"; }
        */
        print "</i></b></a></strong>";
        print "<br /><br /></p></div>";
	   }
       $conta++;
    }
?>
</div>

<a name="vetrine"></a>
<div class="riga">
<div class="colonna-1-3">
<h3 class="bianco sfTondo sfRosso">Vetrine web</h3>
<p>Le <i>vetrine web</i> sono pagine - da non confondersi con i siti internet - realizzate per offrire <b>maggiori informazioni</b> ai visitatori e ai clienti sulle Attivit&agrave; che promuovono su questo portale.<br/>In ognuna di esse si possono trovare, oltre alla <b>breve descrizione</b> dell'Attivit&agrave;, interessanti gallerie fotografiche, schede sui marchi trattati, orari, contatti telefonici, ecc.. Ecco qui le ultime 5 vetrine pubblicate su Promogenova</p>
<?php
$homeVetr=0;
for ($i=1;$i<count($attivita['idAttivita']);$i++) {
	if ($homeVetr<5) {
		$homeVetr++;
		print "<table><tr><td width='30%'>";
        print "<p class='actr'><a href='".$url.$attivita['cartella'][$i]."'>";
        $logo=$url.$attivita['cartella'][$i]."/th_".$attivita['logo'][$i];
        $spazi="";
            if ($attivita['logo'][$i]!="" && file_exists($logo)) {
            print "<img src='".$logo."' alt='logo".$attivita['idAttivita'][$i]."' class='scala thumb' />";
            $spazi="<br /><br />";
            }    
        print "</a>";
		print "</td><td width='70%'>";
        print "<p><a href='".$url.$attivita['cartella'][$i]."'>";
        $txtConv=$mysql->mb_convert_encoding($attivita['attivita'][$i]);
        print "<span class='testo nero'>".ucfirst($txtConv)."</span>";
        print "</a><br />";
        $txtConv=$mysql->mb_convert_encoding($attivita['ragsoc'][$i]);
        print "<i>".$txtConv."</i><br />";
        print "<span class='verde'>".$attivita['zona'][$i]."</span>";
        print $spazi;
        print "</p>";
		print "</td></tr></table>";
    }
}
?>
</div>
<div class="colonna-1-3">
<p class="testo actr" style="font-size:28px"><img src="img/felicita.jpg" alt="ricerca" class="scala" /><br /><br />
Su Promogenova &egrave; possibile trovare <a href="vetrine-web/" rel="index">vetrine</a> e <a href="ricerche/tutti-gli-articoli.php" rel="index">articoli</a> in molti modi: cercando nel <a href="territorio/" rel="index">territorio</a> o a partire dalla classica <a href="ricerche/index.php" rel="index">ricerca commerciale</a> per <a href="ricerche/categorie-commerciali.php" rel="index">categorie</a>, <a href="ricerche/tutti-i-marchi.php">marchi</a> e <a href="ricerche/parole-chiave.php">parole chiave</a>.
<br />
Nelle singole <a href="vetrine-web/" rel="index">vetrine</a> e&grave; inoltre possibile trovare link a siti e pagine, immagini, eventi e video.
<br /><br />
<img src="lay/carrello.jpg" alt="carrello" /><br /><br />
</p>
</div>
<div class="colonna-1-3">
<h3 class="bianco sfTondo sfVerde">Articoli</h3>
<p>Gli articoli sono pagine informative relative a prodotti, servizi, corsi ecc. via via pubblicizzati dalle singole Attivit&agrave; sulle rispettive Vetrine. Ecco qui gli ultimi 7 articoli pubblicati su Promogenova</p>
<?php
$homeArt=0;
    $sql="SELECT articoli.idArt,img,titolo,articoli_dat.idMacro,macro, dataOsc, attivita,cartella
    FROM articoli,articoli_dat,macro,articoli_txt, attivita,att_scad,vetrine
    WHERE articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro
    AND articoli_dat.idAttivita=attivita.idAttivita
    AND attivita.idAttivita=att_scad.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND articoli.osc='n'    
    AND att_scad.osc='n'    
    ORDER BY articoli.idArt DESC, titolo ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if ($oggi<=$q['dataOsc'] && $homeArt<7) {
		$homeArt++;
		print "<table><tr><td>";
            print "<p><a href='".$url.$q['cartella']."/articoli.php?idArt=".$q['idArt']."'>";
            $immagine=$url.$q['cartella']."/articoli/".$q['img'];
            $thumb=$url.$q['cartella']."/articoli/ico_".$q['img'];
                if ($q['img']!="" && file_exists($immagine)) {
	               print "<img src='".$thumb."' alt='img_".$q['idArt']."' class='sx thumb' />";
                }
            $txtConv=$myobj->mb_convert_encoding($q['titolo']);
            print "<span class='testo rosso'>".ucfirst($txtConv)."</span>";
            print "</a><br/>";
            $txtConv=$myobj->mb_convert_encoding($q['attivita']);
            print "Pubblicato da: <a href='".$url.$q['cartella']."'><span class='verde'>".ucfirst($txtConv)."</span></a> - ";
            $txtConv=$myobj->mb_convert_encoding($q['macro']);
            print "Categoria: <a href='".$url."ricerche/macro.php?idMacro=".$q['idMacro']."'>".ucfirst($txtConv)."</a>";
            print "<br /</p>";
		print "</td></tr></table>";
        }       
	}    
?>
</div>
</div>

<a name="video"></a>
<div class="riga">
<div class="colonna-1-5">
<h2 class="bianco sfTondo sfGrigio">I Video di Promogenova</h2>
<p>Altri video sono disponibili sul nostro <a href="http://www.youtube.com/user/promogenova" rel="external"><img src="ico/youtube.png" alt="[yt]" /> Canale YouTube</a></p>
</div>

<?php
  $conta=0;
    $sql="SELECT idVideo,url,dataUp,anno,giorno FROM video ORDER BY dataUp DESC";
    $query=mysqli_query($conn,$sql);			
    while($video=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    if ($conta<4) {
        print "<div class='colonna-1-5'><p>";
        $myobj->video($video['url']);
        print "<br/>";
        $giorno=$myobj->mb_convert_encoding($video['giorno']);
        print "Data: <span class='verde'>".$giorno."</span> - ";
        print "Anno: <span class='verde'>".$video['anno']."</span><br />";
        print "Link diretto: <a href='".$video['url']."' rel='external'>".$video['url']."</a><br /><br /><br />";
        print "</p></div>";
	   }
       $conta++;
    }
?>
</div>

<a name="territorio"></a>
<div class="riga">
<div class="colonna-2-3">
<h3 class="bianco sfTondo sfViola">Municipi e Quartieri di Genova</h3>
<p class="testo grigio">
<?php 
print "<br /><br />";
include "config/mappa-genova.php";
print "<br /><br />";

     $conta=0;
     $sql_p="SELECT idM,municipio FROM municipi WHERE idC='25' ORDER BY idM ASC";
     $query_p=mysqli_query($conn,$sql_p);
     while ($tit=mysqli_fetch_array($query_p,MYSQLI_ASSOC)){
     $conta++;
	 print "<a href='territorio/municipi.php?idM=".$tit['idM']."' rel='index'>".$tit['idM'].". ".$tit['municipio']."</a> ";
		      $sql_q="SELECT quartiere FROM quartieri WHERE idC='25' AND idM='".$tit['idM']."'ORDER BY quartiere ASC";
              $query_q=mysqli_query($conn,$sql_q);
              while ($q=mysqli_fetch_array($query_q,MYSQLI_ASSOC)){
              print $q['quartiere']." ";
    }
    print "<br />";
    }
?>
<br /><br />
</p>

</div>
<div class="colonna-1-3">
<h2 class="bianco sfTondo sfBlu">Ricerca sul Territorio</h2>
<br /><br />
<h4 class="verde">Genova (Provincia)</h4>
<p>
<?php
     $sql_c="SELECT idC,comune FROM comuni WHERE idP='1' AND idC!='25' ORDER BY idC ASC";
     $query_c=mysqli_query($conn,$sql_c);
     while ($tit=mysqli_fetch_array($query_c,MYSQLI_ASSOC)){
     $nome=$myobj->mb_convert_encoding($tit['comune']);
	 print "<a href='territorio/comuni.php?idC=".$tit['idC']."' rel='index'>".$nome."</a> ";
    }
     print "<br /><br /><br />";
?>
</p>
<h4 class="verde">Liguria</h4>
<p>
<?php
     $sql_c="SELECT idP,provincia FROM province WHERE idR='1' AND idP!='1' ORDER BY idP ASC";
     $query_c=mysqli_query($conn,$sql_c);
     while ($tit=mysqli_fetch_array($query_c,MYSQLI_ASSOC)){
     $nome=$myobj->mb_convert_encoding($tit['provincia']);
	 print "<a href='territorio/province.php?idP=".$tit['idP']."' rel='index'>".ucwords($nome)."</a> ";
    }
     print "<br /><br /><br />";
?>
</p>
<h4 class="verde">Altre regioni</h4>
<p>
<?php
     $sql_c="SELECT idR,regione FROM regioni WHERE idR!='1' ORDER BY regione ASC";
     $query_c=mysqli_query($conn,$sql_c);
     while ($tit=mysqli_fetch_array($query_c,MYSQLI_ASSOC)){
     $nome=$myobj->mb_convert_encoding($tit['regione']);
	 print "<a href='territorio/regioni.php?idR=".$tit['idR']."' rel='index'>".ucwords($nome)."</a> ";
    }
     print "<br /><br /><br />";
?>
</p>
</div>
</div>

<a name="album"></a>
<div class="riga">
<div class="colonna-1-4">
<h2 class="bianco sfTondo sfCeleste">Gli Album di Promogenova</h2>
<p>
Altre immagini e gallerie fotografiche sono disponibili sui nostri profili nei vari social <i>social network</i>, quali per esempio  <a href="http://www.flickr.com/photos/101423608@N05/" rel="external"><img src="ico/flickr.png" alt="[p]" /> Flickr</a>,  <a href="http://www.pinterest.com/promogenova" rel="external"><img src="ico/pinterest.png" alt="[p]" /> Pinterest</a> e <a href="http://www.facebook.com/promogenova" rel="external"><img src="ico/facebook.png" alt="[f]" /> Facebook</a> 
</p>
</div>
<?php
  $conta=0;
    $sql="SELECT idAlbum,album,url,dataUp,anno,giorno FROM album ORDER BY dataUp DESC";
    $query=mysqli_query($conn,$sql);			
    while($album=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    if ($conta<3) {
        print "<div class='colonna-1-4'><p>";
        $titolo=$myobj->mb_convert_encoding($album['album']);    
        print "<a href='".$album['url']."' rel='external'><h5><span class='nero'>".$titolo."</span></h5></a>";

		    $sql1="
		    SELECT img 
		    FROM media,media_link
		    WHERE media.idMedia=media_link.idMedia
		    AND media_link.idAlbum='".$album['idAlbum']."'
		    ";
			$query1=mysqli_query($conn,$sql1);			
			$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
			$copertina="locandine/".$row['img']; 
        if ($row['img']!="" && file_exists($copertina)) {
            print "<a href='".$album['url']."'><img src='locandine/th_".$row['img']."' alt='Album_".$album['idAlbum']."' class='scala' /><br /></a>";
        }
        $giorno=$myobj->mb_convert_encoding($album['giorno']);
        print "Data: <span class='verde'>".$giorno."</span> - ";
        print "Anno: <span class='verde'>".$album['anno']."</span><br />";
        print "Clicca <a href='".$album['url']."' rel='external'>QUI</a> per vedere l'intero album<br /><br />";
        print "</p></div>";
	   }
       $conta++;
    }
?>
</div>

<a name="reti"></a>
<div class="riga">
<div class="colonna-1-4">
<h2 class="bianco sfTondo sfNero">Reti & Progetti</h2>
<p>Schede di Associazioni, comitati e gruppi di persone sostenuti da <b>Promogenova</b> e aggiunti di recente sul portale</p>
</div>
<?php
  $conta=0;
    $sql="SELECT idRete,rete,logo FROM reti WHERE osc='n' ORDER BY idRete DESC";
    $query=mysqli_query($conn,$sql);			
    while($rete=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    if ($conta<3 && $rete['rete']!="") {
        print "<div class='colonna-1-4'><p>";
        $nome=$myobj->mb_convert_encoding($rete['rete']);
        print "<h5 class='nero'>".$nome."</h5>";
        $logoRete="reti/loghi/th_".$rete['logo'];
        if ($rete['logo']!="" && file_exists($logoRete)) {
            print "<a href='reti/scheda.php?idRete=".$rete['idRete']."'>";
            print "<img src='".$logoRete."' alt='Logo_".$rete['idRete']."' class='scala' />";
            print "</a><br /><br />";
        }
        print "Clicca <a href='reti/scheda.php?idRete=".$rete['idRete']."'>QUI</a> per maggiori informazioni<br /><br />";
        print "</p></div>";
	   }
       $conta++;
    }
?>
</div>




<?php
include "config/footer.php";
?>
