<?php
$url="../"; 
include "../config/mydb.php";
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_vetrina.php"; $mysql=new mysql; 
require_once "../config/class_articoli.php"; $myart=new myart; 
require_once "../config/class_db.php"; $db=new db; 

// riconosci vetrina
$vetrina=$mysql->identifica($conn,$_SERVER['PHP_SELF'],2);

// controllo
if ($vetrina['msgID'][0]!=""){
$pagOscurata=$url."modelli/vetrina-oscurata.php?msgID=".$vetrina['msgID'][0];
header("location: $pagOscurata");
}

// idArt
if (!isset($_GET['idArt']) | $_GET['idArt']=="" | $_GET['idArt']<1) {
$redirUrl=$url.$vetrina['cartella'][0];
header("location: $redirUrl");
}
$idArt=$_GET['idArt'];

// riconosci articoli
$art=$myart->articolo($conn,$idArt);

// articolo oscurato?
if ($art['osc']=="s") {
$redirUrl=$url.$vetrina['cartella'][0];
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='".$redirUrl."';\n"; 
  echo "</script>"; 
}


// struttura html
//$txtConv=$myobj->mb_convert_encoding($art['titolo']); $title=ucfirst($txtConv);
$title=ucfirst($art['titolo']); $txtConv=$title;
$txtAtt=$myobj->mb_convert_encoding($vetrina['attivita'][0]); 
$metaDescription=ucfirst($txtConv)." - Articolo pubblicato da ".ucwords(strtolower($txtAtt));

    $txtMacro=$myobj->mb_convert_encoding($art['macro']);
    $txtR=", ".$myobj->mb_convert_encoding($vetrina['regione'][0]); 
    $txtP=", provincia di ".$myobj->mb_convert_encoding($vetrina['provincia'][0]); 
    $txtC=", comune di ".$myobj->mb_convert_encoding($vetrina['comune'][0]); 
    $txtM=", ".$myobj->mb_convert_encoding($vetrina['comune'][0])." ".$myobj->mb_convert_encoding($vetrina['municipio'][0]); 
    $txtQ=", ".$myobj->mb_convert_encoding($vetrina['comune'][0])." ".$myobj->mb_convert_encoding($vetrina['quartiere'][0]); 

$metaKeywords=strtolower($title).", ".strtolower($vetrina['attivita'][0]).", ".strtolower($txtMacro).strtolower($txtR).strtolower($txtP).strtolower($txtC).strtolower($txtM).strtolower($txtQ);
$metaRobots="ALL";


//opengraph
$opengraph="s";
$og_title=$myobj->mb_convert_encoding($art['titolo']); 
$og_type="article";
$og_url="http://www.promogenova.it/".$_SERVER['PHP_SELF']."?idArt=".$idArt;
$icoart=$vetrina['cartella'][0]."/articoli/th_".$art['img'];
$og_image="";
if ($art['img']!=""){ $og_image=$icoart; }            

//twitter
$twitter="s";
$twitter_title=$myobj->mb_convert_encoding($art['titolo']); 
$twitter_url="http://www.promogenova.it/".$_SERVER['PHP_SELF']."?idArt=".$idArt;
$icoart=$vetrina['cartella'][0]."/articoli/th_".$art['img'];
$twitter_image="";
if ($art['img']!=""){ $twitter_image=$icoart; }            


include "../config/head.php";
include "../config/header-nav.php";


