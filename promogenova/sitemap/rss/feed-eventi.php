<?php
// RSS ULTIMI ARTICOLI
$url="../";
include "../config/conn-xml.php";

// carica eventi
require_once "../config/class_eventi.php"; $mysql=new mysql;
$eventi=$mysql->elenco_eventi();

$titoloFeed="Eventi";
include "intestazione.php";

for ($i=1;$i<count($eventi['id']);$i++) {
if ($eventi['titolo'][$i]!="" && $eventi['dataInizio'][$i]>0 && $eventi['dataOsc'][$i]>0) {
print "<item>";

           // Titolo
		   $tit=ripulisci($eventi['titolo'][$i]);
           print "<title>".ucfirst($tit)."</title>";

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

            if ($oggi>=$eventi['zona'][$i]) {
            $zona=ripulisci($eventi['zona'][$i]);
            $descr.="Localita': ".strtoupper($zona)." - ";    
            }
 
            if ($eventi['dataInizio'][$i]!="") {
            $descr.="Dalle ore ".$eventi['oreInizio'][$i];
                if ($eventi['dataInizio'][$i]==$eventi['dataInizio'][$i]) {
                $descr.=" alle ore ".$eventi['oreFine'][$i]." del giorno <span class='viola'>".$myobj->visData($eventi['dataFine'][$i])."</span>"; 
                }
                else {
                $descr.=" del <span class='viola'>".$myobj->visData($eventi['dataInizio'][$i])."</span> alle ore ".$eventi['oreFine'][$i]." del <span class='viola'>".$myobj->visData($eventi['dataFine'][$i])."</span>";
                }	
            }

		   // + immagine
		   $fileArt=$baseLink."/eventi/locandine/".$eventi['img'][$i]; $allegato="";
		   $thumb=$baseLink."/eventi/locandine/th_".$eventi['img'][$i];

                if ($eventi['img'][$i]!="") { // && file_exists($fileArt)
	               $descr.="<br /><br /><img src='".$thumb."' alt='Evento_".$eventi['id'][$i]."' />";
                   $allegato="<enclosure url='".$fileArt."' type='image/jpeg' />";
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