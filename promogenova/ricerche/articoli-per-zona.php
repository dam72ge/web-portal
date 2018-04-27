<?php
$url="../";
$redirUrl="";
$idMacro=0; $idZona=0; $zona=""; $urlZona="";
$idR=0; $idP=0; $idC=0; $idM=0; $idQ=0;

// riconosci zona
if (isset($_GET['idR']) && $_GET['idR']>0 && $_GET['idR']!="") {
        $idZona=$_GET['idR']; $zona="regione"; $urlZona=$url."/territorio/regioni.php?idR=".$idZona;
    }
if (isset($_GET['idP']) && $_GET['idP']>0 && $_GET['idP']!="") {
        $idZona=$_GET['idP']; $zona="provincia"; $urlZona=$url."/territorio/province.php?idP=".$idZona;
    }
if (isset($_GET['idC']) && $_GET['idC']>0 && $_GET['idC']!="") {
        $idZona=$_GET['idC']; $zona="comune"; $urlZona=$url."/territorio/comuni.php?idC=".$idZona;
    }
if (isset($_GET['idM']) && $_GET['idM']>0 && $_GET['idM']!="") {
        $idZona=$_GET['idM']; $zona="municipio"; $urlZona=$url."/territorio/municipi.php?idM=".$idZona;
    }
if (isset($_GET['idQ']) && $_GET['idQ']>0 && $_GET['idQ']!="") {
        $idZona=$_GET['idQ']; $zona="quartiere"; $urlZona=$url."/territorio/quartieri.php?idQ=".$idZona;
    }
$idZona=ceil($idZona);    
if ($idZona==0 | $zona=="") {
$redirUrl=$url."ricerche/categorie-commerciali.php";
    if (!isset($_GET['idMacro']) | $_GET['idMacro']<1 | $_GET['idMacro']=="") {
    $redirUrl=$url."ricerche/macro.php?idMacro=".$_GET['idMacro'];
    }
}

// riconosci macro        
if ($redirUrl=="") {
    if (!isset($_GET['idMacro']) | $_GET['idMacro']<1 | $_GET['idMacro']=="") {
    $redirUrl=$urlZona;
    }
}
$idMacro=$_GET['idMacro'];
$idMacro=ceil($idMacro);    
if ($idMacro<1) {
$redirUrl=$url.$urlZona;
}

// riconoscimento incompleto -> redirect 
if ($redirUrl!="") {
header("location: $redirUrl");
}

// CARICA DB
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_articoli.php"; $myart=new myart;

// dati macro
$q=$myart->macro($conn,$idMacro);
$macro=ucfirst($q['macro']);
$macro=$myobj->mb_convert_encoding($macro);

