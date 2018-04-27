<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;

// struttura html
$title="Tutti gli articoli";
$metaDescription="Elenco completo degli articoli pubblicati dalle Attivit&agrave; presenti sul portale Promogenova.it";
$metaKeywords="articoli, servizi, prodotti, promogenova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Tutti gli articoli</h1>
<p class="testo">Elenco completo degli articoli pubblicati dalle Attivit&agrave; presenti sul portale <strong>Promogenova</strong>.</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-2">
<p><img src="<?php print $url; ?>img/commerce.jpg" alt="vetrina" class="scala" /></p>
</div>
</div>

<?php
print "<div class='riga'>";
print "<div class='colonna-1'>";

$oggi=date("Ymd");

    $sql="SELECT articoli.idArt,img,titolo,articoli_dat.idMacro,macro, dataOsc, attivita,cartella
    FROM articoli,articoli_dat,macro,articoli_txt, attivita,att_scad,vetrine
    WHERE articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro
    AND articoli_dat.idAttivita=attivita.idAttivita
    AND attivita.idAttivita=att_scad.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND articoli.osc='n'    
    AND att_scad.osc='n'    
    ORDER BY titolo ASC, articoli.idArt DESC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if ($oggi<=$q['dataOsc']) {
            print "<p><a href='".$url.$q['cartella']."/articoli.php?idArt=".$q['idArt']."'>";
            $immagine=$url.$q['cartella']."/articoli/".$q['img'];
            $thumb=$url.$q['cartella']."/articoli/ico_".$q['img'];
                if ($q['img']!="" && file_exists($immagine)) {
	               print "<img src='".$thumb."' alt='img_".$q['idArt']."' class='sx thumb' />";
                }
            $txtConv=$myobj->mb_convert_encoding($q['titolo']);
            print "<span class='testo rosso'>".ucfirst($txtConv)."</span>";
            print "</a><br />";
            $txtConv=$myobj->mb_convert_encoding($q['attivita']);
            print "Pubblicato da: <a href='".$url.$q['cartella']."'><span class='verde'>".ucfirst($txtConv)."</span></a> - ";
            $txtConv=$myobj->mb_convert_encoding($q['macro']);
            print "Categoria: <a href='".$url."ricerche/macro.php?idMacro=".$q['idMacro']."'>".ucfirst($txtConv)."</a>";
            print "<br /><br /></p>";
        }       
	}    

print "</div>";
print "</div>";

include "../config/footer.php";
?>
