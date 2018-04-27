<?php
$url="../";
include "../config/mydb.php";
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_eventi.php"; $mysql=new mysql;
require_once "../config/class_db.php"; $db=new db; 

$id=0; $where="";
if ( isset($_GET['id']) && $_GET['id']>0 ) {
$id=$_GET['id'];
}
if ( isset($_POST['id']) && $_POST['id']>0 ) {
$id=$_POST['id'];
}

$eventi=$mysql->elenco_eventi($conn);

// riordina eventi per data inizio decrescente
array_multisort(
$eventi['dataInizio'],SORT_DESC,SORT_NUMERIC,
$eventi['dataFine'],SORT_DESC,SORT_NUMERIC,
$eventi['anno'],SORT_DESC,SORT_NUMERIC,
$eventi['id'],SORT_DESC,SORT_NUMERIC,
$eventi['home'],SORT_ASC,SORT_REGULAR,
$eventi['titolo'],SORT_ASC,SORT_REGULAR,
$eventi['testo'],SORT_ASC,SORT_REGULAR,
$eventi['img'],SORT_ASC,SORT_REGULAR,
$eventi['oreInizio'],SORT_ASC,SORT_REGULAR,
$eventi['oreFine'],SORT_ASC,SORT_REGULAR,
$eventi['dataAvv'],SORT_ASC,SORT_NUMERIC,
$eventi['dataOsc'],SORT_ASC,SORT_NUMERIC,
$eventi['idR'],SORT_ASC,SORT_NUMERIC,
$eventi['idP'],SORT_ASC,SORT_NUMERIC,
$eventi['idC'],SORT_ASC,SORT_NUMERIC,
$eventi['idM'],SORT_ASC,SORT_NUMERIC,
$eventi['idQ'],SORT_ASC,SORT_NUMERIC,
$eventi['zona'],SORT_ASC,SORT_REGULAR,
$eventi['url'],SORT_ASC,SORT_REGULAR,
$eventi['idAttivita'],SORT_ASC,SORT_NUMERIC,
$eventi['idRete'],SORT_ASC,SORT_NUMERIC
);


// struttura html
if($id>0){
$singolo=$mysql->singolo_evento($conn,$id);

  $title=$myobj->mb_convert_encoding($singolo['titolo']);
  $title=ucfirst($title);
  if ($title!=""){
  $metaDescription=$singolo['testo'];
  $metaKeywords=strtolower($singolo['titolo']);
  if ($singolo['quartiere']!="") { $metaKeywords.=", eventi ".strtolower($singolo['comune'])." ".strtolower($singolo['quartiere']); }  
  if ($singolo['municipio']!="") { $metaKeywords.=", eventi ".strtolower($singolo['comune'])." ".strtolower($singolo['municipio']); }
  if ($singolo['comune']!="") { $metaKeywords.=", eventi ".strtolower($singolo['comune']); }
  if ($singolo['provincia']!="") { $metaKeywords.=", eventi ".strtolower($singolo['provincia'])." provincia"; }
  if ($singolo['regione']!="") { $metaKeywords.=", eventi ".strtolower($singolo['regione']); }
  $metaRobots="ALL";
  $metaKeywords.=", promogenova";

	//opengraph SINGOLO EVENTO
	$opengraph="s";
	$og_title=$title; 	
	$og_url="http://www.promogenova.it/".$_SERVER['PHP_SELF']."?id=".$id;
	$locandina="locandine/".$singolo['img'];
	$og_image="";
        if ($singolo['img']!="") {
        $og_image=$locandina;
        }
	
	//twitter SINGOLO EVENTO
	$twitter="s";
	$twitter_title=$title; 
	$twitter_url="http://www.promogenova.it/".$_SERVER['PHP_SELF']."?id=".$id;
	$locandina="locandine/".$singolo['img'];
	$twitter_image="";
        if ($singolo['img']!="") {
        $twitter_image=$locandina;
        }

  }
}
else{
$title="Eventi";
$metaDescription="";
$metaDescription="Eventi pubblicati da Promogenova e da Attivit&agrave; clienti di Promogenova";
$metaKeywords="eventi, manifestazioni, feste, sagre, promogenova";
$metaRobots="ALL";

	//opengraph EVENTI
	$opengraph="s";
	$og_title="Eventi pubblicati su Promogenova"; 	
	$og_url="http://www.promogenova.it/eventi/index.php";
    $og_image="img/eventicalendario.jpg";

	//twitter EVENTI
	$twitter="s";
	$twitter_title="Eventi su Promogenova.it"; 
	$twitter_url="http://www.promogenova.it/eventi/index.php";
	$twitter_image="img/eventicalendario.jpg";

}



