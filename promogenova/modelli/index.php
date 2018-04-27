<?php
$url="../"; 
include "../config/mydb.php";
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_vetrina.php"; $mysql=new mysql; 
require_once "../config/class_db.php"; $db=new db; 

// riconosci vetrina
$vetrina=$mysql->identifica($conn,$_SERVER['PHP_SELF'],2);

// controllo
if ($vetrina['msgID'][0]!=""){
$pagOscurata=$url."modelli/vetrina-oscurata.php?msgID=".$vetrina['msgID'][0];
header("location: $pagOscurata");
}

// struttura html
$attivita=$myobj->mb_convert_encoding($vetrina['attivita'][0]);
$title=$attivita;
$metaDescription="La vetrina web di ".ucwords(strtolower($attivita)).". ".ucfirst($vetrina['ragsoc'][0])." - ".$vetrina['indirizzo'][0].", ".$vetrina['nciv'][0]." - ".$vetrina['cap'][0]." ".$vetrina['comune'][0];
$metaKeywords=strtolower($attivita).", ".$vetrina['ragsoc'][0];
$metaRobots="ALL";

//opengraph
$opengraph="s";
$og_title=$title; 
$og_url="http://www.promogenova.it/".$vetrina['cartella'][0];
$fileLogo=$vetrina['cartella'][0]."/th_".$vetrina['logo'][0];
$og_image="";
if ($vetrina['logo'][0]!=""){ $og_image=$fileLogo; }            

//twitter
$twitter="s";
$twitter_title=$title; 
$twitter_url="http://www.promogenova.it/".$vetrina['cartella'][0];
$fileLogo=$vetrina['cartella'][0]."/th_".$vetrina['logo'][0];
$twitter_image="";
if ($vetrina['logo'][0]!=""){ $twitter_image=$fileLogo; }            


include "../config/head.php";
include "../config/header-nav.php";


// div microdati
print "<div itemscope itemtype='http://schema.org/LocalBusiness'>";

// nome attività, ragione sociale, indirizzo, partita iva e/o codice fiscale, logo

    print "<div class='riga'>";
    print "<div class='colonna-1-2'>";
    $titolo=$myobj->mb_convert_encoding($vetrina['attivita'][0]);
    print "<h1 class='rosso' itemprop='name'>".$titolo."</h1>";
    print "<p>";
    if ($vetrina['partitaiva'][0]!=""){ print "Partita I.V.A. <span class='nero'>".$vetrina['partitaiva'][0]."</span><br/>";}
	if ($vetrina['codfisc'][0]!=""){ print "Codice Fiscale <span class='nero'>".$vetrina['codfisc'][0]."</span><br/>";}
    print "</p>";
    print "</div>";
    
    print "<div class='colonna-1-2'><p class='nero'>";
    $fileLogo=$url.$vetrina['cartella'][0]."/th_".$vetrina['logo'][0];
    if ($vetrina['cartella'][0]!="" && file_exists($fileLogo)) {
    print "<a href='".$url.$vetrina['cartella'][0]."/".$vetrina['logo'][0]."'><img src='".$fileLogo."' class='scala thumb dx' alt='logo' title='Clicca per visualizzare il Logo nelle dimensioni originali' /></a>";
    }

    if ($vetrina['ragsoc'][0]!="") {
    print "<h5>";
    $ragsoc=$myobj->mb_convert_encoding($vetrina['ragsoc'][0]);
    print $ragsoc;
    print "</h5>";
    }

    print "<div itemprop='address' itemscope itemtype='http://schema.org/PostalAddress'>"; // div microdati address
    print "<p class='nero'>";
    $indirizzoMappa="";
    if ($vetrina['indirizzo'][0]!="") {
        $indirizzo=$myobj->mb_convert_encoding($vetrina['indirizzo'][0]);
        if ($vetrina['nciv'][0]!="") { $indirizzo.=", ".$vetrina['nciv'][0];}
        print "Indirizzo: <a href='#dovesiamo'><span class='arancio' itemprop='streetAddress'>".$indirizzo."</span></a> - ";
        $indirizzoMappa.=$indirizzo." - ";    
        }else{
        print "<br /><br />";
        }
    if ($vetrina['idC'][0]>0) {
        $comune=$myobj->mb_convert_encoding($vetrina['comune'][0]);
        print " <a href='".$url."territorio/comuni.php?idC=".$vetrina['idC'][0]."'><span class='verde'><span itemprop='postalCode'>".$vetrina['cap'][0]."</span> <span itemprop='addressLocality'>".$comune."</span></span></a> (<span itemprop='addressRegion'>".$vetrina['sigla'][0]."</span>)";
        $indirizzoMappa.=$comune."(".$vetrina['sigla'][0].")";    

            if ($vetrina['idQ'][0]>0) {
            $quartiere=$myobj->mb_convert_encoding($vetrina['quartiere'][0]);
            print " - Quartiere: <a href='".$url."territorio/quartieri.php?idQ=".$vetrina['idQ'][0]."'><span class='viola'>".$quartiere."</span></a>";
            $indirizzoMappa.=" - ".$quartiere;
        }	    
    }else{
        print "<br /><br />";
    }
    print "<br /><br /></p>";

    print "</div>"; // chiude div microdati address
    print "</div>";
    print "</div>";