print "<div itemscope itemtype='http://schema.org/Product'>"; // div microdati

    print "<div class='riga'>";
    print "<div class='colonna-1-2'>";
    // titolo
    $txtConv=$myobj->mb_convert_encoding($art['titolo']); 
    print "<br /><h1 class='verde' itemprop='name'>".ucfirst($txtConv)."</h1>";   
    print "</div>";
    print "<div class='colonna-1-4'>";
    // immagine allegata    
    $icoart=$url.$vetrina['cartella'][0]."/articoli/th_".$art['img'];
    $imgart=$url.$vetrina['cartella'][0]."/articoli/".$art['img'];
        if (file_exists($icoart) && $art['img']!=""){
        print "<p>";
        print "<figure itemprop='image'><a href='".$imgart."'>";
        print "<img src='".$icoart."' alt='art#".$idArt."' title='Clicca per visualizzare nelle dimensioni reali' class='scala'></img>";
        print "</a></figure>";
        print "<figcaption></figcaption>";
        print "</p>";
        }            
    print "</div>";
    // dati vetrina
    print "<div class='colonna-1-4'><p>Articolo pubblicato da ";
    $txtConv=$myobj->mb_convert_encoding($vetrina['attivita'][0]); 
    print "<h3><a href='".$url.$vetrina['cartella'][0]."' rel='index'><span class='rosso'>".$txtConv."</span></a></h3>";   
    if ($vetrina['partitaiva'][0]!=""){ print "Partita I.V.A. <span class='nero'>".$vetrina['partitaiva'][0]."</span><br />";}
	if ($vetrina['codfisc'][0]!=""){ print "Codice Fiscale <span class='nero'>".$vetrina['codfisc'][0]."</span><br />";}
    print "</p>";
    print "</div>";
    print "</div>";



    print "<div class='riga'>";

    print "<div class='colonna-1-2'>";
    // testo
    print "<p class='testo' itemprop='description'>";
    $txtConv=$myobj->mb_convert_encoding($art['testo']); 
    print nl2br($txtConv);
    //print nl2br($art['testo']);   
    print "<br /><br /></p>";    
    print "</div>";
    
    print "<div class='colonna-1-4'>";
    print "<h4 class='bianco sfTondo sfGiallo'>Dove</h4><p>";   
    //luogo
    if ($vetrina['idC'][0]>0) {
        $comune=$myobj->mb_convert_encoding($vetrina['comune'][0]);
        print "Comune: <a href='".$url."territorio/comuni.php?idC=".$vetrina['idC'][0]."' rel='index'>".ucwords($comune)."</span></a> (".$vetrina['sigla'][0].")<br />";
            if ($vetrina['idM'][0]>0) {
            $municipio=$myobj->mb_convert_encoding($vetrina['municipio'][0]);
            print "Municipio: <a href='".$url."territorio/municipi.php?idM=".$vetrina['idM'][0]."' rel='index'>".ucwords($municipio)."</a><br />";
            }	    
            if ($vetrina['idQ'][0]>0) {
            $quartiere=$myobj->mb_convert_encoding($vetrina['quartiere'][0]);
            print "Quartiere: <a href='".$url."territorio/quartieri.php?idQ=".$vetrina['idQ'][0]."' rel='index'>".ucwords($quartiere)."</a><br />";
            }	    
    }
    if ($vetrina['idP'][0]>0) {
        $provincia=$myobj->mb_convert_encoding($vetrina['provincia'][0]);
        print "Provincia: <a href='".$url."territorio/province.php?idP=".$vetrina['idP'][0]."' rel='index'>".ucwords($provincia)."</span></a><br />";
    }	    
    if ($vetrina['idR'][0]>0) {
        $regione=$myobj->mb_convert_encoding($vetrina['regione'][0]);
        print "Regione: <a href='".$url."territorio/regioni.php?idR=".$vetrina['idR'][0]."' rel='index'>".ucwords($regione)."</span></a><br />";
    }	    
    if ($vetrina['altraZona'][0]>0) {
        $altraZona=$myobj->mb_convert_encoding($vetrina['altraZona'][0]);
        print "Zona: ".ucwords($altraZona);
    }	        
    print "<br /><br /></p>";
    $txtConv=$myobj->mb_convert_encoding($vetrina['attivita'][0]); 
    print "<h4 class='bianco sfTondo sfGiallo'>Categoria</h4>";   
    $txtConv=$myobj->mb_convert_encoding($art['macro']); 
    print "<h5><a href='".$url."ricerche/macro.php?idMacro=".$art['idMacro']."' rel='index'>".ucfirst($txtConv)."</a></h5><br /><br />"; 
    
    print "<h4 class='bianco sfTondo sfArancio'>Vuoi saperne di pi&ugrave;?</h4><p>";   
    $txtConv=$myobj->mb_convert_encoding($vetrina['attivita'][0]); 
    print "<p><a href='".$url.$vetrina['cartella'][0]."' rel='index'><img src='".$url."lay/continua.png'/> Visita la vetrina di <strong>".$txtConv."</strong></a></p>";   
    print "</div>";

    print "<div class='colonna-1-4'>";
    // altri articoli   
    $txtConv=$myobj->mb_convert_encoding($vetrina['attivita'][0]); 
    print "<h4 class='bianco sfTondo sfGrigio'>Altri articoli </h4>"; // di ".$txtConv."
    print "<p>";
    $where="AND articoli.idArt!='".$idArt."' ";
    $altri=$myart->elenco_articoli($conn,$vetrina['idAttivita'][0],$where);
        for ($i=1;$i<count($altri['idArt']);$i++) {
            print "<a href='".$url.$vetrina['cartella'][0]."/articoli.php?idArt=".$altri['idArt'][$i]."'>";
            $icoart=$url.$vetrina['cartella'][0]."/articoli/ico_".$altri['img'][$i];
            if (file_exists($icoart) && $altri['img'][$i]!=""){
                print "<img src='".$icoart."' alt='' class='thumb sx'> ";
                }            
            $txtConv=$myobj->mb_convert_encoding($altri['titolo'][$i]);
            print "<span class='verde'>".$txtConv."</span></a><br /><br /></p>";
            print "</a> ";
        }
    print "<br /><br /></p>";   
    print "</div>";

    print "</div>";

print "</div>"; // chiude div microdati

$tipoPag="articolo";
include "../config/stat_vetrine.php";
include "../config/footer.php";
?>