include "../config/head.php";
include "../config/header-nav.php";


// VISUALIZZA TUTTI GLI EVENTI
if ($id==0) {
?>


<div class="riga">
<div class="colonna-1-2">
<h1>Eventi</h1>
<p class="testo">Ricerca per tipo di evento.</p>
<p>Vuoi far conoscere i tuoi eventi? <a href="../info-e-prezzi"><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-4">
<p><img src="../img/eventicalendario.jpg" alt="calendario" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="rosso">Questa pagina</h4>
<p class="nero">
	Questa pagina raccoglie manifestazioni, sagre, feste, iniziative nel territorio diffuse su Promogenova. 
	Salvo diversa indicazione, tutti gli eventi qui riportati sono da considerarsi gratuiti e aperti a tutti.
	Per segnalazioni e/o proposte di collaborazione, mandateci un messaggio!
</p>
</div>
</div>

<!-- EVENTI ATTIVI -->
<div class="riga">
<div class="colonna-1-2">
<h3 class="bianco sfTondo sfNero">Recenti e novit&agrave;</h3>
<?php


print "<a name='nuovi'></a>";
print "<p class='nero'>Eventi recenti, presenti e/o imminenti pubblicati in Homepage e/o sostenuti direttamente da Promogenova</p>";
$dataOggi=date("Ymd");
$tremesifa=$mysql->dataMesiPrima(date("Ymd"),2);
for ($i=0;$i<count($eventi['id']);$i++) {    
	if ($eventi['titolo'][$i]!="" && $eventi['dataInizio'][$i]>0 && $eventi['dataOsc'][$i]>0) {
	if ($dataOggi<=$eventi['dataOsc'][$i] && $eventi['dataInizio'][$i]>=$tremesifa && $dataOggi>=$eventi['dataAvv'][$i]) {
    $mysql->estratto_singolo($url,$i,$eventi,"esteso");
    print "</b></i></u>";
    }    
    }    
}
print "<br /><br />";
?>
</div>
<div class="colonna-1-2">
<p><img src="../img/eventi.jpg" alt="eventifest" class="scala" /><br /><br /></p>
<h3 class="bianco sfTondo sfVerde">Eventi futuri</h3>
<?php
print "<a name='futuri'></a>";
print "<p class='nero'>Eventi futuri diffusi e/o sostenuti direttamente da Promogenova</p>";
$dataOggi=date("Ymd"); $annoOggi=date("Y");
$totEventi=count($eventi['id'])-1;
for ($i=0;$i<count($eventi['id']);$i++) {    
	if ($eventi['titolo'][$i]!="" && $eventi['dataInizio'][$i]>0 && $eventi['dataOsc'][$i]>0) {
    if ($eventi['anno'][$i]>=$annoOggi && $dataOggi<$eventi['dataAvv'][$i]){ 
    $mysql->estratto_singolo($url,$i,$eventi,"ridotto");
    print "</b></i></u>";
    }    
    }    
}
print "<br /><br />";

print "<p><img src='../img/italia-puzzle.png' alt='puzzle' class='scala' /><br /><br /></p>";
print "<br /><a name='passati'></a>";
print "<h5 class='nero'>Eventi passati</h5>";
print "<form name='selAtt' action='' method='post'>";
print "<p><select name='id' options='1' class='bottSelect'>";
print "<option value='' selected>=== Seleziona ==</option>";
$dataOggi=date("Ymd");
$tremesifa=$mysql->dataMesiPrima(date("Ymd"),2);
for ($i=1;$i<count($eventi['id']);$i++) {
	if ($eventi['titolo'][$i]!="" && $eventi['dataInizio'][$i]>0 && $eventi['dataOsc'][$i]>0) {
	if ($dataOggi>$eventi['dataOsc'][$i] && $eventi['dataInizio'][$i]<$tremesifa) {
    $titolo=$myobj->mb_convert_encoding($eventi['titolo'][$i]);
    $titolo=substr($titolo,0,30);
    print "<option value='".$eventi['id'][$i]."'>".$titolo."</option>";
    }    
    }    
}
print "</select> ";
print " <input type='submit' name='submit' value='VAI ALLA PAGINA' class='bottSubmit' /></p>";
print "</form>";
print "<br /><br /></div>";

print "</div>";


	
}