// contatti, siti, reti collegate, chi siamo, orari, fotogallery
    print "<div class='riga'>";
    print "<div class='colonna-1-4'>";

    print "<h3 class='bianco sfTondo sfVerde'>Contatti</h3>";
    print "<p  class='testo'>";
    $mysql->telef($conn,$url,$vetrina['idAttivita'][0]);
    $mysql->email($conn,$url,$vetrina['idAttivita'][0]);
    $mysql->social($conn,$url,$vetrina['idAttivita'][0]);
    print "<br /></p>";    

    $totSiti=$mysql->conta_siti($conn,$vetrina['idAttivita'][0]);
    if ($totSiti>0) {
    print "<h3 class='bianco sfTondo sfArancio'>Pagine e Siti</h3>";
    print "<p>";
    $mysql->siti($conn,$url,$vetrina['idAttivita'][0]);
    print "<br /></p>";    
    }

    $totReti=$mysql->conta_reti($conn,$vetrina['idAttivita'][0]);
    if ($totReti>0) {
    print "<h3 class='bianco sfTondo sfGrigio'>Reti</h3>";
    print "<p>";
    $mysql->reti($conn,$url,$vetrina['idAttivita'][0]);
    print "<br /></p>";    
    }
    print "</div>";

    print "<div class='colonna-1-2'>";
    print "<h3 class='bianco sfTondo sfRosso'>Chi siamo</h3><p class='testo' itemprop='description'>";
    if ($vetrina['chisiamo'][0]!=""){    
        $presentazione=$myobj->mb_convert_encoding($vetrina['chisiamo'][0]);
        print nl2br($presentazione);
        }else{    
        print "<br /><br /><br /><br /><br />";
        }
    print "<br />";
    print "</p>";    
    print "</div>";

    print "<div class='colonna-1-4'>";
    if ($vetrina['orari'][0]!=""){    
    print "<h3 class='bianco sfTondo sfBlu'>Orari</h3>";
    print "<p>";
        $orari=$myobj->mb_convert_encoding($vetrina['orari'][0]);
        print nl2br($orari);
    print "<br /><br /></p>";    
    }

    $totFoto=$mysql->conta_foto($conn,$url,$vetrina['cartella'][0],$vetrina['idAttivita'][0]);
    if ($totFoto>0) {
    print "<h3 class='bianco sfTondo sfViola'>Fotogallery</h3>";
    print "<p>";
    $foto=$mysql->foto($conn,$url,$vetrina['cartella'][0],$vetrina['idAttivita'][0],"");
        for ($i=0;$i<count($foto['id']);$i++) {
            print "<a href='".$url.$vetrina['cartella'][0]."/foto.php?id=".$foto['id'][$i]."'>";
            print "<img src='".$url.$vetrina['cartella'][0]."/foto/ico_".$foto['foto'][$i]."' alt='foto".$foto['id'][$i]."' class='thumb' />";
            print "</a> ";
	
        }
    print "<br /><br /></p>";    
    }
    
    print "</div>";
    print "</div>";

