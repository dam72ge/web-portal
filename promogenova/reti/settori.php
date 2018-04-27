<?php
$url="../";
include "../config/mydb.php";

if (isset($_GET['idSett'])) {
$idSett=$_GET['idSett'];
}
else {
header("location: index.php");
}

require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_reti.php"; $mysql=new mysql;
$where=" WHERE idSett='".$idSett."' ";
$settori=$mysql->elenco_settori($conn,$where);
$where=" AND idSett='".$idSett."' ";
$reti=$mysql->elenco_reti($conn,$where);
$attivita=$mysql->attivita_per_settore($conn,$idSett);

// carica struttura html
$title=$settori['settore'][1]." (Area tematica)";
$metaDescription=$title." - Sistema di relazioni e ricerca di Reti e Attivit&agrave; su Promogenova";
$metaKeywords=strtolower($settori['settore'][1]).", area tematica, promogenova";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<a name="intro"></a>
<div class="colonna-1-2">
<h1><?php print $settori['settore'][1]; ?></h1>
<p>
Reti associate: <?php print (count($reti['idRete'])-1); ?><br />
Attivit&agrave; relazionate: <?php print (count($attivita['idAttivita'])-1); ?><br />
</p>
</div>
<div class="colonna-1-4">
<p><img src="../lay/caratt.jpg" alt="caratt" class="scala"></p>
</div>
<div class="colonna-1-4">
<h4 class="rosso">Area tematica</h4>
<p><b>Promogenova.it</b> e le Attivit&agrave; presenti sul portale sostengono e talora collaborano attivamente con tutti coloro che operano per la riqualificazione dei territori mediante progetti aperti, mirati alla socializzazione, alla produzione e alla diffusione della cultura, del volontariato, della partecipazione attiva.</p>
</div>
</div>


<div class="riga">
<div class="colonna-1-2">
<h3 class="bianco sfTondo sfVerde">Reti che operano sul tema</h3>
<?php 
print "<p>Reti che si occupano di ".$settori['settore'][1]."</p>"; 
for ($i=1;$i<count($reti['idRete']);$i++) {
    $logoRete=$url."reti/loghi/ico_".$reti['logo'][$i];      
    print "<p><a href='".$url."reti/scheda.php?idRete=".$reti['idRete'][$i]."' class='testo'>";
    if ($reti['logo'][$i]!="" && file_exists($logoRete) ) {
    print "<img src='".$logoRete."' alt='logo_".$reti['idRete'][$i]."' class='thumb sx'>";
    }
    $txtConv=$myobj->mb_convert_encoding($reti['rete'][$i]);
    print $txtConv."</a><br />";
    $zona=$myobj->mb_convert_encoding($reti['zona'][$i]);
    print "Zona: <span class='nero'>".$zona."</span><br/><br /></p>";    
}
?>

</div>
<div class="colonna-1-2">
<h3 class="bianco sfTondo sfBlu">Attivit&agrave; collegate</h3>
<?php 
print "<p>Attivit&agrave; relazionate a Reti che si occupano di ".$settori['settore'][1]."</p>"; 
for ($i=1;$i<count($attivita['idAttivita']);$i++) {
    $logoAtt=$url.$attivita['cartella'][$i]."/ico_".$attivita['logo'][$i];      
    print "<p><a href='".$url.$attivita['cartella'][$i]."' class='testo'>";
    if ($attivita['logo'][$i]!="" && file_exists($logoAtt) ) {
    print "<img src='".$logoAtt."' alt='logo_".$attivita['idAttivita'][$i]."' class='thumb sx'>";
    }
    $txtConv=$myobj->mb_convert_encoding($attivita['attivita'][$i]);
    print $txtConv."</a><br />";
    $txtConv=$myobj->mb_convert_encoding($attivita['zona'][$i]);
    print "Zona: <span class='nero'>".$txtConv."</span><br /></p>";    

}
?>
</div>
</div>

<?php
include "infopromo.php";
include "../config/footer.php";
?>
