<?php
$url="../";
$redirUrl="";
$idMacro=0; 

// riconosci macro        
if ($redirUrl=="") {
    if (!isset($_GET['idMacro']) | $_GET['idMacro']<1 | $_GET['idMacro']=="") {
    $redirUrl=$urlZona;
    }
}
$idMacro=$_GET['idMacro'];
$idMacro=ceil($idMacro);    
if ($idMacro<1) {
$redirUrl=$url.$urlZona;
}

// riconoscimento incompleto -> redirect 
if ($redirUrl!="") {
header("location: $redirUrl");
}

// CARICA DB
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_articoli.php"; $myart=new myart;

// dati macro
    $sql="SELECT idMacro,macro,descriz
    FROM macro
    WHERE idMacro='".$idMacro."' ";
    $query=mysqli_query($conn,$sql);			
    $q=mysqli_fetch_array($query,MYSQLI_ASSOC);


//$q=$myart->macro($conn,$idMacro);
$macro=ucfirst($q['macro']);
$macro=$myobj->mb_convert_encoding($macro);
$descriz=$myobj->mb_convert_encoding($q['descriz']);
$descriz=ucfirst($descriz);

// struttura html
$title=$macro;
$metaDescription="Categoria ".$macro.", ".$descriz;
$metaKeywords=strtolower($macro).", categorie commerciali, promogenova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1><?php print $macro; ?></h1>
<p class="testo"><?php print $descriz; ?></p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-2">
<p><img src="<?php print $url; ?>img/commerce.jpg" alt="vetrina" class="scala" /></p>
</div>
</div>


<?php
print "<div class='riga'>";
print "<div class='colonna-2-3'>";
print "<h3 class='bianco sfTondo sfVerde'>Articoli in <strong>".$macro."</strong></h3><br />";

// articoli in base a indirizzo attività e macro
$articoli=$myart->articoli_per_macro($conn,$idMacro);

if (count($articoli['idArt'])>1) {
	for ($i=1;$i<count($articoli['idArt']);$i++) {
		print "<table><tr><td>";
	   
            print "<p><a href='".$url.$articoli['cartella'][$i]."/articoli.php?idArt=".$articoli['idArt'][$i]."'>";
            $immagine=$url.$articoli['cartella'][$i]."/articoli/".$articoli['img'][$i];
            $thumb=$url.$articoli['cartella'][$i]."/articoli/th_".$articoli['img'][$i];
            $spazi="";
                if ($articoli['img'][$i]!="" && file_exists($immagine)) {
	               print "<img src='".$thumb."' alt='img_".$articoli['idArt'][$i]."' class='sx thumb scala' />";
                   $spazi="<br /><br />";
                }
            $txtConv=$myobj->mb_convert_encoding($articoli['titolo'][$i]);
            print "<span class='testo rosso'>".ucfirst($txtConv)."</span>";
            print "</a><br />";
            $txtConv=$myobj->mb_convert_encoding($articoli['attivita'][$i]);
            print "Pubblicato da: <a href='".$url.$articoli['cartella'][$i]."'><span class='verde'>".ucfirst($txtConv)."</span></a>";
            print $spazi;
            print "<br /><br /></p>";    

		print "</td></tr></table>";
    }
}else {
print "<br />Al momento nessun articolo &egrave; presente in questa categoria.<br /><br />";
}
print "<br /><br />";
print "</div>";

// altre categorie
print "<div class='colonna-1-3'>";
print "<h3 class='bianco sfTondo sfBlu'>Altre categorie</h3><br />";
    
    $sql_cat="
    SELECT idMacro, macro, descriz
    FROM macro 
    WHERE idMacro!='".$idMacro."'  
    ORDER BY macro ASC";
    $query_cat=mysqli_query($conn,$sql_cat);			
    while($cat=mysqli_fetch_array($query_cat,MYSQLI_ASSOC)){
    $txtConv=$myobj->mb_convert_encoding($cat['macro']); $txtConv=ucfirst($txtConv);
	print "<h5><a href='?idMacro=".$cat['idMacro']."'>".$txtConv."</a></h5>";
	$descriz=$myobj->mb_convert_encoding($cat['descriz']);
	print "<p>".ucfirst($descriz)."</p><br/>";	
    }

print "<br /><br /></div>";
print "</div>";

include "../config/footer.php";
?>
