<?php
$url="../";
include "../config/mydb.php";

require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_reti.php"; $mysql=new mysql;
$settori=$mysql->elenco_settori($conn,"");
$reti=$mysql->elenco_reti($conn,"");


// carica struttura html
$title="Reti e progetti";
$metaDescription="Reti e progetti sostenuti da Promogenova o da Attivit&agrave; clienti di Promogenova";
$metaKeywords="reti, associazioni, comitati, gruppi, laboratori, promogenova";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<a name="intro"></a>
<div class="colonna-1-3">
<h1><?php print $title; ?></h1>
<p class="testo">Reti sostenute da <strong>Promogenova.it</strong></p>
</div>
<div class="colonna-1-3">
<p><img src="../lay/lego.jpg" alt="" class="scala"></p>
</div>
<div class="colonna-1-3">
<h4 class="rosso">Obbiettivo: fare rete</h4>
<p><b>Promogenova.it</b> e le Attivit&agrave; presenti sul portale sostengono e talora collaborano attivamente con tutti coloro che operano per la riqualificazione dei territori mediante progetti aperti, mirati alla socializzazione, alla produzione e alla diffusione della cultura, del volontariato, della partecipazione attiva.</p>
</div>
</div>

<div class="riga">
<div class="colonna-1-3">
<p>
<img src="../img/logo-librerie.jpg" alt="logo-librerie.jpg" class="scala" /><br /><br />
Reti, centri e laboratori su <b>Promogenova.it</b>
</p>
</div>
<div class="colonna-2-3">
<a name="settori"></a>
<h2 class="bianco sfTondo sfBlu">Aree tematiche</h2><br />
<?php
for ($i=1;$i<count($settori['idSett']);$i++) {
    if ( $settori['totReti'][$i]>0 | $settori['totAttivita'][$i]>0 ) {
        $nome=$myobj->mb_convert_encoding($settori['settore'][$i]);
        print "<a href='".$url."reti/settori.php?idSett=".$settori['idSett'][$i]."'>".$nome."</a><br />";
/*
        print "Reti: ".$settori['totReti'][$i].", ";
        print "Attivit&agrave;: ".$settori['totAttivita'][$i]."<br />";
*/	
    }
}
?>
<br /><br /></p>
<a name="elenco"></a>
<h2 class="bianco sfTondo sfVerde">Reti in ordine alfabetico</h2>
<p>
<?php
for ($i=1;$i<count($reti['idRete']);$i++) {
        $nome=$myobj->mb_convert_encoding($reti['rete'][$i]);
        print "<a href='".$url."reti/scheda.php?idRete=".$reti['idRete'][$i]."'>".$nome."</a> ";
        $txtConv=$myobj->mb_convert_encoding($reti['settore'][$i]);
        print $txtConv.", ";
        $zona=$myobj->mb_convert_encoding($reti['zona'][$i]);
        print "<span class='nero'>".$zona."</span><br/>";    
}
?>
</p>
</div>
</div>

<?php
include "infopromo.php";
include "../config/footer.php";
?>
