<?php
// idArt
if (!isset($_GET['idArt'])) {
header ("location: index.php");
}
$idArt=$_GET['idArt'];

$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// riconosci cliente
$cfrAtt=$mysql->cliente_articolo($conn,$idArt);
if ($idAttivita!=$cfrAtt) {
header ("location: index.php");
}

// leggi db
    $sql="SELECT articoli.idArt,dataReg,osc,img,titolo,articoli_dat.idMacro,macro,testo
    FROM articoli,articoli_dat,macro,articoli_txt
    WHERE articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro  
    AND articoli.idArt='".$idArt."'";
    $query=mysqli_query($conn,$sql);			
    $singolo=mysqli_fetch_array($query,MYSQLI_ASSOC);

// apri sessione
$art_titolo=$singolo['titolo']; $_SESSION['art_titolo']=$singolo['titolo'];
$art_testo=$singolo['testo']; $_SESSION['art_testo']=$singolo['testo'];
$art_img=$singolo['img']; $_SESSION['art_img']=$singolo['img'];  
$art_idMacro=$singolo['idMacro']; $_SESSION['art_idMacro']=$singolo['idMacro']; 
$art_macro=$singolo['macro']; $_SESSION['art_macro']=$singolo['macro']; 
$art_dataReg=$singolo['dataReg']; $_SESSION['art_dataReg']=$singolo['dataReg'];
$art_id=$idArt; $_SESSION['art_id']=$idArt;
$art_osc=$singolo['osc']; $_SESSION['art_osc']=$singolo['osc'];
$art_idR=$idR; $_SESSION['art_idR']=$art_idR; 
$art_idP=$idP; $_SESSION['art_idP']=$art_idP; 
$art_idC=$idC; $_SESSION['art_idC']=$art_idC; 
$art_idM=$idM; $_SESSION['art_idM']=$art_idM; 
$art_idQ=$idQ; $_SESSION['art_idQ']=$art_idQ; 

// promozione?
$art_promozione="n";
$_SESSION['art_promozione']="n"; 
if ($creaPromo=="s") {
    $sql1="SELECT idR,idP,idC,idM,idQ 
    FROM articoli_promo
    WHERE idAttivita='".$idAttivita."' 
    AND idArt='".$idArt."'";
    $query1=mysqli_query($conn,$sql1);			
    $promo=mysqli_fetch_array($query1,MYSQLI_ASSOC);
    if (isset($promo['idC']) && $promo['idC']!="") {    
        $art_idR=$promo['idR']; $_SESSION['art_idR']=$art_idR; 
        $art_idP=$promo['idP']; $_SESSION['art_idP']=$art_idP; 
        $art_idC=$promo['idC']; $_SESSION['art_idC']=$art_idC;      
        $art_idM=$promo['idM']; $_SESSION['art_idM']=$art_idM; 
        $art_idQ=$promo['idQ']; $_SESSION['art_idQ']=$art_idQ; 
    }
    if ($idR!=$art_idR | $idP!=$art_idP | $idC!=$art_idC | $idM!=$art_idM | $idQ!=$art_idQ) {
    $art_promozione="s";
    $_SESSION['art_promozione']="s"; 
    }
}


