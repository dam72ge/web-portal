<?php
$url="../";
$redirUrl=$url."territorio/";
if (!isset($_GET['idM']) | $_GET['idM']<1 | $_GET['idM']=="") {
header("location: $redirUrl");
}
include "../config/mydb.php";
$idM=$_GET['idM'];

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_territorio.php"; $mysql=new mysql;
$dati=$mysql->municipio($conn,$idM);
$municipio=ucwords($dati['municipio'][0]);
$municipio=$myobj->mb_convert_encoding($municipio);
$idC=$dati['idC'][0];
$comune=ucwords($dati['comune'][0]);
$comune=$myobj->mb_convert_encoding($comune);
$idP=$dati['idP'][0];
$provincia=ucwords($dati['provincia'][0]);
$provincia=$myobj->mb_convert_encoding($provincia);
$sigla=$dati['sigla'][0];
$idR=$dati['idR'][0];
$regione=ucwords($dati['regione'][0]);
$regione=$myobj->mb_convert_encoding($regione);
$municipi=$mysql->municipi_da_comune($conn,$idC);
$totMunicipi=count($municipi['idM'])-1;
$quartieri=$mysql->quartieri_da_municipio($conn,$idM);
$totQuartieri=count($quartieri['idQ'])-1;

// carica struttura html
$title="Municipio ".$comune." ".$municipio;
$metaDescription="Eventi, vetrine web, video nel Municipio di ".$comune." ".$municipio;
$metaKeywords="promogenova, municipio di ".$comune." ".$municipio.", eventi ".$comune." ".$municipio.", attivit&agrave; ".$comune." ".$municipio.", vetrine ".$comune." ".$municipio.", promozioni ".$comune." ".$municipio;

$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div itemscope itemtype="http://schema.org/Place">

<div class="riga">
<div class="colonna-1-2">
<h1 itemprop="name"><?php print $title; ?></h1>
Comune:  <?php print "<a href='comuni.php?idC=".$idC."'>".$comune."</a>"; ?>
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
if ($totQuartieri>0) {
print "<a href='#quartieri'>Quartieri del Municipio di ".$comune." ".$municipio."</a> | ";	
}
?>
<a href="#municipi">Altri Municipi nel Comune di <?php print $comune; ?></a>    
<br /><br /><br />
</p>
</div>
</div>

<?php
// articoli in promozione (ossia: piazzati fuori zona)
$ANDzona="AND idM='".$idM."'";
$ANDtutte="AND idR>0 AND idP>0 AND idC>0 AND idM='0' AND idQ='0'";
$quanti=5;
$mysql->promozioni_zona($conn,$ANDzona,$ANDtutte,$url,$municipio,$quanti);
?>



<div class="riga">
<div class="colonna-2-3">
<a name="vetrine"></a>
<h2 class="bianco sfTondo sfVerde">Vetrine web <?php print $comune." ".$municipio; ?></h2>
<p><br />
<?php
// vetrine
$where="idM='".$idM."'"; $orderby="idAttivita DESC";
$quanteVisualizzare=5; 
$mysql->vetrine_per_zona($conn,$where,$orderby,$url,$municipio,$quanteVisualizzare);
?>
</p><br /><br />
</div>

<div class="colonna-1-3">
<a name="categorie"></a>
<h2 class="bianco sfTondo sfRosso">Ricerca commerciale</h2>
<p class="testo"><br /><br />
<?php
$ANDzona="AND idM='".$idM."'";
$macro=$mysql->articoli_macro_per_zona($conn,$ANDzona);
if (count($macro['idMacro'])>1) {
    for ($i=1;$i<count($macro['idMacro']);$i++) {

        $titolo=$myobj->mb_convert_encoding($macro['macro'][$i]);
        print "<a href='".$url."ricerche/articoli-per-zona.php?idMacro=".$macro['idMacro'][$i]."&amp;idM=".$idM."'><span class='testo rosso'>".ucfirst($titolo)." ".$comune." ".$municipio."</span>:  ".$macro['riscontri'][$i]." articoli </a><br />";

    }
}
else{
print "Al momento non risultano pubblicazioni nel Municipio di ".$comune." ".$municipio.".<br /><br />";
}
?>
<br /><br />
</p>
</div>
</div>


<div class="riga">
<div class="colonna-1-2">
<a name="eventi"></a>
<h2 class="bianco sfTondo sfViola">Eventi <?php  print $comune." ".$municipio; ?></h2>
<p><br />
<?php
$ANDzona="AND idM='".$idM."'";
$quanti=15;
$mysql->eventi_per_zona($conn,$ANDzona,$url,$municipio,$quanti);
?>
<br /><br />
</p>
</div>
<div class="colonna-1-2">
<a name="video"></a>
<h2 class="bianco sfTondo sfBlu">Video <?php  print $comune." ".$municipio; ?></h2>
<p><br />
<?php
// video
$ANDzona="AND idM='".$idM."'";
$quanti=5;
$mysql->video_per_zona($conn,$ANDzona,$url,$municipio,$quanti);
?>
<br /><br />
</p>
</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<a name="album"></a>
<h2 class="bianco sfTondo sfGiallo">Album <?php  print $comune." ".$municipio; ?></h2>
<p><br />
<?php
$ANDzona="AND idM='".$idM."'";
$quanti=10;
$mysql->album_per_zona($conn,$ANDzona,$url,$municipio,$quanti);
?>
<br /><br />
</p>
</div>
<div class="colonna-1-2">
<a name="reti"></a>
<h2 class="bianco sfTondo sfArancio">Reti e Progetti <?php  print $comune." ".$municipio; ?></h2>
<p><br />
<?php
$ANDzona="AND idM='".$idM."'";
$quanti=10;
$mysql->reti_per_zona($conn,$ANDzona,$url,$municipio,$quanti);
?>
<br /><br />
</p>
</div>
</div>

<div class="riga">
<div class="colonna-1">
<a name="municipi"></a>
<h2 class="bianco sfTondo sfCeleste">Altri Municipi del Comune di <?php  print $comune; ?></h2>
<h3>
<?php
for ($i=1;$i<count($municipi['idM']);$i++) {
$nomeConv=$myobj->mb_convert_encoding($municipi['municipio'][$i]);
print $i." <a href='municipi.php?idM=".$municipi['idM'][$i]."'>".ucwords($nomeConv)."</a> &nbsp;&nbsp;&nbsp;";	
}
?>
<br /><br /><br /></h3>
</div>
</div>

<?php
if ($totQuartieri>0) {
print "<div class='riga'>";
print "<div class='colonna-1'>";
print "<a name='quartieri'></a>";
print "<h2 class='bianco sfTondo sfNero'>Quartieri e rioni nel Municipio di ".$comune." ".$municipio."</h2>";
print "<p>";
for ($i=1;$i<count($quartieri['idQ']);$i++) {
$nomeConv=$myobj->mb_convert_encoding($quartieri['quartiere'][$i]);
print "<h3><a href='quartieri.php?idQ=".$quartieri['idQ'][$i]."' class='nero'>".ucwords($nomeConv)."</a></h3>";
$nomeConv=$myobj->mb_convert_encoding($quartieri['rioni'][$i]);
if ($nomeConv!="") { print $nomeConv."<br /><br />"; }
}
print "<br /><br /><br /></p>";
print "</div>";	
print "</div>";	
}
?>

</div>
<?php
include "../config/footer.php";
?>