// VISUALIZZA SINGOLO EVENTO
else{

    print "<div itemprop='event' itemscope itemtype='http://schema.org/Event'>";
    print "<div class='riga'>";
    print "<div class='colonna-1-2'>";
    // titolo, zona, date+orari
    $titoloEvento=$myobj->mb_convert_encoding($singolo['titolo']); 
    print "<h1 class='nero' itemprop='name'>".$titoloEvento."</h1>";   
    print "</div>";

    $sostenit="n";
    print "<div class='colonna-1-4'>";
    // ATTIVITA'
		$sql1="SELECT attivita.idAttivita,logo,attivita,cartella  
        FROM eventi,eventi_promot,attivita,vetrine 
        WHERE eventi.id=eventi_promot.id 
        AND eventi_promot.idAttivita=attivita.idAttivita 
        AND attivita.idAttivita=vetrine.idAttivita 
        AND eventi.id='".$id."'"; 
        $query1=mysqli_query($conn,$sql1);			
        while ( $row=mysqli_fetch_array($query1,MYSQLI_ASSOC) ) {
            $nome=$myobj->mb_convert_encoding($row['attivita']);
            print "<p style='text-align:center'>Evento promosso da<br />";
            print "<a href='".$url.$row['cartella']."'>";
            $fileLogo=$url.$row['cartella']."/th_".$row['logo'];
                if ($row['logo']!="" && file_exists($fileLogo)) {
                print "<img src='".$fileLogo."' class='scala' alt='logo_".$row['cartella']."' /><br />";
                }
                // registra cliente su statistiche 
                $promotAttivita=$row['idAttivita']; $tipoPag="evento-cliente";
                include "../config/stat_eventi.php";
        print "<span class='testo rosso'>".$nome."</span></a><br /><br />";
        print "</p>";
        $sostenit="s";
        }
    print "</div>";

    print "<div class='colonna-1-4'>";

    if ($singolo['home']=="s") {
    print "<p style='text-align:center'><img src='".$url."/img/logo.png' class='scala' alt='logoPromogenova' /><br />Evento sostenuto da questo portale<br /><br /></p>";
    $sostenit="s";
    }

		$sql1="SELECT reti.idRete,logo,rete FROM eventi,eventi_promot,reti  
        WHERE eventi.id=eventi_promot.id 
        AND eventi_promot.idRete=reti.idRete 
        AND eventi.id='".$id."'";
        $query1=mysqli_query($conn,$sql1);			
        while ( $row=mysqli_fetch_array($query1,MYSQLI_ASSOC) ) {
            $nome=$myobj->mb_convert_encoding($row['rete']);
            print "<p style='text-align:center'>Evento promosso da<br />";
            print "<a href='".$url."reti/scheda.php?idRete=".$row['idRete']."'>";

            $fileLogo=$url."reti/loghi/th_".$row['logo'];
                if ($row['logo']!="" && file_exists($fileLogo)) {
                print "<img src='".$fileLogo."' class='scala' alt='Rete_".$row['idRete']."' /><br />";
                }
                // registra rete su statistiche 
                $promotRete=$row['idRete']; $tipoPag="evento-rete";
                include "../config/stat_eventi.php";
        print "<span class='testo rosso'>".$nome."</span></a><br /><br />";
        print "</p>";
        $sostenit="s";
        }
 
    
    if ($sostenit=="n") {
    print "<p style='text-align:center'><img src='".$url."/img/basilico.gif' class='scala' alt='basilico' /><br />Evento segnalato da Promogenova<br /><br /></p>";
    }
 
    print "</div>";
    print "</div>";



    print "<div class='riga'>";
    print "<div class='colonna-1-2'>";
    


	// DATE E ORARI (prepara)
        $oggi=date("Ymd");
        $linkEv=0; // 0=no link album e video, 1=sì (evento passato)
        $statoEv="";
        if ($oggi<$singolo['dataAvv']) {
            $linkEv=0; $statoEv="<span class='bianco sfBlu'> <b>FUTURO</b></span><br />"; }
        if ($oggi>=$singolo['dataInizio'] && $oggi<=$singolo['dataFine']) {
            $linkEv=0; $statoEv="<span class='bianco sfVerde'> <b>IN CORSO!</b></span><br />"; }
        if ($oggi>=$singolo['dataAvv'] && $oggi<$singolo['dataInizio']) {
            $linkEv=0; $statoEv="<span class='rosso sfGiallo'> <b>IMMINENTE!</b></span><br />"; }
        if ($oggi>$singolo['dataFine'] && $oggi<$singolo['dataOsc']) {
            $linkEv=1; $statoEv="<span class='bianco sfArancio'> <b>PASSATO DA POCO</b></span><br />"; }
        if ($oggi>=$singolo['dataOsc']) {
            $linkEv=1; $statoEv="<span class='bianco sfGrigio'> <b>PASSATO</b></span><br />"; }
            
	// LINK MEDIA (collegamenti con video e album)

	$totMedia=0;
    if ($linkEv>0) {
		print "<p class='actr scala'>";
	$sql="SELECT video.idVideo,url FROM media_link,video WHERE video.idVideo=media_link.idVideo AND id='".$id."'ORDER BY idMedia DESC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if ($riga['idVideo']>0) { 
			$totMedia++;
			print "Video dell'evento<br/>";
            $myobj->video($riga['url']);
            print "<br/><br/>";
		}
	}
    $sql="SELECT album.idAlbum,url FROM media_link,album WHERE album.idAlbum=media_link.idAlbum AND id='".$id."'ORDER BY idMedia DESC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if ($riga['idAlbum']>0) { 
			$totMedia++;
			print "Immagini dell'evento<br/>";
			print "<a href='".$riga['url']."'>";
			print "<img src='".$url."img/galleriafoto.jpg' class='scala' alt='alb_".$riga['idAlbum']."'><br/>";
            print $riga['url']."</a>";
            print "<br/><br/>";
		}
	}
		print "</p>";
    }

    if ($totMedia>0) { 
	print "<br/><br/>";
    print "<h5 class='bianco sfTondo sfGrigio'>L'evento</h5>";
	}

    // TESTO
        $testo=$myobj->mb_convert_encoding($singolo['testo']);
        print "<p class='testo' itemprop='description'>".nl2br($testo)."<br /><br /><br /></p>";
        
        print "<a href='".$url."eventi/' rel='index'><img src='../lay/continua.png' alt='->' /> Clicca qui</a> per tornare alla pagina degli Eventi.<br /><br />"; 



    print "</div>";
    print "<div class='colonna-1-4'>";
    print "<h5 class='bianco sfTondo sfRosso'>Dove e Quando</h5><p style='line-height:1.5em;'>";

    // DATE E ORARI (visualizza)
        $oggi=date("Ymd");
        print "Stato dell'evento: ".$statoEv;

	// ZONA
        $zona=$myobj->mb_convert_encoding($singolo['zona']);
        print "Dove: <span class='nero' itemprop='location'>".$zona."</span><br/>";    

            if ($singolo['dataInizio']!="") {
            print "Quando: <span class='verde'>dalle ore ".$singolo['oreInizio'];
                if ($singolo['dataInizio']==$singolo['dataFine']) {
                print " alle ore ".$singolo['oreFine']." del giorno <span class='viola'>".$myobj->visData($singolo['dataFine'])."</span>"; 
                }
                else {
                print " del <span class='viola'>".$myobj->visData($singolo['dataInizio'])."</span> alle ore ".$singolo['oreFine']." del <span class='viola'>".$myobj->visData($singolo['dataFine'])."</span>";
                }	
            }
            print "</span>";
                
    $annoCfr=date("Y");
    if ($singolo['anno']!=$annoCfr){
        print "<br />Anno: <span class='verde'>".$singolo['anno']."</span>";
        }    
    print "<br /><br /><br /></p>";

    // locandina
    $locandina=$url."locandine/".$singolo['img'];
    $thumb=$url."locandine/th_".$singolo['img'];
        if ($singolo['img']!="" && file_exists($locandina)) {
        print "<h5 class='bianco sfTondo sfGiallo'>Locandina</h5>"; 
        print "<p><a href='".$locandina."'>";
        print "<img src='".$thumb."' alt='Evento".$id."' class='scala' title='Clicca per vedere nelle dimensioni originali' itemprop='image' /></a>";
        print "<br /><br /><br /></p>";
        }

    // link
    if ($singolo['url']!="") {
    print "<h5 class='bianco sfTondo sfCeleste'>InfoLink</h5>"; 
    print "<p>Per maggiori informazioni e aggiornamenti:<br />"; 
    print "<a href='".$singolo['url']."'>".$singolo['url']."</a><br /><br /></p>";
	}
    print "</div>";

    print "<div class='colonna-1-4'>";


    // suggerimenti ricerca sul territorio
    print "<h5 class='bianco sfTondo sfBlu'>Cerca nel territorio</h5><p style='line-height:2em;'>"; 
    if ($singolo['idQ']>0) { 
        print "<a href='".$url."territorio/quartieri.php?idQ=".$singolo['idQ']."'>".$singolo['comune']." ".$singolo['quartiere']."</a><br />";
    }
    if ($singolo['idM']>0) { 
        print "<a href='".$url."territorio/municipi.php?idM=".$singolo['idM']."'>Municipio ".$singolo['comune']." ".$singolo['municipio']."</a><br />";
    }
    if ($singolo['idC']>0) { 
        print "<a href='".$url."territorio/comuni.php?idC=".$singolo['idC']."'>Comune di ".$singolo['comune']." (".$singolo['sigla'].") </a><br />";
    }
    if ($singolo['idP']>0) { 
        print "<a href='".$url."territorio/province.php?idP=".$singolo['idP']."'>Provincia di ".$singolo['provincia']."</a><br />";
    }
    if ($singolo['idR']>0) { 
        print "<a href='".$url."territorio/regioni.php?idR=".$singolo['idR']."'>Regione ".$singolo['regione']."</a><br />";
    }
            print "<a href='".$url."territorio'><span class='testo verde'>Tutta Italia</span></a><br />";
    print "</p>";


    // vuoi creare un tuo evento? (link a infoprezzi)
    print "<br /><h5 class='bianco sfTondo sfVerde'>Promuovi il tuo evento</h5><p span class='nero'>"; 
	print "Desideri pubblicizzare i tuoi eventi su Promogenova?<br /> <a href='".$url."info-e-prezzi/' rel='index'><br/>";
	print "<img src='".$url."lay/continua.png' alt='->'/> Diventa nostro cliente!</a><br /><br />";
    print "</p>";



// microdati
    print "<div style='color:#fff'>";
        $isoInizio=$myobj->pubDateIso8601($singolo['dataInizio'],$singolo['oreInizio']);
        $isoFine=$myobj->pubDateIso8601($singolo['dataFine'],$singolo['oreFine']);

        print "<br />Data Iso8601: "; 
        print "<span itemprop='startDate' value='".$isoInizio."'>".$isoInizio."</span> -"; 
        print "<span itemprop='endDate' value='".$isoFine."'>".$isoFine."</span><br />";

        /*
        print "Quando: <span class='verde'>dalle ore ".$singolo['oreInizio']."</span>";
        print " del <span class='viola'>".$myobj->visData($singolo['dataInizio'])."</span>";
        print "alle ore <span class='verde'>".$singolo['oreFine']."</span>"; 
        print " del <span class='viola'>".$myobj->visData($singolo['dataFine'])."</span>";
        */
    print "</div>";


    print "</div>";
    print "</div>";

    print "</div>"; // chiude div microdati

} // chiude VISUALIZZAZIONE SINGOLO EVENTO

$tipoPag="evento";
$promotAttivita="";
$promotRete="";
include "../config/stat_eventi.php";
include "../config/footer.php";
?>
