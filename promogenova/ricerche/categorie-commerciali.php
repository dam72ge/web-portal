<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;

// struttura html
$title="Categorie commerciali";
$metaDescription="Elenco completo delle Categorie commerciali in uso sul portale Promogenova.it e loro descrizione";
$metaKeywords="categorie, categorie commerciali, promogenova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Categorie commerciali</h1>
<p class="testo">Elenco completo e descrizione delle categorie commerciali presenti su <strong>Promogenova</strong>.</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-2">
<p><img src="<?php print $url; ?>img/commerce.jpg" alt="vetrina" class="scala" /></p>
</div>
</div>

<?php
print "<div class='riga'>";
print "<div class='colonna-1'>";

    $sql_cat="
    SELECT idMacro, macro, descriz 
    FROM macro 
    ORDER BY macro ASC";
    $query_cat=mysqli_query($conn,$sql_cat);			
    while($cat=mysqli_fetch_array($query_cat,MYSQLI_ASSOC)){
        $txtConv=$myobj->mb_convert_encoding($cat['macro']);
        print "<p><a href='".$url."ricerche/macro.php?idMacro=".$cat['idMacro']."' rel='index'><h2><span class='rosso'>".ucfirst($txtConv)."</span></h2></a>";
        $txtConv=$myobj->mb_convert_encoding($cat['descriz']);
        print ucfirst($txtConv);
        print "<br /><br /><a href='".$url."ricerche/macro.php?idMacro=".$cat['idMacro']."' rel='index'>Vai alla pagina</a>";
        print "<br /><br /></p>";
    }

print "</div>";
print "</div>";

include "../config/footer.php";
?>
