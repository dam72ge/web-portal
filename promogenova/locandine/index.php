<?php
$url="../";
include "../config/mydb.php";
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_locandine.php"; $mysql=new mysql;

$locandine=$mysql->elenco_locandine($conn);
$totLocandine=count($locandine['idMedia'])-1;

// carica struttura html
$title="Locandine";
$metaDescription="Locandine pubblicate da Promogenova e da Attivit&agrave; clienti di Promogenova";
$metaKeywords="locandine, manifesti, volantini, promogenova";
$metaRobots="ALL";

	$opengraph="s";
	$og_title="Locandine pubblicate su Promogenova"; 	
	$og_url="http://www.promogenova.it/locandine/index.php";
    $og_image="img/luzzge.jpg";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Locandine</h1>
<p class="testo">Le locandine pubblicate su <b>Promogenova</b>.</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-4">
<p><img src="../img/luzzge.jpg" alt="icoloc" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="verde">Condividiamoci!</h4>
<p>Dalle locandine puoi risalire agli <a href="<?php print $url; ?>eventi/" rel="index">Eventi</a>, ai <a href="<?php print $url; ?>video/" rel="index">Video</a> e agli <a href="<?php print $url; ?>album/" rel="index">Album</a> per rivivere e continuare a diffondere la socializzazione, la cultura, la rivitalizzazione dei territori sui <em>social network</em>. 
<br /><br /><br />
</p>
</div>
</div>

<?php
// Ultime 10 locandine (i<11, tot>10)
print "<div class='riga'>";
print "<div class='colonna-1'><p>";    
print "<p>Clicca sulle immagini per visualizzare informazioni e collegamenti<br/><br/></p>";
for ($i=1;$i<count($locandine['idMedia']);$i++) {
	if ($i<11) {
    $urlImg=$url."locandine/".$locandine['img'][$i];
		if ($locandine['img'][$i]!="" && file_exists($urlImg)) {
		print "<a href='".$url."locandine/singola.php?idMedia=".$locandine['idMedia'][$i]."' rel='external'><img src='".$url."locandine/th_".$locandine['img'][$i]."' alt='loc_".$locandine['idMedia'][$i]."' class='scala' /></a> &nbsp; &nbsp;";
		}    
	}
}
print "</p></div>";
// Altre locandine dopo il decimo (elenco, i=11)
if ($totLocandine>10) {
print "<div class='riga'>";
print "<div class='colonna-1'>";
print "<h4 class='bianco sfTondo sfVerde'>Altre locandine</h4><br />";
for ($i=6;$i<count($locandine['idMedia']);$i++) {

    $urlImg=$url."locandine/".$locandine['img'][$i];
    if ($locandine['img'][$i]!="" && file_exists($urlImg)) {
    print "<a href='".$url."locandine/singola.php?idMedia=".$locandine['idMedia'][$i]."' rel='external'><img src='".$url."locandine/ico_".$locandine['img'][$i]."' alt='loc_".$locandine['idMedia'][$i]."' /></a> &nbsp;&nbsp;";
    }

}
print "<br /><br /></div>";
print "</div>";
}


?>


<?php
include "../config/footer.php";
?>