// ART articoli
    $totArticoli=$mysql->conta_articoli($conn,$vetrina['idAttivita'][0]);
    if ($totArticoli>0) {
    $articoli=$mysql->articoli($conn,$vetrina['idAttivita'][0]);
    print "<div class='riga'>";
    print "<div class='colonna-1-4'>";
    print "<h3 class='bianco sfTondo sfNero'>Articoli</h3>";
    print "Totale pubblicati: ".$totArticoli;
    print "</div>";

    print "<div class='colonna-1-4'>";
    for ($i=0;$i<count($articoli['idArt']);$i=$i+3) {        
        if ($articoli['titolo'][$i]!="") {	
	       print "<p><a href='".$url.$vetrina['cartella'][0]."/articoli.php?idArt=".$articoli['idArt'][$i]."'>";
            $icoart=$url.$vetrina['cartella'][0]."/articoli/th_".$articoli['img'][$i];
            if (file_exists($icoart) && $articoli['img'][$i]!=""){
                print "<img src='".$icoart."' alt='' class='scala'><br /> ";
                }
            $txtConv=$myobj->mb_convert_encoding($articoli['titolo'][$i]);
            print $txtConv."</a><br /><br /></p>";
        }
    }
    print "</div>";
    
    print "<div class='colonna-1-4'>";
    for ($i=1;$i<count($articoli['idArt']);$i=$i+3) {
        if ($articoli['titolo'][$i]!="") {	
	       print "<p><a href='".$url.$vetrina['cartella'][0]."/articoli.php?idArt=".$articoli['idArt'][$i]."'>";
            $icoart=$url.$vetrina['cartella'][0]."/articoli/th_".$articoli['img'][$i];
            if (file_exists($icoart) && $articoli['img'][$i]!=""){
                print "<img src='".$icoart."' alt='' class='scala'><br /> ";
                }
            $txtConv=$myobj->mb_convert_encoding($articoli['titolo'][$i]);
            print $txtConv."</a><br /><br /></p>";
        }
    }
    print "</div>";

    print "<div class='colonna-1-4'>";
    for ($i=2;$i<count($articoli['idArt']);$i=$i+3) {
        if ($articoli['titolo'][$i]!="") {	
	       print "<p><a href='".$url.$vetrina['cartella'][0]."/articoli.php?idArt=".$articoli['idArt'][$i]."'>";
            $icoart=$url.$vetrina['cartella'][0]."/articoli/th_".$articoli['img'][$i];
            if (file_exists($icoart) && $articoli['img'][$i]!=""){
                print "<img src='".$icoart."' alt='' class='scala'><br /> ";
                }
            $txtConv=$myobj->mb_convert_encoding($articoli['titolo'][$i]);
            print $txtConv."</a><br /><br /></p>";
        }
    }
    print "</div>";

    print "</div>";
    }


// EVENTI
    $totEventi=$mysql->conta_eventi($conn,$vetrina['idAttivita'][0]);
    if ($totEventi>0) {
    $eventi=$mysql->eventi($conn,$vetrina['idAttivita'][0]);
    print "<div class='riga'>";
    print "<div class='colonna-1-2'>";
    $txtConv=$myobj->mb_convert_encoding($vetrina['attivita'][0]);
    print "<h3 class='bianco sfTondo sfGiallo'>Eventi di ".$txtConv."</h3>";
    print "<p>";
    for ($i=0;$i<count($eventi['id']);$i++) {
	print "<a href='".$url."eventi/index.php?id=".$eventi['id'][$i]."'>"; 
    $txtConv=$myobj->mb_convert_encoding($eventi['titolo'][$i]);
    print $txtConv."</a> ";
        if (isset($eventi['dataInizio'][$i])) {
            print " - Periodo evento: dalle ore ".$eventi['oreInizio'][$i];
            if ($eventi['dataInizio'][$i]==$eventi['dataInizio'][$i]) {
            print " alle ore ".$eventi['oreFine'][$i]." del giorno ".$myobj->visData($eventi['dataFine'][$i]);    
            }
            else {
            print " del <strong>".$myobj->visData($eventi['dataInizio'][$i])."</strong> alle ore ".$eventi['oreFine'][$i]." del <strong>".$myobj->visData($eventi['dataFine'][$i])."</strong>";
            }	
        }
    print "<br />";    
    }
    print "</p>";    
    print "</div>";
    print "<div class='colonna-1-2'>";
    print "<h3 class='bianco sfTondo sfCeleste'>Locandine</h3>";
    print "<p>";
    $conta=0;
    for ($i=0;$i<count($eventi['id']);$i++) {
	   print "<a href='".$url."eventi/index.php?id=".$eventi['id'][$i]."'>";       
        $conta++; $thumb="th_"; if ($conta>3) {$thumb="ico_";}
        $icoart=$url."locandine/".$thumb.$eventi['img'][$i];
        if (file_exists($icoart) && $eventi['img'][$i]!=""){
            print "<img src='".$icoart."' alt='' class='thumb sx'>";
            }
        print "</a>";
    }
    print "</p></div>";
    print "</div>";
    }

