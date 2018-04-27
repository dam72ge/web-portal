<?php
$url="../";
include "../config/mydb.php";
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_album.php"; $mysql=new mysql;
$album=$mysql->elenco_album($conn);
$totAlbum=count($album['idAlbum'])-1;

// carica struttura html
$title="Album";
$metaDescription="Album pubblicati da Promogenova e da Attivit&agrave; clienti di Promogenova";
$metaKeywords="album, foto, immagini, promogenova";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Album</h1>
<p class="testo">Gli album caricati da <strong>Promogenova</strong> sui vari <i>social network</i>.</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-4">
<p><img src="../img/upload-img.png" alt="album" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="verde">Condividiamoci!</h4>
<p>Sosteniamo e diffondiamo la socialit&agrave;, la cultura, la rivitalizzazione dei territori tramite gli <a href="<?php print $url; ?>eventi/" rel="index">Eventi</a>, condivendo sui <em>social network</em> le immagini. 
<br /><br /><br />
</p>
</div>
</div>

<?php
// Ultimi 10 album (i<11, tot>10)
for ($i=1;$i<count($album['idAlbum']);$i++) {
if ($i<11) {
    print "<div class='riga'>";
    print "<div class='colonna-1-3'><p style='text-align:center'>";    
    $urlImg=$url.$album['img'][$i];
    if ($album['th'][$i]!="" && file_exists($urlImg)) {
    print "<a href='".$album['url'][$i]."' rel='external'><img src='".$url.$album['th'][$i]."' alt='copertina_".$album['idAlbum'][$i]."' class='scala' /></a><br />";
    print "[<a href='".$urlImg."'>Vedi solo la copertina</a>]<br />";
    }
    print "</p></div>";
    print "<div class='colonna-2-3'><p class='testo'>";    
        $titolo=$myobj->mb_convert_encoding($album['album'][$i]);
        print "<h4 class='rosso'>".$titolo."</h4>";
        $zona=$myobj->mb_convert_encoding($album['zona'][$i]);
        print "Luogo: <span class='nero'>".$zona."</span><br/>";    
        print "Anno: <span class='verde'>".$album['anno'][$i]."</span> - ";    
        $giorno=$myobj->mb_convert_encoding($album['giorno'][$i]);
        print "Data: <span class='verde'>".$giorno."</span><br/><br />";    
        print "Per vedere l'Album clicca su: <a href='".$album['url'][$i]."' rel='external'>".$album['url'][$i]."</a><br/><br />";

    if ($album['id'][$i]>0) {
    print "<a href='".$url."eventi/index.php?id=".$album['id'][$i]."' rel='external'>Vedi evento collegato</a><br />";
    }
    if ($album['video'][$i]!="") {
    print "<a href='".$album['video'][$i]."' rel='external'>Vedi video collegato</a><br />";
    }

    print "</p></div>";
    print "</div>";
}    
}
// Altri album dopo il decimo (elenco, i=11)
if ($totAlbum>10) {
print "<div class='riga'>";
print "<div class='colonna-1'>";
print "<h4 class='bianco sfTondo sfVerde'>Altri album</h4><br />";
    $urlImg=$url.$album['ico'][$i];
for ($i=6;$i<count($album['idAlbum']);$i++) {
    print "<p><a href='".$album['url'][$i]."' rel='external'>";
    if ($album['ico'][$i]!="" && file_exists($urlImg)) {
    print "<img src='".$url.$album['ico'][$i]."' alt='copertina_".$album['idAlbum'][$i]."' class='thumb sx' />";
    }
    $titolo=$myobj->mb_convert_encoding($album['album'][$i]);
    print $titolo."</a><br />";
    $zona=$myobj->mb_convert_encoding($album['zona'][$i]);
    print "Luogo: <span class='nero'>".$zona."</span><br/>";    
    print "Anno: <span class='verde'>".$album['anno'][$i]."</span> - ";    
    $giorno=$myobj->mb_convert_encoding($album['giorno'][$i]);
    print "Data: <span class='verde'>".$giorno."</span><br/><br />";
    print "</p>";    
}
print "<br /><br /></div>";
print "</div>";
}
?>


<?php
include "../config/footer.php";
?>