// switch zone
$dove="";
$cosa="";
$idZ="";
switch ($zona){ 
	case "regione": 
        $where="WHERE idR='".$idZona."'"; 
        $q=$myobj->regioni($conn,$where,"");
        $regione=$myobj->mb_convert_encoding($q['regione'][1]); 
        $provincia=""; 
        $sigla="";
        $comune="";
        $municipio="";
        $quartiere="";
        $idR=$idZona; $idP=0; $idC=0; $idM=0; $idQ=0;
            $dove=$zona." ".$regione;
            $dove=ucwords($dove);
            $dove=$myobj->mb_convert_encoding($dove);
            $cosa=$macro." ".$regione;
            $cosa=ucwords($cosa);
            $cosa=$myobj->mb_convert_encoding($cosa);
            $idZ="&amp;idR=".$idR;
    	break;
	case "provincia":
        $where="AND idP='".$idZona."'"; 
        $q=$myobj->province($conn,$where,"");
        $regione=$myobj->mb_convert_encoding($q['regione'][1]); $idR=$q['idR'][1];
        $provincia=$myobj->mb_convert_encoding($q['provincia'][1]);
        $sigla=$myobj->mb_convert_encoding($q['sigla'][1]);
        $comune="";
        $municipio="";
        $quartiere="";
        $idP=$idZona; $idC=0; $idM=0; $idQ=0;
            $dove=ucwords($zona)." di ".ucwords($provincia);
            $dove=$myobj->mb_convert_encoding($dove);
            $cosa=$macro." in provincia di ".ucwords($provincia);
            $cosa=$myobj->mb_convert_encoding($cosa);
            $idZ="&amp;idP=".$idP;
    	break;
	case "comune":
        $where="AND idC='".$idZona."'"; 
        $q=$myobj->comuni($conn,$where,"");
        $regione=$myobj->mb_convert_encoding($q['regione'][1]); $idR=$q['idR'][1];
        $provincia=$myobj->mb_convert_encoding($q['provincia'][1]); $idP=$q['idP'][1];
        $sigla=$myobj->mb_convert_encoding($q['sigla'][1]);
        $comune=$myobj->mb_convert_encoding($q['comune'][1]);
        $municipio="";
        $quartiere="";
        $idC=$idZona; $idM=0; $idQ=0;
            $dove=ucwords($zona)." di ".ucwords($comune)." (".$sigla.")";
            $dove=$myobj->mb_convert_encoding($dove);
            $cosa=$macro." ".ucwords($comune);
            $cosa=$myobj->mb_convert_encoding($cosa);
            $idZ="&amp;idC=".$idC;
    	break;
	case "municipio":
        $where="AND idM='".$idZona."'"; 
        $q=$myobj->municipi($conn,$where,"");
        $regione=$myobj->mb_convert_encoding($q['regione'][1]); $idR=$q['idR'][1];
        $provincia=$myobj->mb_convert_encoding($q['provincia'][1]); $idP=$q['idP'][1];
        $sigla=$myobj->mb_convert_encoding($q['sigla'][1]);
        $comune=$myobj->mb_convert_encoding($q['comune'][1]); $idC=$q['idC'][1];
        $municipio=$myobj->mb_convert_encoding($q['municipio'][1]); 
        $quartiere="";
        $idM=$idZona; $idQ=0;
            $dove=ucwords($zona)." di ".ucwords($comune)." ".ucwords($municipio).")";
            $dove=$myobj->mb_convert_encoding($dove);
            $cosa=$macro." ".ucwords($comune)." ".ucwords($municipio);
            $cosa=$myobj->mb_convert_encoding($cosa);
            $idZ="&amp;idM=".$idM;
    	break;
	case "quartiere":
        $where="AND idQ='".$idZona."'"; 
        $q=$myobj->quartieri($conn,$where,"");
        $regione=$myobj->mb_convert_encoding($q['regione'][1]); $idR=$q['idR'][1];
        $provincia=$myobj->mb_convert_encoding($q['provincia'][1]); $idP=$q['idP'][1];
        $sigla=$myobj->mb_convert_encoding($q['sigla'][1]);
        $comune=$myobj->mb_convert_encoding($q['comune'][1]); $idC=$q['idC'][1];
        $municipio=$myobj->mb_convert_encoding($q['municipio'][1]); $idM=$q['idM'][1]; 
        $quartiere=$myobj->mb_convert_encoding($q['quartiere'][1]); 
        $idQ=$idZona;
            $dove=ucwords($comune)." ".ucwords($quartiere).")";
            $dove=$myobj->mb_convert_encoding($dove);
            $cosa=$macro." ".ucwords($comune)." ".ucwords($quartiere);
            $cosa=$myobj->mb_convert_encoding($cosa);
            $idZ="&amp;idQ=".$idQ;
    	break;
}

// struttura html
$title=$cosa;
$metaDescription="Articoli presenti nella categoria ".$macro." in ".$dove;
$metaKeywords=strtolower($cosa).", ".strtolower($dove).", ".strtolower($macro).", ".strtolower($zona).", categoria commerciale, promogenova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";

// risultati macro+zona
?>
<div class="riga">
<div class="colonna-1-2">
<h1><?php print $cosa; ?></h1>
<p class="testo"><?php print "Articoli presenti nella categoria ".$macro." per la zona ".$dove; ?></p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-2">
<p><img src="<?php print $url; ?>img/commerce.jpg" alt="vetrina" class="scala" /></p>
</div>
</div>


<?php
print "<div class='riga'>";
print "<div class='colonna-2-3'>";
print "<h3 class='bianco sfTondo sfVerde'>Articoli in <strong>".$macro."</strong></h3><br />";

