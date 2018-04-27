<?php
$url="../";
include "../config/mydb.php";
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_video.php"; $mysql=new mysql;
$video=$mysql->elenco_video($conn);
$totVideo=count($video['idVideo'])-1;


// carica struttura html
$title="Video";
$metaDescription="Video pubblicati da Promogenova e da Attivit&agrave; clienti di Promogenova";
$metaKeywords="video, filmati, riprese, immagini, promogenova";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Video</h1>
<p class="testo">I video caricati da <strong>Promogenova</strong>.</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-4">
<p><img src="../img/upload-img.png" alt="album" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="verde">Condividiamoci!</h4>
<p>Sosteniamo e diffondiamo la socialit&agrave;, la cultura, la rivitalizzazione dei territori tramite gli <a href="<?php print $url; ?>eventi/" rel="index">Eventi</a>, condivendo sui <em>social network</em> i video. 
<br /><br /><br />
</p>
</div>
</div>

<?php
// Ultimi 10 video (i<11, tot>10)
for ($i=1;$i<count($video['idVideo']);$i++) {
if ($i<11) {
print "<div class='riga'>";
print "<div class='colonna-1-2'><br />";    
$nome=$myobj->mb_convert_encoding($video['video'][$i]);
$myobj->video($video['url'][$i]);
print "</div>";
print "<div class='colonna-1-2'><p class='testo'>";    
        $titolo=$myobj->mb_convert_encoding($video['video'][$i]);
        print "<h4 class='rosso'>".$titolo."</h4>";
        $zona=$myobj->mb_convert_encoding($video['zona'][$i]);
        print "Luogo: <span class='nero'>".$zona."</span><br/>";    
        print "Anno: <span class='verde'>".$video['anno'][$i]."</span> - ";    
        $giorno=$myobj->mb_convert_encoding($video['giorno'][$i]);
        print "Data: <span class='verde'>".$giorno."</span><br/>";    
        print "Link diretto: <a href='".$video['url'][$i]."' rel='external'>".$video['url'][$i]."</a><br/><br />";


    if ($video['id'][$i]>0) {
    print "<a href='".$url."eventi/index.php?id=".$video['id'][$i]."' rel='external'>Vedi evento collegato</a><br />";
    }
    if ($video['album'][$i]!="") {
    print "<a href='".$video['album'][$i]."' rel='external'>Vedi album immagini collegato</a><br />";
    }


print "</p></div>";
print "</div>";
}
}
// Altri video dopo il decimo (elenco, i=11)
if ($totVideo>10) {
print "<div class='riga'>";
print "<div class='colonna-1'>";
print "<h4 class='bianco sfTondo sfBlu'>Altri video</h4><br />";
for ($i=4;$i<count($video['idVideo']);$i++) {
    print "<p><a href='".$video['url'][$i]."' rel='external'><span class='rosso'>";
    print "<img src='".$url."img/video.png' alt='video_".$video['idVideo'][$i]."' class='thumb sx' />";
        $titolo=$myobj->mb_convert_encoding($video['video'][$i]);
        print $titolo."</span></a><br />";
        $zona=$myobj->mb_convert_encoding($video['zona'][$i]);
        print "Luogo: <span class='nero'>".$zona."</span><br/>";    
        print "Anno: <span class='verde'>".$video['anno'][$i]."</span> - ";    
        $giorno=$myobj->mb_convert_encoding($video['giorno'][$i]);
        print "Data: <span class='verde'>".$giorno."</span><br/>";    
    print "</p>";    
}
print "<br /><br /></div>";
print "</div>";
}

include "../config/footer.php";
?>
