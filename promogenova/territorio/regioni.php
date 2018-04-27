<?php
$url="../";
$redirUrl=$url."territorio/";
if (!isset($_GET['idR']) | $_GET['idR']<1 | $_GET['idR']=="") {
header("location: $redirUrl");
}
include "../config/mydb.php";
$idR=$_GET['idR'];;

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_territorio.php"; $mysql=new mysql;
$regione=$mysql->regione($conn,$idR); $regione=ucwords($regione);
$regione=$myobj->mb_convert_encoding($regione);
$province=$mysql->province_da_regione($conn,$idR);

// carica struttura html
$title="Regione ".$regione;
$metaDescription="Eventi, vetrine web, video nella Regione ".$regione;
$metaKeywords="promogenova, regioni, ".$regione.", eventi ".$regione.", attivit&agrave; ".$regione.", vetrine ".$regione.", promozioni ".$regione;
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div itemscope itemtype="http://schema.org/Place">

<div class="riga">
<div class="colonna-1-2">
<h1 itemprop="name"><?php print $title; ?></h1>
<p class="testo"> 
<?php
for ($i=0;$i<count($province['idP']);$i++) {
print "<a href='province.php?idP=".$province['idP'][$i]."'>".ucwords($province['provincia'][$i])."</a> ";	
}
?>
</p>
<br /><br /><br />
</div>
<div class="colonna-1-4">

<p><img src="../img/territorio-cerca.jpg" alt="territorio" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="rosso">Ricerca veloce</h4>
<p id="menu">
<a href="#vetrine">Vetrine</a> | 
<a href="#categorie">Ricerca commerciale</a> |   
<a href="#eventi">Eventi</a> |   
<a href="#video">Video</a> | 
<a href="#album">Album</a> |  
<a href="#reti">Reti e progetti</a>    
<br /><br /><br />
</p>
</div>
</div>

<?php
// articoli in promozione (ossia: piazzati fuori zona)
$ANDzona="AND idR='".$idR."'";
$ANDtutte="AND idR='0' AND idP='0' AND idC='0' AND idM='0' AND idQ='0'";
$quanti=5;
$mysql->promozioni_zona($conn,$ANDzona,$ANDtutte,$url,$regione,$quanti);
?>

<div class="riga">
<div class="colonna-1-2">
<a name="vetrine"></a>
<h2 class="bianco sfTondo sfVerde">Vetrine web <?php print $regione; ?></h2>
<?php
// vetrine
$where="idR='".$idR."'"; $orderby="idAttivita DESC";
$quanteVisualizzare=5;
$mysql->vetrine_per_zona($conn,$where,$orderby,$url,$regione,$quanteVisualizzare);
?>
<br /><br />
</p>
</div>
<div class="colonna-1-2">
<a name="categorie"></a>
<h2 class="bianco sfTondo sfRosso">Ricerca commerciale</h2>
<p class="testo"><br />
<?php
$ANDzona="AND idR='".$idR."'";
$macro=$mysql->articoli_macro_per_zona($conn,$ANDzona);
if (count($macro['idMacro'])>1) {
    for ($i=1;$i<count($macro['idMacro']);$i++) {

        $titolo=$myobj->mb_convert_encoding($macro['macro'][$i]);
        print "<a href='".$url."ricerche/articoli-per-zona.php?idMacro=".$macro['idMacro'][$i]."&amp;idR=".$idR."'><span class='testo rosso'>".ucfirst($titolo)." ".$regione."</span>:  ".$macro['riscontri'][$i]." articoli </a><br />";

    }
}
else{
print "Al momento non risultano pubblicazioni in ".$regione.".<br /><br />";
}
?>
<br /><br />
</p>

</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<a name="eventi"></a>
<h2 class="bianco sfTondo sfViola">Eventi <?php print $regione; ?></h2>
<?php
$ANDzona="AND idR='".$idR."'";
$quanti=5;
$mysql->eventi_per_zona($conn,$ANDzona,$url,$regione,$quanti);
?>
<br /><br />
</p>
</div>
<div class="colonna-1-2">
<a name="video"></a>
<h2 class="bianco sfTondo sfBlu">Video <?php print $regione; ?></h2>
<?php
// video
$ANDzona="AND idR='".$idR."'";
$quanti=5;
$mysql->video_per_zona($conn,$ANDzona,$url,$regione,$quanti);
?>
</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<a name="album"></a>
<h2 class="bianco sfTondo sfGiallo">Album <?php print $regione; ?></h2>
<?php
$ANDzona="AND idR='".$idR."'";
$quanti=10;
$mysql->album_per_zona($conn,$ANDzona,$url,$regione,$quanti);
?>
</div>
<div class="colonna-1-2">
<a name="reti"></a>
<h2 class="bianco sfTondo sfArancio">Reti e Progetti <?php print $regione; ?></h2>
<?php
$ANDzona="AND idR='".$idR."'";
$quanti=10;
$mysql->reti_per_zona($conn,$ANDzona,$url,$regione,$quanti);
?>
</div>
</div>

</div>
<?php
include "../config/footer.php";
?>
