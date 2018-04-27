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

$eventi=$mysql->elenco_eventi();

// struttura html
if($id>0){
$singolo=$mysql->singolo_evento($id);

  $title=$myobj->convTxt($singolo['titolo']);
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
<h4 class="rosso">Ricerca veloce</h4> 
<p id="menu">
<a href="#nuovi">Novit&agrave; e in corso</a> | 
<a href="#futuri">Futuri</a> |   
<a href="#vetrine">Creati da Attivit&agrave; clienti di Promogenova</a> |   
<a href="#reti">Creati da Reti e gruppi</a> |    
<a href="#altri">Altri condivisi da Promogenova</a> |    
<a href="#passati">Eventi anni passati</a>     
<br /><br /><br />
</p>
</div>
</div>

<!-- EVENTI ATTIVI -->
<div class="riga">
<div class="colonna-1-2">
<h3 class="bianco sfTondo sfNero">Eventi in corso</h3>
<?php
print "<a name='nuovi'></a>";
print "<p class='nero'>Eventi presenti e/o imminenti pubblicati in Homepage e/o sostenuti direttamente da Promogenova</p>";
$dataOggi=date("Ymd");
for ($i=1;$i<count($eventi['id']);$i++) {    
    if($eventi['home'][$i]=="s" &&  $dataOggi>=$eventi['dataAvv'][$i] && $dataOggi<=$eventi['dataFine'][$i]){ 
    $mysql->estratto_singolo($url,$i,$eventi,"esteso");
    print "</b></i></u>";
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
print "<p class='nero'>Eventi futuri (entro prossimi 5 anni) pubblicati in Homepage e/o sostenuti direttamente da Promogenova</p>";
$dataOggi=date("Ymd");
$annoAfa=date("Y")+5;
$totEventi=count($eventi['id'])-1;
for ($i=$totEventi;$i>1;$i--) {    
    if($eventi['home'][$i]=="s" && $dataOggi<$eventi['dataAvv'][$i] && $eventi['anno'][$i]<=$annoAfa){ 
    $mysql->estratto_singolo($url,$i,$eventi,"ridotto");
    print "</b></i></u>";
    }    
}
print "<br /><br />";
?>
</div>
</div>

<?php
print "<div class='riga'>";
print "<div class='colonna-1-2'>";

// novità eventi ultimi 3 mesi
print "<a name='nuovi'></a>";
print "<h2 class='bianco sfTondo sfBlu'>Novit&agrave; dalle vetrine </h2>";
print "<a name='vetrine'></a>";
print "<p class='nero'>Eventi futuri, presenti e/o passati da non pi&ugrave di due mesi, pubblicati nelle <i>vetrine web</i>di Promogenova</p>";
$tremesifa=$mysql->dataMesiPrima(date("Ymd"),2);
$annoAfa=date("Y")+5;
for ($i=1;$i<count($eventi['id']);$i++) {    
    if($eventi['idAttivita'][$i]>0 && $eventi['home'][$i]!="s"  && $eventi['dataFine'][$i]>=$tremesifa && $eventi['anno'][$i]<=$annoAfa){ 
    $mysql->estratto_singolo($url,$i,$eventi,"esteso");
    print "</b></i></u>";
    }    
}
print "<br /><br />";
print "</div>";

print "<div class='colonna-1-2'>";    
print "<h2 class='bianco sfTondo sfViola'>Novit&agrave; dalle Reti</h2>";
print "<a name='reti'></a>";
print "<p class='nero'>Eventi futuri, presenti e/o passati da non pi&ugrave di un mese, creati da <i>Reti</i> sostenute da Promogenova</p>";
$tremesifa=$mysql->dataMesiPrima(date("Ymd"),1);
$annoAfa=date("Y")+5;
for ($i=1;$i<count($eventi['id']);$i++) {    
    if($eventi['idRete'][$i]>0 && $eventi['home'][$i]!="s"  && $eventi['dataFine'][$i]>=$tremesifa && $eventi['anno'][$i]<=$annoAfa){ 
    $mysql->estratto_singolo($url,$i,$eventi,"esteso");
    print "</b></i></u>";
    }    
}
print "<br /><br />";

print "</div>";
print "</div>";



print "<div class='riga'>";
print "<div class='colonna-1-2'>";
print "<h2 class='bianco sfTondo sfCeleste'>Altri eventi</h2><br />";
print "<br /><a name='altri'></a>";
print "<p class='nero'>Altri eventi presenti, futuri e/o imminenti diffusi da Promogenova</p>";
$dataOggi=date("Ymd");
for ($i=1;$i<count($eventi['id']);$i++) {    
    if($eventi['home'][$i]!="s" &&  $eventi['idAttivita'][$i]==0 && $eventi['idRete'][$i]==0 &&  $dataOggi>=$eventi['dataInizio'][$i] && $dataOggi<=$eventi['dataOsc'][$i]){ 
    $mysql->estratto_singolo($url,$i,$eventi,"ridotto");
    print "</b></i></u>";
    }    
}
print "<br /><br />";
print "</div>";

print "<div class='colonna-1-2'>";
print "<p><img src='../img/italia-puzzle.png' alt='puzzle' class='scala' /><br /><br /></p>";
print "<br /><a name='passati'></a>";
print "<h5 class='nero'>Eventi passati</h5>";
print "<form name='selAtt' action='' method='post'>";
print "<p><select name='id' options='1' class='bottSelect'>";
print "<option value='' selected>=== Seleziona ==</option>";
$dataOggi=date("Ymd");
for ($i=1;$i<count($eventi['id']);$i++) {
    if($dataOggi>$eventi['dataOsc'][$i]){ 
    $titolo=$myobj->convTxT($eventi['titolo'][$i]);
    $titolo=substr($titolo,0,30);
    print "<option value='".$eventi['id'][$i]."'>".$titolo."</option>";
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
    $titoloEvento=$myobj->convTxT($singolo['titolo']); 
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
        $query1=mysql_query($sql1);			
        while ( $row=mysql_fetch_array($query1) ) {
            $nome=$myobj->convTxt($row['attivita']);
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
        $query1=mysql_query($sql1);			
        while ( $row=mysql_fetch_array($query1) ) {
            $nome=$myobj->convTxt($row['rete']);
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
    $query=mysql_query($sql);			
    while ($riga=mysql_fetch_array($query)){
        if ($riga['idVideo']>0) { 
			$totMedia++;
			print "Video dell'evento<br/>";
            $myobj->video($riga['url']);
            print "<br/><br/>";
		}
	}
    $sql="SELECT album.idAlbum,url FROM media_link,album WHERE album.idAlbum=media_link.idAlbum AND id='".$id."'ORDER BY idMedia DESC";
    $query=mysql_query($sql);			
    while ($riga=mysql_fetch_array($query)){
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
        $testo=$myobj->convTxT($singolo['testo']);
        print "<p class='testo' itemprop='description'>".nl2br($testo)."<br /><br /><br /></p>";
        
        print "<a href='".$url."eventi/' rel='index'><img src='../lay/continua.png' alt='->' /> Clicca qui</a> per tornare alla pagina degli Eventi.<br /><br />"; 



    print "</div>";
    print "<div class='colonna-1-4'>";
    print "<h5 class='bianco sfTondo sfRosso'>Dove e Quando</h5><p>";

    // DATE E ORARI (visualizza)
        $oggi=date("Ymd");
        print "Stato dell'evento: ".$statoEv;

	// ZONA
        $zona=$myobj->convTxT($singolo['zona']);
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


    // suggerimenti altri eventi

    if (count($eventi['id']>1)){
    print "<h5 class='bianco sfTondo sfBlu'>Altri eventi suggeriti</h5><p>"; 
    $contaEventi=0;

        for ($i=1;$i<count($eventi);$i++) {
        // eventi in home
        if ($id!=$eventi['id'][$i] && $eventi['home'][$i]=="s" && $eventi['dataAvv'][$i]<=$oggi && $eventi['dataFine'][$i]>$oggi && $contaEventi<5){
            $contaEventi++;
            $titolo=$myobj->convTxT($eventi['titolo'][$i]);
            print "<a href='?id=".$eventi['id'][$i]."'>".$titolo."</a><br />";
        }    
        // eventi altri
        if ($id!=$eventi['id'][$i] && $eventi['home'][$i]!="s" && $eventi['dataAvv'][$i]<=$oggi && $eventi['dataOsc'][$i]>$oggi && $contaEventi<10){
            $contaEventi++;
            $titolo=$myobj->convTxT($eventi['titolo'][$i]);
            print "<a href='?id=".$eventi['id'][$i]."'>".$titolo."</a><br />";
        }    

        }    
            print "<a href='".$url."eventi'><span class='testo verde'>Tutti gli eventi</span></a><br />";
    print "</p>";
    }


    // suggerimenti ricerca sul territorio
    print "<br /><h5 class='bianco sfTondo sfVerde'>Cerca nel territorio</h5><p>"; 
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