// articoli in base a indirizzo attività e macro
switch ($zona){ 
	case "regione":
    $tabZona=",regioni, att_indirizzi";
    $where=" AND att_indirizzi.idR='".$idR."' AND regioni.idR='".$idR."' ";     
	break;
	case "provincia":
    $tabZona=",province, att_indirizzi";
    $where=" AND att_indirizzi.idP='".$idP."' AND province.idP='".$idP."' ";     
	break;
	case "comune":
    $tabZona=",comuni, att_indirizzi";
    $where=" AND att_indirizzi.idC='".$idC."' AND comuni.idC='".$idC."' ";     
	break;
	case "municipio":
    $tabZona=",municipi, att_indirizzi";
    $where=" AND att_indirizzi.idM='".$idM."' AND municipi.idM='".$idM."' ";     
	break;
	case "quartiere":
    $tabZona=",quartieri, att_indirizzi";
    $where=" AND att_indirizzi.idQ='".$idQ."' AND quartieri.idQ='".$idQ."' ";     
	break;
}
$where.=" AND macro.idMacro='".$idMacro."' AND attivita.idAttivita=att_indirizzi.idAttivita ";
$orderby="ORDER BY idArt DESC, titolo ASC, attivita ASC";
$articoli=$myart->articoli_macrozona($conn,$tabZona,$where,$orderby);

if (count($articoli['idArt'])>1) {
	for ($i=1;$i<count($articoli['idArt']);$i++) {
		print "<table><tr><td>";
	   
            print "<p><a href='".$url.$articoli['cartella'][$i]."/articoli.php?idArt=".$articoli['idArt'][$i]."'>";
            $immagine=$url.$articoli['cartella'][$i]."/articoli/".$articoli['img'][$i];
            $thumb=$url.$articoli['cartella'][$i]."/articoli/th_".$articoli['img'][$i];
            $spazi="";
                if ($articoli['img'][$i]!="" && file_exists($immagine)) {
	               print "<img src='".$thumb."' alt='img_".$articoli['idArt'][$i]."' class='sx thumb scala' />";
                   $spazi="<br /><br />";
                }
            $txtConv=$myobj->mb_convert_encoding($articoli['titolo'][$i]);
            print "<span class='testo rosso'>".ucfirst($txtConv)."</span>";
            print "</a><br />";
            $txtConv=$myobj->mb_convert_encoding($articoli['attivita'][$i]);
            print "Pubblicato da: <a href='".$url.$articoli['cartella'][$i]."'><span class='verde'>".ucfirst($txtConv)."</span></a>";
            print $spazi;
            print "<br /><br /></p>";    

		print "</td></tr></table>";
    }
}else {
print "<br />Al momento nessun articolo &egrave; presente in questa categoria.<br /><br />";
}
print "<br /><br />";

// articoli in promozione (fuori zona)
switch ($zona){ 
	case "regione":
    $tabZona=",regioni, articoli_promo";
    $where="AND articoli_promo.idR='".$idR."' AND regioni.idR='".$idR."' ";     
	break;
	case "provincia":
    $tabZona=",province, articoli_promo";
    $where="AND articoli_promo.idP='".$idP."' AND province.idP='".$idP."' ";     
	break;
	case "comune":
    $tabZona=",comuni, articoli_promo";
    $where="AND articoli_promo.idC='".$idC."' AND comuni.idC='".$idC."' ";     
	break;
	case "municipio":
    $tabZona=",municipi, articoli_promo";
    $where="AND articoli_promo.idM='".$idM."' AND municipi.idM='".$idM."' ";     
	break;
	case "quartiere":
    $tabZona=",quartieri, articoli_promo";
    $where="AND articoli_promo.idQ='".$idQ."' AND quartieri.idQ='".$idQ."' ";     
	break;
}
$where.=" AND macro.idMacro='".$idMacro."' AND articoli.idArt=articoli_promo.idArt";
$orderby="ORDER BY idArt DESC, titolo ASC, attivita ASC";

$articoli=$myart->articoli_macrozona($conn,$tabZona,$where,$orderby);

