<?php
// RSS EVENTI
$url="../";
include "../config/conn-xml.php";

// carica eventi
require_once "../config/class_eventi.php"; $mysql=new mysql;
$eventi=$mysql->elenco_eventi($conn);

// riordina eventi per data inizio decrescente
array_multisort(
$eventi['dataInizio'],SORT_DESC,SORT_NUMERIC,
$eventi['dataFine'],SORT_DESC,SORT_NUMERIC,
$eventi['anno'],SORT_DESC,SORT_NUMERIC,
$eventi['id'],SORT_DESC,SORT_NUMERIC,
$eventi['home'],SORT_ASC,SORT_REGULAR,
$eventi['titolo'],SORT_ASC,SORT_REGULAR,
$eventi['testo'],SORT_ASC,SORT_REGULAR,
$eventi['img'],SORT_ASC,SORT_REGULAR,
$eventi['oreInizio'],SORT_ASC,SORT_REGULAR,
$eventi['oreFine'],SORT_ASC,SORT_REGULAR,
$eventi['dataAvv'],SORT_ASC,SORT_NUMERIC,
$eventi['dataOsc'],SORT_ASC,SORT_NUMERIC,
$eventi['idR'],SORT_ASC,SORT_NUMERIC,
$eventi['idP'],SORT_ASC,SORT_NUMERIC,
$eventi['idC'],SORT_ASC,SORT_NUMERIC,
$eventi['idM'],SORT_ASC,SORT_NUMERIC,
$eventi['idQ'],SORT_ASC,SORT_NUMERIC,
$eventi['zona'],SORT_ASC,SORT_REGULAR,
$eventi['url'],SORT_ASC,SORT_REGULAR,
$eventi['idAttivita'],SORT_ASC,SORT_NUMERIC,
$eventi['idRete'],SORT_ASC,SORT_NUMERIC
);

$titoloFeed="Eventi";
$linkFeed="/eventi";
include "intestazione.php";

for ($i=0;$i<count($eventi['id']);$i++) {
if ($eventi['titolo'][$i]!="" && $eventi['dataInizio'][$i]>0 && $eventi['dataOsc'][$i]>0 && $oggi<=$eventi['dataOsc'][$i]) {
print "<item>";

           // Titolo + giorno mese
           $x=$eventi['dataInizio'][$i];
           $ggmm=substr($x,6,2)."/".substr($x,4,2)." - ";
           
           if($eventi['dataInizio'][$i]==$oggi){ $ggmm="OGGI ".$ggmm; }
           
		   $tit=ripulisci($eventi['titolo'][$i]);
           print "<title>".$ggmm.ucfirst($tit)."</title>";

    	   // Link alla pagina
           print "<link>".$baseLink."/eventi/?id=".$eventi['id'][$i]."</link>";

            // data oggi
            $oggi=date("Ymd");

    	   // Descrizione
            $descr="<p>";
            $categEvento="";
            if ($oggi<$eventi['dataInizio'][$i] && $oggi<$eventi['dataAvv'][$i]) {
            $descr."Evento futuro - "; $categEvento="Eventi futuri";}
            if ($oggi>=$eventi['dataInizio'][$i] && $oggi<=$eventi['dataFine'][$i]) {
            $descr.="Evento in corso - "; $categEvento="Eventi in corso";}
            if ($oggi>=$eventi['dataAvv'][$i] && $oggi<$eventi['dataInizio'][$i]) {
            $descr."Evento imminente - "; $categEvento="Eventi imminenti";}
            if ($oggi>$eventi['dataFine'][$i] && $oggi<$eventi['dataOsc'][$i]) {
            $descr."Evento recente - "; $categEvento="Eventi recenti";}
            if ($oggi>=$eventi['dataOsc'][$i]) {
            $descr."Evento trascorso - "; $categEvento="Eventi trascorsi";}

            if ($eventi['zona'][$i]!="") {
            $zona=ripulisci($eventi['zona'][$i]);
            $descr.="Localita': ".strtoupper($zona)." - ";    
            }
 
            if ($eventi['dataInizio'][$i]!="") {
            $descr.="Quando: dalle ore ".$eventi['oreInizio'][$i];
                if ($eventi['dataInizio'][$i]==$eventi['dataFine'][$i]) {
                $descr.=" alle ore ".$eventi['oreFine'][$i]." del giorno ".$myobj->visData($eventi['dataFine'][$i])."</span>"; 
                }
                else {
                $descr.=" del ".$myobj->visData($eventi['dataInizio'][$i])." alle ore ".$eventi['oreFine'][$i]." del ".$myobj->visData($eventi['dataFine'][$i])."</span>";
                }	
            }

		   // + immagine
		   $fileArt=$baseLink."/eventi/locandine/".$eventi['img'][$i]; $allegato="";
		   $thumb=$baseLink."/eventi/locandine/th_".$eventi['img'][$i];

                if ($eventi['img'][$i]!="") { // && file_exists($fileArt)
	               $descr.="<br /><br /><img src='".$thumb."' alt='Evento_".$eventi['id'][$i]."' />";
                   $peso = @filesize($fileArt);
                            //if ($peso==FALSE) { throw new FileSizeException($fileArt);}
                   $allegato="<enclosure url='".$fileArt."' lenght='".$peso."' type='image/jpeg' />";
				}

		   if ($eventi['testo'][$i]!=""){
		   $txtConv=ripulisci($eventi['testo'][$i]);
		   $descr.="<br /><br /><i>".$txtConv."</i>";
		   }

		   if ($eventi['url'][$i]!=""){
		   $txtConv=$eventi['url'][$i];
		   $descr.="<br /><br />Link consigliato per maggiori informazioni: <a href='".$txtConv."'>".$txtConv."</a>";
		   }

		   $descr.="<br /><br /></p>";
		   print "<description><![CDATA[".$descr."]]></description>";

		   // allegato (logo)
		   if ($allegato!=""){  // && is_file($fileArt)
                print $allegato;
           }
		   
		   // Categoria: zona
           if ($eventi['zona'][$i]!="") {
		   $zona=ripulisci($eventi['zona'][$i]);
		   print "<category>".strtoupper($zona)."</category>"; 
           }
           
		   // Categoria: evento in corso, imminente, passato
           if ($categEvento!="") {
		   print "<category>".$categEvento."</category>"; 
           }

           // Data inizio evento           
           if ($eventi['dataInizio'][$i]>0) {
		   $fd=pubDate($eventi['dataInizio'][$i]);
		          // Ore inizio evento
               if ($eventi['oreInizio'][$i]!="") {
	       	   $fd=sostOre($fd,$eventi['oreInizio'][$i]);
               }
    	   print "<pubDate>".$fd."</pubDate>";
           }

    print "</item>";
}
}
print "</channel>";
print "</rss>";

?>
