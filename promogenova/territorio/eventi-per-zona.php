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
$redirUrl=$url."territorio/index.php";
}

// riconoscimento incompleto -> redirect 
if ($redirUrl!="") {
header("location: $redirUrl");
}

// CARICA DB
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_territorio.php"; $mysql=new mysql;

// switch zone
$dove="";
switch ($zona){ 
	case "regione": 
        $where="WHERE idR='".$idZona."'"; 
        $q=$myobj->regioni($where,"");
        $regione=$myobj->convTxt($q['regione'][1]); 
        $provincia=""; 
        $sigla="";
        $comune="";
        $municipio="";
        $quartiere="";
        $idR=$idZona; $idP=0; $idC=0; $idM=0; $idQ=0;
            $dove=$zona." ".$regione;
            $dove=ucwords($dove);
            $dove=$myobj->convTxt($dove);
    	break;
	case "provincia":
        $where="AND idP='".$idZona."'"; 
        $q=$myobj->province($where,"");
        $regione=$myobj->convTxt($q['regione'][1]); $idR=$q['idR'][1];
        $provincia=$myobj->convTxt($q['provincia'][1]);
        $sigla=$myobj->convTxt($q['sigla'][1]);
        $comune="";
        $municipio="";
        $quartiere="";
        $idP=$idZona; $idC=0; $idM=0; $idQ=0;
            $dove=ucwords($zona)." di ".ucwords($provincia);
            $dove=$myobj->convTxt($dove);
    	break;
	case "comune":
        $where="AND idC='".$idZona."'"; 
        $q=$myobj->comuni($where,"");
        $regione=$myobj->convTxt($q['regione'][1]); $idR=$q['idR'][1];
        $provincia=$myobj->convTxt($q['provincia'][1]); $idP=$q['idP'][1];
        $sigla=$myobj->convTxt($q['sigla'][1]);
        $comune=$myobj->convTxt($q['comune'][1]);
        $municipio="";
        $quartiere="";
        $idC=$idZona; $idM=0; $idQ=0;
            $dove=ucwords($zona)." di ".ucwords($comune)." (".$sigla.")";
            $dove=$myobj->convTxt($dove);
    	break;
	case "municipio":
        $where="AND idM='".$idZona."'"; 
        $q=$myobj->municipi($where,"");
        $regione=$myobj->convTxt($q['regione'][1]); $idR=$q['idR'][1];
        $provincia=$myobj->convTxt($q['provincia'][1]); $idP=$q['idP'][1];
        $sigla=$myobj->convTxt($q['sigla'][1]);
        $comune=$myobj->convTxt($q['comune'][1]); $idC=$q['idC'][1];
        $municipio=$myobj->convTxt($q['municipio'][1]); 
        $quartiere="";
        $idM=$idZona; $idQ=0;
            $dove=ucwords($zona)." di ".ucwords($comune)." ".ucwords($municipio);
            $dove=$myobj->convTxt($dove);
    	break;
	case "quartiere":
        $where="AND idQ='".$idZona."'"; 
        $q=$myobj->quartieri($where,"");
        $regione=$myobj->convTxt($q['regione'][1]); $idR=$q['idR'][1];
        $provincia=$myobj->convTxt($q['provincia'][1]); $idP=$q['idP'][1];
        $sigla=$myobj->convTxt($q['sigla'][1]);
        $comune=$myobj->convTxt($q['comune'][1]); $idC=$q['idC'][1];
        $municipio=$myobj->convTxt($q['municipio'][1]); $idM=$q['idM'][1]; 
        $quartiere=$myobj->convTxt($q['quartiere'][1]); 
        $idQ=$idZona;
            $dove=ucwords($comune)." ".ucwords($quartiere);
            $dove=$myobj->convTxt($dove);
    	break;
}

// struttura html
$title="Eventi ".$dove;
$metaDescription="Tutti gli Eventi in ".$dove;
$metaKeywords="eventi promogenova, eventi ".strtolower($dove).", eventi ".strtolower($zona).", promogenova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1><?php print $title; ?></h1>
<br /><br /><br />
</div>
<div class="colonna-1-4">
<p><img src="../img/territorio-cerca.jpg" alt="territorio" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="rosso">Cambia zona</h4>
<p id="menu">
<?php
if ($quartiere!="") { print "<a href='quartieri.php?idQ=".$idQ."'>".ucfirst($comune)." ".ucfirst($quartiere)."</a><br />"; }
if ($municipio!="") { print "<a href='municipi.php?idM=".$idM."'>".ucfirst($comune)." Municipio ".ucfirst($municipio)."</a><br />"; }
if ($comune!="") { print "<a href='comuni.php?idC=".$idC."'>Comune di ".ucfirst($comune)." (".$sigla.")</a><br />"; }
if ($provincia!="") { print "<a href='province.php?idP=".$idP."'>Provincia di ".ucfirst($provincia)."</a><br />"; }
if ($regione!="") { print "<a href='regioni.php?idR=".$idR."'>Regione ".ucwords($regione)."</a><br />"; }
?>
</p>
</div>
</div>

<div class="riga">
<div class="colonna-1">
<a name="eventi"></a>
<h2 class="bianco sfTondo sfVerde">Eventi <?php print $dove; ?></h2>
<p><br />
<?php
// vetrine
$ANDzona=$where;
if ($zona=="regione") { $ANDzona=str_replace("WHERE","AND",$where); }
$quanti=1500;
//  function eventi_per_zona($ANDzona,$url,$zona,$quanti){  
$mysql->eventi_per_zona($ANDzona,$url,$zona,$quanti);
?>
</p><br /><br />
</div>
</div>


<?php
include "../config/footer.php";
?>