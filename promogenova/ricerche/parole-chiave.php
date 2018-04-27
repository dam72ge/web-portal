<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;



// struttura html
$title="Parole chiave";
$metaDescription="Elenco completo delle parole associate alle Attivit&agrave; presenti sul portale Promogenova.it";
$metaKeywords="parole chiave, tag, ricerca, promogenova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Parole chiave</h1>
<p class="testo">Elenco completo parole associate alle Attivit&agrave; presenti sul portale <strong>Promogenova</strong>.</p>
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

    $sql="SELECT parola, dataOsc, attivita,cartella
    FROM vetrine_tag, attivita,att_scad,vetrine
    WHERE vetrine_tag.idAttivita=attivita.idAttivita
    AND attivita.idAttivita=att_scad.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND att_scad.osc='n'    
    ORDER BY parola ASC, attivita ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if ($oggi<=$q['dataOsc']) {
            $txtConv=$myobj->mb_convert_encoding($q['parola']);
            print "<a name='".strtolower($txtConv)."'></a>";
            print "<p><span class='testo nero'>#".strtoupper($txtConv)."</span> ";
            $txtConv=$myobj->mb_convert_encoding($q['attivita']);
            print ": tag associato a <a href='".$url.$q['cartella']."'><span class='verde'>".ucfirst($txtConv)."</span></a><br /></p>";
        }       
	}    

print "</div>";
print "</div>";

include "../config/footer.php";
?>
