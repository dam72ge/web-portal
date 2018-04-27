<?php
$url="../";
$redirUrl=$url."territorio/";
if (!isset($_GET['idP']) | $_GET['idP']<1 | $_GET['idP']=="") {
header("location: $redirUrl");
}
include "../config/mydb.php";
$idP=$_GET['idP'];;

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_territorio.php"; $mysql=new mysql;
$dati=$mysql->provincia($conn,$idP);
$provincia=ucwords($dati['provincia'][0]);
$provincia=$myobj->mb_convert_encoding($provincia);
$sigla=$dati['sigla'][0];
$idR=$dati['idR'][0];
$regione=ucwords($dati['regione'][0]);
$regione=$myobj->mb_convert_encoding($regione);
$comuni=$mysql->comuni_da_provincia($conn,$idP);

// carica struttura html
$title="Provincia di ".$provincia;
$metaDescription="Eventi, vetrine web, video nella Provincia di ".$provincia;
$metaKeywords="promogenova, provincia, ".$provincia.", ".$sigla;
$metaKeywords="promogenova, provincia ".$provincia.", eventi ".$provincia.", attivit&agrave; ".$provincia.", vetrine ".$provincia.", promozioni ".$provincia;
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div itemscope itemtype="http://schema.org/Place">

<div class="riga">
<div class="colonna-1-2">
<h1 itemprop="name"><?php print $title; ?></h1>
Regione:  <?php print "<a href='regioni.php?idR=".$idR."'>".$regione."</a>"; ?>
<br /><br />
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
<a href="#comuni">Comuni in Provincia di <?php print $provincia; ?></a>    
<br /><br /><br />
</p>
</div>
</div>

<?php
// articoli in promozione (ossia: piazzati fuori zona)
$ANDzona="AND idP='".$idP."'";
$ANDtutte="AND idR>0 AND idP='0' AND idC='0' AND idM='0' AND idQ='0'";
$quanti=5;
$mysql->promozioni_zona($conn,$ANDzona,$ANDtutte,$url,$provincia,$quanti);
?>

<div class="riga">
<div class="colonna-2-3">
<a name="vetrine"></a>
<h2 class="bianco sfTondo sfVerde">Vetrine web <?php print $provincia." (".$sigla.")"; ?></h2>
<?php
// vetrine
$where="idP='".$idP."'"; $orderby="idAttivita DESC";
$quanteVisualizzare=5;
$mysql->vetrine_per_zona($conn,$where,$orderby,$url,$provincia,$quanteVisualizzare);
?>
<br /><br />
</p>
</div>



<div class="colonna-1-3">
<a name="categorie"></a>
<h2 class="bianco sfTondo sfRosso">Ricerca commerciale</h2>
<p class="testo"><br />
<?php
$ANDzona="AND idP='".$idP."'";
$macro=$mysql->articoli_macro_per_zona($conn,$ANDzona);
if (count($macro['idMacro'])>1) {
    for ($i=1;$i<count($macro['idMacro']);$i++) {

        $titolo=$myobj->mb_convert_encoding($macro['macro'][$i]);
        print "<a href='".$url."ricerche/articoli-per-zona.php?idMacro=".$macro['idMacro'][$i]."&amp;idP=".$idP."'><span class='testo rosso'>".ucfirst($titolo)." in provincia di ".$provincia."</span>:  ".$macro['riscontri'][$i]." articoli </a><br />";

    }
}
else{
print "Al momento non risultano pubblicazioni in ".$provincia.".<br /><br />";
}
?>
<br /><br />
</p>
</div>
</div>


<div class="riga">
<div class="colonna-1-2">
<a name="eventi"></a>
<h2 class="bianco sfTondo sfViola">Eventi <?php print $provincia; ?></h2>
<?php
$ANDzona="AND idP='".$idP."'";
$quanti=10;
$mysql->eventi_per_zona($conn,$ANDzona,$url,$provincia,$quanti);
?>
<br /><br />
</p>
</div>
<div class="colonna-1-2">
<a name="video"></a>
<h2 class="bianco sfTondo sfBlu">Video <?php print $provincia; ?></h2>
<?php
// video
$ANDzona="AND idP='".$idP."'";
$quanti=5;
$mysql->video_per_zona($conn,$ANDzona,$url,$provincia,$quanti);
?>
</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<a name="album"></a>
<h2 class="bianco sfTondo sfGiallo">Album <?php print $provincia; ?></h2>
<?php
$ANDzona="AND idP='".$idP."'";
$quanti=10;
$mysql->album_per_zona($conn,$ANDzona,$url,$provincia,$quanti);
?>
</div>
<div class="colonna-1-2">
<a name="reti"></a>
<h2 class="bianco sfTondo sfArancio">Reti e Progetti <?php print $provincia; ?></h2>
<?php
$ANDzona="AND idP='".$idP."'";
$quanti=10;
$mysql->reti_per_zona($conn,$ANDzona,$url,$provincia,$quanti);
?>
</div>
</div>

<?php
print "<div class='riga'>";
print "<div class='colonna-1'>";
print "<a name='comuni'></a>";
print "<h2 class='bianco sfTondo sfNero'>Comuni in Provincia di ".$provincia."</h2>";
print "<p class='testo'>";
for ($i=1;$i<count($comuni['idC']);$i++) {
$nomeConv=$myobj->mb_convert_encoding($comuni['comune'][$i]);
print $i." <a href='comuni.php?idC=".$comuni['idC'][$i]."'><span class='nero'>".ucwords($nomeConv)."</span></a> &nbsp;&nbsp;&nbsp;";	
}
print "<br /><br /><br /></p>";
print "</div>";	
print "</div>";	

?>

</div>
<?php
include "../config/footer.php";
?>
