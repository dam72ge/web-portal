<?php
$url="../../"; $urlAdm="../";   
$urlStat="../..";
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// struttura html
$title="Admin ".$attivita." - Statistiche";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
$oggi=date("Ymd");
$visite_old=0; 
$visite_vetrina=0;
$visite_eventi=0;
$visite_foto=0;
$visite_articoli=0;
$visite_tot=0;
$visite_conta=0;

    // leggi statistiche vetrina+articoli+foto
	$sql="SELECT idStat,title,url,tipo,visite,idArt FROM stat_vetrine WHERE idAttivita='".$idAttivita."' ORDER BY tipo ASC";
    $query=mysqli_query($conn,$sql);			
    while($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        
    if ($riga['title']=="" && $riga['url']=="" && $riga['tipo']=="vetrina + promozioni vecchio portale"){
    $visite_old=$visite_old+$riga['visite']; $visite_conta=$visite_conta+$visite_old;
    }
        
    if ($riga['title']!="" && $riga['url']!="" && $riga['visite']>0){

    	$visite_tot=$visite_tot+$riga['visite'];
        switch ($riga['tipo']){ 
        	case "vetrina": 
            $visite_vetrina=$visite_vetrina+$riga['visite']; $visite_conta=$visite_conta+$visite_vetrina;
            break;
        	case "foto": 
            $visite_foto=$visite_foto+$riga['visite']; $visite_conta=$visite_conta+$visite_foto;
            break;
        	case "articolo": 
            $visite_articoli=$visite_articoli+$riga['visite']; $visite_conta=$visite_conta+$visite_articoli;
            break;
        }        
        // pulisci url pagina http://127.0.0.1/promogenova.it//promogenova.it/eventi/index.php?id=126
		$pagUrlOk = $urlStat.$riga['url'];
		$pagUrlOk = str_replace("//", "/", $pagUrlOk);
		$pagUrlOk = str_replace("../", "", $pagUrlOk);
		$pagUrlOk = str_replace("/promogenova/", "/", $pagUrlOk);
		$pagUrlOk = str_replace("//", "/", $pagUrlOk);
            $dati['idStat'][]=$riga['idStat'];
            $dati['url'][]=$pagUrlOk;
            $dati['tipo'][]=$riga['tipo'];
            $dati['visite'][]=$riga['visite'];
            $titDat=$riga['title']; if ($riga['title']==""){ $titDat="[elemento rimosso]"; }
            $dati['title'][]=$titDat;
            $dati['idArt'][]=$riga['idArt'];
    }
	}

// ordina i risultati per numero visite
@array_multisort(
$dati['visite'],SORT_DESC,SORT_NUMERIC,
$dati['title'],SORT_ASC,SORT_REGULAR,
$dati['url'],SORT_ASC,SORT_REGULAR,
$dati['tipo'],SORT_ASC,SORT_REGULAR,
$dati['idArt'],SORT_DESC,SORT_NUMERIC,
$dati['idStat'],SORT_DESC,SORT_NUMERIC
);


    // leggi statistiche eventi
	$sql="SELECT idStat,id,title,url,visite FROM stat_eventi WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    while($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    if ($riga['title']!="" && $riga['url']!="" && $riga['visite']>0){

    	$visite_tot=$visite_tot+$riga['visite'];
        $visite_eventi=$visite_eventi+$riga['visite'];
        
        // pulisci url pagina
		$pagUrlOk = $urlStat.$riga['url'];
		$pagUrlOk = str_replace("//", "/", $pagUrlOk);
		$pagUrlOk = str_replace("../", "", $pagUrlOk);
		$pagUrlOk = str_replace("/promogenova/", "/", $pagUrlOk);
		$pagUrlOk = str_replace("//", "/", $pagUrlOk);
            $eventi['idStat'][]=$riga['idStat'];
            $eventi['id'][]=$riga['id']; // id evento!
            $eventi['url'][]=$pagUrlOk;
            $eventi['visite'][]=$riga['visite'];
            $titDat=$riga['title']; if ($riga['title']==""){ $titDat="[elemento rimosso]"; }
            $eventi['title'][]=$titDat;
	}
	}