if (count($articoli['idArt'])>1) {
print "<br /><br /><h3 class='bianco sfTondo sfGrigio'>Articoli in promozione</h3>";

	for ($i=1;$i<count($articoli['idArt']);$i++) {
	   
            print "<p><a href='".$url.$articoli['cartella'][$i]."/articoli.php?idArt=".$articoli['idArt'][$i]."'>";
            $immagine=$url.$articoli['cartella'][$i]."/articoli/".$articoli['img'][$i];
            $thumb=$url.$articoli['cartella'][$i]."/articoli/th_".$articoli['img'][$i];
            $spazi="";
                if ($articoli['img'][$i]!="" && file_exists($immagine)) {
	               print "<img src='".$thumb."' alt='img_".$articoli['idArt'][$i]."' class='sx thumb scala' />";
                   $spazi="<br /><br />";
                }
            $txtConv=$myobj->mb_convert_encoding($articoli['titolo'][$i]);
            print "<span class='testo rosso'>".ucfirst($txtConv)."</span>";
            print "</a><br />";
            $txtConv=$myobj->mb_convert_encoding($articoli['attivita'][$i]);
            print "Pubblicato da: <a href='".$url.$articoli['cartella'][$i]."'><span class='verde'>".ucfirst($txtConv)."</span></a>";
            print $spazi;
            print "<br /><br /></p>";    

    }

print "<br /><br /><br /><br />";    
}

// suggerimenti ricerca
print "<h3 class='bianco sfTondo sfGiallo'>Cerca anche...</h3>";
print "<p class='testo'>";
print "<a href='".$url."ricerche/macro.php?idMacro=".$idMacro."'>Categoria ".$macro."</a><br />";

    // zona
if ($idR>0) { print "<a href='".$url."territorio/regioni.php?idR=".$idR."'>Regione ".ucwords($regione)."</a><br />"; }
if ($idP>0) { print "<a href='".$url."territorio/province.php?idP=".$idP."'>Provincia di ".ucwords($provincia)."</a><br />";}
if ($idC>0) { print "<a href='".$url."territorio/comuni.php?idC=".$idC."'>Comune di ".ucfirst($comune)."</a><br />"; }
if ($idM>0) { print "<a href='".$url."territorio/municipi.php?idM=".$idM."'>Municipio ".ucwords($comune)." ".ucwords($municipio)."</a><br />"; }
if ($idQ>0) { print "<a href='".$url."territorio/quartieri.php?idQ=".$idQ."'>".ucwords($comune)." ".ucwords($quartiere)."</a><br />"; }

    // combinate
if ($idR>0 && $zona!="regione") {
print "<a href='".$url."ricerche/articoli-per-zona.php?idR=".$idR."&amp;idMacro=".$idMacro."'>".$macro." in Regione ".$regione."</a><br />";
}
if ($idP>0 && $zona!="provincia") {
print "<a href='".$url."ricerche/articoli-per-zona.php?idP=".$idP."&amp;idMacro=".$idMacro."'>".$macro." in Provincia di ".ucfirst($provincia)."</a><br />";
}
if ($idC>0 && $zona!="comune") {
print "<a href='".$url."ricerche/articoli-per-zona.php?idC=".$idC."&amp;idMacro=".$idMacro."'>".$macro." nel Comune di ".ucfirst($comune)." (".$sigla.") </a><br />";
}
if ($idM>0 && $zona!="municipio") {
print "<a href='".$url."ricerche/articoli-per-zona.php?idM=".$idM."&amp;idMacro=".$idMacro."'>".$macro." nel Municipio di ".ucfirst($comune)." ".ucfirst($municipio)."</a><br />";
}
if ($idQ>0 && $zona!="quartiere") {
print "<a href='".$url."ricerche/articoli-per-zona.php?idQ=".$idQ."&amp;idMacro=".$idMacro."'>".$macro." a ".ucfirst($comune)." ".ucfirst($quartiere)."</a><br />";
}
print "</p>";
print "<br /><br /></div>";

print "<div class='colonna-1-3'>";
print "<h3 class='bianco sfTondo sfBlu'>Altre categorie</h3><br />";
    
    $sql_cat="
    SELECT idMacro, macro
    FROM macro 
    WHERE idMacro!='".$idMacro."'  
    ORDER BY macro ASC";
    $query_cat=mysqli_query($conn,$sql_cat);			
    while($cat=mysqli_fetch_array($query_cat,MYSQLI_ASSOC)){
    $txtConv=$myobj->mb_convert_encoding($cat['macro']); $txtConv=ucfirst($txtConv);
	print "<h5><a href='?idMacro=".$cat['idMacro'].$idZ."'>".$txtConv."</a></h5>";
    }

print "<br /><br /></div>";
print "</div>";

include "../config/footer.php";
?>
