<?php
$url="../";
$redirUrl=$url."territorio/";
if (!isset($_GET['idC']) | $_GET['idC']<1 | $_GET['idC']=="") {
header("location: $redirUrl");
}
include "../config/mydb.php";
$idC=$_GET['idC'];

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_territorio.php"; $mysql=new mysql;
$dati=$mysql->comune($conn,$idC);
$comune=ucwords($dati['comune'][0]);
$comune=$myobj->mb_convert_encoding($comune);
$idP=$dati['idP'][0];
$provincia=ucwords($dati['provincia'][0]);
$provincia=$myobj->mb_convert_encoding($provincia);
$sigla=$dati['sigla'][0];
$idR=$dati['idR'][0];
$regione=ucwords($dati['regione'][0]);
$regione=$myobj->mb_convert_encoding($regione);
$comuni=$mysql->comuni_da_provincia($conn,$idP);
$municipi=$mysql->municipi_da_comune($conn,$idC);
$totMunicipi=count($municipi['idM'])-1;

// carica struttura html
$title="Comune di ".$comune." (".$sigla.")";
$metaDescription="Eventi, vetrine web, video nel Comune di ".$comune;
$metaKeywords="promogenova, comune di ".$comune." (".$sigla."), eventi ".$comune." (".$sigla."), attivit&agrave; ".$comune." (".$sigla."), vetrine ".$comune." (".$sigla."), promozioni ".$comune." (".$sigla.")";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div itemscope itemtype="http://schema.org/Place">

<div class="riga">
<div class="colonna-1-2">
<h1 itemprop="name"><?php print $title; ?></h1>
Provincia:  <?php print "<a href='province.php?idP=".$idP."'>".$provincia."</a>"; ?> - 
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
<a href="#reti">Reti e progetti</a> | 
<?php
if ($totMunicipi>0) {
print "<a href='#municipi'>Municipi del Comune di ".$comune."</a> | ";	
}
?>
<a href="#comuni">Altri Comuni nella Provincia di <?php print $provincia; ?></a>    
<br /><br /><br />
</p>
</div>
</div>

<?php
// articoli in promozione (ossia: piazzati fuori zona)
$ANDzona="AND idC='".$idC."'";
$ANDtutte="AND idR>0 AND idP>0 AND idC='0' AND idM='0' AND idQ='0'";
$quanti=5;
$mysql->promozioni_zona($conn,$ANDzona,$ANDtutte,$url,$comune,$quanti);
?>

<div class="riga">
<div class="colonna-1-2">
<a name="vetrine"></a>
<h2 class="bianco sfTondo sfVerde">Vetrine web <?php print $comune." (".$sigla.")"; ?></h2>
<p><br />
<?php
// vetrine
$where="idC='".$idC."'"; $orderby="idAttivita DESC";
$quanteVisualizzare=5;
$mysql->vetrine_per_zona($conn,$where,$orderby,$url,$comune,$quanteVisualizzare);
?>
<br /><br />
</p>
</div>

<div class="colonna-1-2">
<a name="categorie"></a>
<h2 class="bianco sfTondo sfRosso">Ricerca commerciale</h2>
<p class="testo"><br />
<?php
$ANDzona="AND idC='".$idC."'";
$macro=$mysql->articoli_macro_per_zona($conn,$ANDzona);
if (count($macro['idMacro'])>1) {
    for ($i=1;$i<count($macro['idMacro']);$i++) {

        $titolo=$myobj->mb_convert_encoding($macro['macro'][$i]);
        print "<a href='".$url."ricerche/articoli-per-zona.php?idMacro=".$macro['idMacro'][$i]."&amp;idC=".$idC."'><span class='testo rosso'>".ucfirst($titolo)." ".$comune."</span>:  ".$macro['riscontri'][$i]." articoli </a><br />";

    }
}
else{
print "Al momento non risultano pubblicazioni in Comune di ".$comune.".<br /><br />";
}
?>
<br /><br />
</p>
</div>
</div>


<div class="riga">
<div class="colonna-1-2">
<a name="eventi"></a>
<h2 class="bianco sfTondo sfViola">Eventi <?php  print $comune." (".$sigla.")"; ?></h2>
<p><br />
<?php
$ANDzona="AND idC='".$idC."'";
$quanti=15;
$mysql->eventi_per_zona($conn,$ANDzona,$url,$comune,$quanti);
?>
<br /><br />
</p>
</div>
<div class="colonna-1-2">
<a name="video"></a>
<h2 class="bianco sfTondo sfBlu">Video <?php  print $comune." (".$sigla.")"; ?></h2>
<p><br />
<?php
// video
$ANDzona="AND idC='".$idC."'";
$quanti=5;
$mysql->video_per_zona($conn,$ANDzona,$url,$comune,$quanti);
?>
<br /><br />
</p>
</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<a name="album"></a>
<h2 class="bianco sfTondo sfGiallo">Album <?php  print $comune." (".$sigla.")"; ?></h2>
<p><br />
<?php
$ANDzona="AND idC='".$idC."'";
$quanti=10;
$mysql->album_per_zona($conn,$ANDzona,$url,$comune,$quanti);
?>
<br /><br />
</p>
</div>
<div class="colonna-1-2">
<a name="reti"></a>
<h2 class="bianco sfTondo sfArancio">Reti e Progetti <?php  print $comune." (".$sigla.")"; ?></h2>
<p><br />
<?php
$ANDzona="AND idC='".$idC."'";
$quanti=10;
$mysql->reti_per_zona($conn,$ANDzona,$url,$comune,$quanti);
?>
<br /><br />
</p>
</div>
</div>

<?php
if ($totMunicipi>0) {
print "<div class='riga'>";
print "<div class='colonna-1'>";
print "<a name='municipi'></a>";
print "<h2 class='bianco sfTondo sfCeleste'>Municipi del Comune di ".$comune."</h2>";
print "<h3>";
for ($i=1;$i<count($municipi['idM']);$i++) {
$nomeConv=$myobj->mb_convert_encoding($municipi['municipio'][$i]);
print $i." <a href='municipi.php?idM=".$municipi['idM'][$i]."'>".ucwords($nomeConv)."</a> &nbsp;&nbsp;&nbsp;";	
}
print "<br /><br /><br /></h3>";
print "</div>";	
print "</div>";	
}
?>

<div class="riga">
<div class="colonna-1">
<a name="comuni"></a>
<h2 class="bianco sfTondo sfNero">Altri Comuni nella Provincia di <?php  print $provincia." (".$sigla.")"; ?></h2>
<p class="testo">
<?php
for ($i=0;$i<count($comuni['idC']);$i++) {
$nomeConv=$myobj->mb_convert_encoding($comuni['comune'][$i]);
print "<a href='comuni.php?idC=".$comuni['idC'][$i]."' class='nero'>".ucwords($nomeConv)."</a> ";	
}
?>
<br /><br />
</p>
</div>
</div>

</div>
<?php
include "../config/footer.php";
?>