// struttura html
$title="Admin ".$attivita." - Articolo ".$idArt." - ".$art_titolo;
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h3 class="rosso">Modifica articolo n.ro <?php print $idArt; ?></h3><br />
<p class="testo">
<?php
if ($art_osc=="s") {
print "<p class='testo'>Questo articolo al momento risulta <strong>DISATTIVATO</strong>, ossia &agrave; visibile soltanto a te e non ai visitatori. Decidi cosa farne:<br/><br/></p>";  

print "<p><a href='attiva.php?idArt=".$idArt."'><input type='button' name='attiva' value='Attivalo' class='bottSubmit' /></a></p>";
print "<p><a href='elimina.php?idArt=".$idArt."'><input type='button' name='elimina' value='Eliminalo' class='bottSubmit' /></a></p>";
//print "<h4><a href='attiva.php?idArt=".$idArt."'>Attivalo</a></h4>";
//print "<h4><a href='elimina.php?idArt=".$idArt."'>Eliminalo</a></h4>";
//print "<h4><a href='index.php'>Torna al Men&ugrave; articoli</a></h4>";
print "<p><a href='index.php'><input type='button' name='menu' value='Menu Articoli' class='bottSubmit' /></a></p>";
print "<p><a href='../index.php'><input type='button' name='inizio' value='Inizio' class='bottSubmit' /></a></p>";
print "<br /><br/>";
print "<p class='testo'>Puoi effettuare, se vuoi, delle <b>MODIFICHE</b>:<br /></p>";
print "<p><a href='cambia-titolo.php?idArt=".$idArt."'><input type='button' name='titolo' value='Titolo' class='bottSubmit' /></a></p>";
print "<p><a href='cambia-testo.php?idArt=".$idArt."'><input type='button' name='testo' value='Testo' class='bottSubmit' /></a></p>";
print "<p><a href='cambia-immagine.php?idArt=".$idArt."'><input type='button' name='img' value='Immagine' class='bottSubmit' /></a></p>";
print "<p><a href='cambia-categoria.php?idArt=".$idArt."'><input type='button' name='categ' value='Categoria' class='bottSubmit' /></a></p>";
/*
print "<a href='cambia-titolo.php?idArt=".$idArt."'><span class='verde'>Titolo</span></a><br />";
print "<a href='cambia-testo.php?idArt=".$idArt."'><span class='verde'>Testo</span></a><br />";
print "<a href='cambia-immagine.php?idArt=".$idArt."'><span class='verde'>Immagine</span></a><br />";
print "<a href='cambia-categoria.php?idArt=".$idArt."'><span class='verde'>Categoria comm.le</span></a><br />";
print "</p>";
*/
}
else{
print "<p class='testo'>Questo articolo al momento risulta <span class='verde'>VISIBILE A TUTTI</span>.<br/>Per poterlo modificare, occorre disattivarlo, trasformandolo cos&igrave; in bozza. Una volta riattivato, l'articolo sar&agrave; di nuovo visibile a tutti.<br/><br/></p>";  
//print "<h4><a href='disattiva.php?idArt=".$idArt."'>Disattiva l'articolo</a></h4>";
//print "<h4><a href='index.php'>Torna al Men&ugrave; articoli</a></h4>";
print "<p><a href='disattiva.php?idArt=".$idArt."'><input type='button' name='disattiva' value='Disattiva' class='bottSubmit' /></a></p>";
print "<p><a href='index.php'><input type='button' name='menuart' value='Menu Articoli' class='bottSubmit' /></a></p>";
print "<p><a href='../index.php'><input type='button' name='inizio' value='Inizio' class='bottSubmit' /></a></p>";

}
?>


<br /><br />
</div>
<div class="colonna-1-2">
<p>&nbsp;&nbsp;Anteprima dell'Articolo</p>
<div class="riquadro">
<?php 
if ($art_img!="") {
print "<img src='".$url.$cartella."/articoli/th_".$art_img."' alt='antep' title='immagine allegata' class='dx thumb scala'>";	
}
print "<h4><span class='viola'>".$art_titolo."</span></h4>";

print "<span class='grigio'>".$myobj->visData($art_dataReg)."</span><br /><br />";
 
print "<span class='arancio'>".ucfirst($art_macro)."</span><br />";
if ($art_promozione=="s") {
print "<span class='verde'>In promozione fuori zona</span><br />";
}
print "<br /><br />";
//$txtConv=$myobj->mb_convert_encoding($art_testo);
print "</span><span class='testo'>".nl2br($art_testo)."</span>";
?>
<br /><br />
<br /><br />
</div>
</div>
</div>
<?php
include "../footer.php";
?>

