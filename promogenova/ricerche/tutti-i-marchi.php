<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;



// struttura html
$title="Tutti i marchi";
$metaDescription="Elenco completo dei marchi trattati dalle Attivit&agrave; presenti sul portale Promogenova.it";
$metaKeywords="marchi, ditte produttrici, produttori, fornitori, forniture, aziende, catene, promogenova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Tutti i Marchi</h1>
<p class="testo">Elenco completo dei Marchi trattati dalle Attivit&agrave; presenti sul portale <strong>Promogenova</strong>.</p>
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

    $sql="SELECT marchio, dataOsc, attivita,cartella
    FROM vetrine_marchi, attivita,att_scad,vetrine
    WHERE vetrine_marchi.idAttivita=attivita.idAttivita
    AND attivita.idAttivita=att_scad.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND att_scad.osc='n'    
    ORDER BY marchio ASC, attivita DESC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if ($oggi<=$q['dataOsc']) {
            $txtConv=$myobj->mb_convert_encoding($q['marchio']);
            print "<a name='".strtolower($txtConv)."'></a>";
            print "<p><span class='testo nero'>".ucfirst($txtConv)."</span> ";
            $txtConv=$myobj->mb_convert_encoding($q['attivita']);
            print ": trattato da <a href='".$url.$q['cartella']."'><span class='verde'>".ucfirst($txtConv)."</span></a><br /></p>";
        }       
	}    

print "</div>";
print "</div>";

include "../config/footer.php";
?>