// indirizzo, video+tag parole chiave, marchi 
    print "<div class='riga'>";
    
    print "<div class='colonna-1-3'>";
    print "<a name='dovesiamo'></a>";
    print "<h3 class='bianco sfTondo sfViola'>Dove siamo</h3>";
    
    print "<p>";
    if ($vetrina['mappa'][0]!="") {
		
        /*
        print "<iframe width='425' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='".$vetrina['mappa'][0]."'></iframe><br />";
        print "Clicca <a href='".$vetrina['mappa'][0]."'>QUI</a> se vuoi aprire la mappa in una nuova finestra<br /><br />";	
        }else{ print "<span class='nero'>".$indirizzoMappa."</span>";}
        */
        
        print $vetrina['mappa'][0];
        }
    print "</p>";
    print "</div>";

    print "<div class='colonna-1-3'>";
    $totMarchi=$mysql->conta_marchi($conn,$vetrina['idAttivita'][0]);
    if ($totMarchi>0) {
        $marchi=$mysql->marchi($conn,$vetrina['idAttivita'][0]);
        print "<h3 class='bianco sfTondo sfArancio'>Marchi</h3>";
        for ($i=0;$i<count($marchi['marchio']);$i++) {
            $txtConv=$myobj->mb_convert_encoding($marchi['marchio'][$i]);
            print "<h5><a href='".$url."ricerche/tutti-i-marchi.php#".strtolower($txtConv)."' rel='tag'><span class='arancio'>".$txtConv."</span></a></h5>";
            }
    }    
    print "</div>";

    print "<div class='colonna-1-3'>";
    $totVideo=$mysql->conta_video($conn,$vetrina['idAttivita'][0]);
    if ($totVideo>0) {
        $video=$mysql->video_vetrina($conn,$vetrina['idAttivita'][0]);
        print "<h3 class='bianco sfTondo sfGrigio'>Video</h3>";
        print "<p  class='testo'>";
        for ($i=0;$i<count($video['id']);$i++) {
        $contaVideo=$i+1;
                print $video['video'][$i]; print "<br /><br />";
                }
        print "</p>";
    }    

    $totParole=$mysql->conta_parole($conn,$vetrina['idAttivita'][0]);
    if ($totParole>0) {
        $parole=$mysql->parole($conn,$vetrina['idAttivita'][0]);
        print "<h3 class='bianco sfTondo sfVerde'>Tag ricerca</h3>";
        print "<p>";
        for ($i=0;$i<count($parole['parola']);$i++) {
            $txtConv=$myobj->mb_convert_encoding($parole['parola'][$i]);
            print "<a href='".$url."ricerche/parole-chiave.php#".strtolower($txtConv)."' rel='tag'>#".strtoupper($txtConv)."</a> ";
            }
        print "</p>";
    }    
    print "</div>";

    print "</div>";


    // BANNER SITI
    $banner=$mysql->banner($conn,$url,$vetrina['idAttivita'][0],$vetrina['cartella'][0]);
    if ($banner['totBanner'][0]>0) {
    print "<div class='riga'>";
    print "<div class='colonna-1'>";
    $txtConv=$myobj->mb_convert_encoding($vetrina['attivita'][0]);
    print "<h3 class='bianco sfTondo sfArancio'>".$txtConv." su internet</h3><br />";    
    for ($i=0;$i<count($banner['url']);$i++) {
        print "<p  class='testo'>";
        print "<a href='".$banner['url'][$i]."'>";
        print "<img src='".$url.$vetrina['cartella'][0]."/".$banner['banner'][$i]."' alt='banner".$i."' class='scala' /><br /><br />";
        print $banner['url'][$i]."</a><br />";   	
        $txtConv=$myobj->mb_convert_encoding($banner['descriz'][$i]);
        print $txtConv;
        print "<br /></p>"; 
    }
    print "</div>";
    print "</div>";
    }

print "</div>"; // chiude div microdati

$tipoPag="vetrina";
include "../config/stat_vetrine.php";
include "../config/footer.php";
?>
