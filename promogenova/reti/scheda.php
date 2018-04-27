<?php
$url="../";
include "../config/mydb.php";
require_once "../config/class_db.php"; $db=new db; 

if (isset($_GET['idRete'])) {
$idRete=$_GET['idRete'];
}
else {
header("location: index.php");
}

require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_reti.php"; $mysql=new mysql;
$reti=$mysql->singola_rete($conn,$idRete);
$attivita=$mysql->attivita_per_rete($conn,$idRete);
$eventi=$mysql->eventi_per_rete($conn,$idRete);

$nomeRete=$myobj->mb_convert_encoding($reti['rete'][0]); $nomeRete=ucfirst($nomeRete);
$zona=$myobj->mb_convert_encoding($reti['zona'][0]); $zona=ucfirst($zona);
$descriz=$myobj->mb_convert_encoding($reti['descriz'][0]);
$settore=$myobj->mb_convert_encoding($reti['settore'][0]); $settore=ucfirst($settore);

// carica struttura html
$title=$nomeRete;
$metaDescription="Scheda su ".$nomeRete." - ".substr($descriz,0,150);
$metaKeywords=strtolower($title).", ".strtolower($zona).", ".strtolower($settore).", promogenova";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<a name="intestazione"></a>
<div class="colonna-1-3">
<h1><?php print $nomeRete; ?></h1>
</div>
<div class="colonna-1-3">
<p>
<?php
$logo=$url."reti/loghi/".$reti['logo'][0];
$thumb=$url."reti/loghi/th_".$reti['logo'][0];
if ($reti['logo'][0]!="" && file_exists($logo)) {
print "<a href='".$logo."' title='Clicca per vedere nelle dimensioni originali'><img src='".$thumb."' alt='".$reti['idRete'][0]."' class='scala'></a>";
}
?>
</p>
</div>
<div class="colonna-1-3">
<p class="testo">
<?php
        print "Area tematica:<br /> <a href='".$url."reti/settori.php?idSett=".$reti['idSett'][0]."'><span class='rosso'>".strtoupper($settore)."</span></a><br/><br />";
        print "Zona:<br /> <span class='verde'>".$zona."</span><br/><br />";    
        print "Per maggiori informazioni:<br /> <a href='".$reti['url'][0]."'>".$reti['url'][0]."</a><br/><br />";
?>
</p>
</div>
</div>

<div class="riga">
<div class="colonna-2-3">
<h3 class="bianco sfTondo sfVerde">Chi sono e cosa fanno</h3>
<p class="testo">
<?php
        print nl2br($descriz)."<br /><br />";
?>
</p>
</div>
<div class="colonna-1-3">
<h3 class="bianco sfTondo sfRosso">Eventi recenti</h3>
<p>Gli ultimi eventi lanciati da <?php print $nomeRete; ?> e condivisi da Promogenova</p>
<?php
for ($i=1;$i<count($eventi['id']);$i++) {
    print "<p><a href='".$url."eventi/index.php?id=".$eventi['id'][$i]."'>";
    $locandina=$url."locandine/ico_".$eventi['img'][$i];
    if ($eventi['img'][$i]!="" && file_exists($locandina)) {
    print "<img src='".$locandina."' alt='locandina_".$eventi['id'][$i]."' class='thumb sx'>";
    }
    $txtConv=$myobj->mb_convert_encoding($eventi['titolo'][$i]);
    print $txtConv."</a><br />";
    $data1=$myobj->visData($eventi['dataInizio'][$i]);
    $data2=$myobj->visData($eventi['dataFine'][$i]);
    print "Periodo: dal <span class='nero'>".$data1."</span> al <span class='nero'>".$data2."</span><br /></p>";    
}
?>
<br />
<h3 class="bianco sfTondo sfBlu">Attivit&agrave; relazionate</h3>
<p>Le Attivit&agrave; presenti su Promogenova che sostengono e/o collaborano attivamente con <?php print $nomeRete; ?></p>
<?php
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
<br />
</div>
</div>
<?php
include "infopromo.php";
$tipoPag="rete";
include "../config/stat_reti.php";
include "../config/footer.php";
?>