// ordina i risultati per numero visite
@array_multisort(
$eventi['visite'],SORT_DESC,SORT_NUMERIC,
$eventi['title'],SORT_ASC,SORT_REGULAR,
$eventi['url'],SORT_ASC,SORT_REGULAR,
$eventi['id'],SORT_DESC,SORT_NUMERIC,
$eventi['idStat'],SORT_DESC,SORT_NUMERIC
);


$visite_tot=$visite_old+$visite_vetrina+$visite_articoli+$visite_eventi+$visite_foto;
?>

<section>
<article>
<h1>Statistiche</h1>
<p class="grigio">L'andamento della tua <em>vetrina</em> &nbsp; e di tutto ci&ograve; che hai pubblicato dal <?php print $myobj->visData($dataReg); ?> a oggi (<span class="rosso">*</span>)<br /><br /></p>
<h4 class="nero">Hai ricevuto <?php print $visite_tot; ?> visite</h3>
</article>
</section>

<div class="riga">
<div class="colonna-1-3">
<?php
print "<h5 class='bianco sfTondo sfRosso'>Vetrina web</h5><p class='testo'>";
if ($visite_vetrina>0) {
    for ($i=0;$i<count($dati['url']);$i++) {
        if ($dati['tipo'][$i]=="vetrina") {
            print "<a href='".$url.$dati['url'][$i]."'>".$dati['title'][$i]."</a>: visite ".$dati['visite'][$i]."<br />";
        }
    }    
}
print "<br />Totale: <span class='verde'>".$visite_vetrina." visite</span>";
print "<br /><br /></p>";	
if ($visite_eventi>0) {
print "<h5 class='bianco sfTondo sfRosso'>Eventi</h5>";
print "<p class='testo'>";
    for ($i=0;$i<count($eventi['url']);$i++) {
    print "<a href='".$url.$eventi['url'][$i]."'>".$eventi['title'][$i]." (id: ".$eventi['id'][$i].")</a> visite ".$eventi['visite'][$i]."<br />";
    }
print "<br />Totale: <span class='verde'>".$visite_eventi." visite</span>";
print "<br /><br /></p>";	
}
?>
</div>
<div class="colonna-1-3">
<?php
if ($visite_articoli>0) {
print "<h5 class='bianco sfTondo sfRosso'>Articoli</h5>";
print "<p class='testo'>";
    for ($i=0;$i<count($dati['url']);$i++) {
        if ($dati['tipo'][$i]=="articolo") {
            print "<a href='".$url.$dati['url'][$i]."'>Art. ".$dati['idArt'][$i]." -".$dati['title'][$i]."</a> visite ".$dati['visite'][$i]."<br />";
        }
    }
print "<br />Totale: <span class='verde'>".$visite_articoli." visite</span>";
print "<br /><br /></p>";	
}
?>
</div>
<div class="colonna-1-3">
<?php
if ($visite_foto>0) {
print "<h5 class='bianco sfTondo sfRosso'>Foto</h5>";
	print "<p class='testo'>";
    for ($i=0;$i<count($dati['url']);$i++) {
        if ($dati['tipo'][$i]=="foto") {
            print "<a href='".$url.$dati['url'][$i]."'>".$dati['title'][$i]."</a> visite ".$dati['visite'][$i]."<br />";
        }
    }
print "<br />Totale: <span class='verde'>".$visite_foto." visite</span>";
print "<br /><br /></p>";	
}

if ($dataReg<=20130901 && $visite_old>0) {
print "<h5 class='bianco sfTondo sfGrigio'>Vecchia vetrina</h5>";
	print "<p class='testo'>";
    print "Visite alla vecchia vetrina e alle promozioni da te pubblicate prima del 1 Settembre 2013: <span class='verde'>".$visite_old."</span>";
    print "<br /><br /></p>";
}
?>
</div>
</div>

<section>
<article><p class="testo">
<span class="rosso">*</span>
I dati qui raccolti hanno valore <strong>puramente indicativo</strong> e non costituiscono alcun riscontro delle pubblicazioni nel loro complesso. I valori sono presi in base agli <strong>accessi unici</strong>, ossia ogni volta che si clicca su un elemento preso in esame (pagina, foto, articolo ecc.) il database aggiunge 1 visita.
</p>
</article>
</section>

<?php
include "../footer.php";
?>
