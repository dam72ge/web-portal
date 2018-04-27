<?php
$url="../";
$redirUrl=$url."locandine/";
if (!isset($_GET['idMedia']) | $_GET['idMedia']<1 | $_GET['idMedia']=="") {
	header("location: $redirUrl");
}
include "../config/mydb.php";
$idMedia=$_GET['idMedia'];

require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_locandine.php"; $mysql=new mysql;

$locandina=$mysql->singola_locandina($conn,$idMedia);


// carica struttura html
$title="Locandina ".$idMedia;
$metaDescription="Locandina ".$idMedia." pubblicata su Promogenova e relativi link";
$metaKeywords="locandina, manifesto, volantino, promogenova";
$metaRobots="ALL";

	$opengraph="s";
	$og_title=$title; 	
	$og_url="http://www.promogenova.it".$_SERVER['PHP_SELF']."?idMedia=".$idMedia;
	$urlLocandina="locandine/".$locandina['img'][0];
	$og_image="";
        if ($locandina['img'][0]!="") {
        $og_image=$urlLocandina;
        }

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1 class="nero">Locandina <?php print $idMedia; ?></h1>
<p class="testo">
<?php
    $urlImg=$url."locandine/".$locandina['img'][0];
	print "<a href='".$url."locandine/".$locandina['img'][0]."' rel='external'><img src='".$url."locandine/".$locandina['img'][0]."' alt='loc_".$idMedia."' class='scala' /></a>";
	print "<br/><br/>";
?>
</p>
</div>
<div class="colonna-1-4">
<?php

		// evento collegato
		if ($locandina['id'][0]>0) {
        $titolo=$myobj->mb_convert_encoding($locandina['titolo'][0]);
        print "<h4 class='rosso'>".$titolo."</h4>";    
        print "<span class='grigio'>Tipo di collegamento: Evento</span><br/><br/>";
        print "<a href='".$url."eventi/index.php?id=".$locandina['id'][0]."'>Vai alla pagina</a><br/><br/><br/><br/>";
		}

		// album collegato
		if ($locandina['idAlbum'][0]>0) {
        $titolo=$myobj->mb_convert_encoding($locandina['album'][0]);
        print "<h5 class='arancio'>".$titolo."</h5>";    
        print "<span class='grigio'>Tipo di collegamento: Album immagini</span><br/><br/>";
        print "<a href='".$locandina['url_album'][0]."'>Apri l'album</a><br/><br/><br/><br/>";
		}

		// video collegato
		if ($locandina['idVideo'][0]>0) {
        $titolo=$myobj->mb_convert_encoding($locandina['video'][0]);
        print "<h5 class='verde'>".$titolo."</h5>";    
        print "<span class='grigio'>Tipo di collegamento: Video</span><br/><br/>";
        print "<a href='".$locandina['url_video'][0]."'>Apri il video</a><br/><br/><br/><br/>";
		}

?>
</p>
</div>
<div class="colonna-1-4">
<p><img src="../img/luzzge.jpg" alt="icoloc" class="scala" /></p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
</div>


<?php
include "../config/footer.php";
?>
