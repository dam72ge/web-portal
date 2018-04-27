<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_attivita.php"; $mysql=new mysql;

$attivita=$mysql->elenco_attivita($conn,$url,"attivita ASC, idAttivita DESC");
$totAttivita=count($attivita['idAttivita'])-1;

// struttura html
$title="Vetrine web";
$metaDescription="Le vetrine web sono pagine realizzate per offrire maggiori informazioni ai visitatori e ai clienti sulle Attivit&agrave; presenti su Promogenova.it. In ognuna di esse si possono trovare, oltre alla breve descrizione dell'Attivit&agrave, interessanti gallerie fotografiche, schede sui marchi trattati, orari, contatti telefonici, ecc..";
$metaKeywords="vetrine web, vetrine internet, siti internet, vetrine promogenova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Vetrine web</h1>
<p class="testo">
Le <em>vetrine web</em> sono pagine - da non confondersi con i siti internet - realizzate per offrire <strong>maggiori informazioni</strong> ai visitatori e ai clienti sulle Attivit&agrave; che promuovono su questo portale. In ognuna di esse si possono trovare, oltre alla <strong>breve descrizione</strong> dell'Attivit&agrave;, interessanti gallerie fotografiche, schede sui marchi trattati, orari, contatti telefonici, ecc..<br/>
La presente pagina riporta l'elenco completo delle <em>vetrine web</em> presenti su <strong>Promogenova</strong>.</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-2">
<p><img src="<?php print $url; ?>img/commerce.jpg" alt="vetrina" class="scala" /></p>
</div>
</div>

<?php
if ($totAttivita>0) {
print "<div class='riga'>";
print "<div class='colonna-1'>";

    for ($i=1;$i<count($attivita['idAttivita']);$i++) {
		print "<table><tr><td>";
        print "<p><a href='".$url.$attivita['cartella'][$i]."'>";
        $logo=$url.$attivita['cartella'][$i]."/th_".$attivita['logo'][$i];
        $spazi="";
            if ($attivita['logo'][$i]!="" && file_exists($logo)) {
            print "<img src='".$logo."' alt='logo".$attivita['idAttivita'][$i]."' class='scala thumb sx' />";
            $spazi="<br /><br /><br />";
            }    
        $txtConv=$mysql->mb_convert_encoding($attivita['attivita'][$i]);
        print $txtConv."</a><br />";
        $txtConv=$mysql->mb_convert_encoding($attivita['ragsoc'][$i]);
        print "<i>".$txtConv."</i><br />";
        print "<span class='verde'>".$attivita['zona'][$i]."</span>";
        print $spazi;
        print "<br /></p>";
		print "</td></tr></table>";
    }

print "</div>";
print "</div>";
}

include "../config/footer.php";
?>
