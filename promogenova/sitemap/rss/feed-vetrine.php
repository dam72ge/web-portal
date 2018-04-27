<?php
// RSS ULTIME VETRINE
$url="../";
include "../config/conn-xml.php";

require_once "../config/class_attivita.php"; $mysql=new mysql;
$attivita=$mysql->elenco_attivita($url,"dataReg DESC, attivita ASC, idAttivita DESC");
$totAttivita=count($attivita['idAttivita'])-1;

$titoloFeed="Vetrine web";
include "intestazione.php";

// leggi database
if ($totAttivita>0) {
if ($attivita['attivita'][$i]=!"") {

    for ($i=1;$i<count($attivita['idAttivita']);$i++) {
    print "<item>";
    $cartVetr=$baseLink."/".$attivita['cartella'][$i];

           // Titolo
		   $tit=ripulisci($attivita['attivita'][$i]);
           print "<title>".$tit."</title>";
                
    	   // Link alla pagina
           print "<link>".$cartVetr."</link>";
           print "<guid>".$cartVetr."</guid>";
                      
           // testo
           $descr="<p>";
           
    	   // Descrizione: ragsoc
           if ($attivita['ragsoc'][$i]!="") {
		   $ragsoc=ripulisci($attivita['ragsoc'][$i]);
		   $descr.="<b>".$ragsoc."</b><br />";
           }

		   // + indirizzo
           if ($attivita['zona'][$i]!="") {
		   $zona=ripulisci($attivita['zona'][$i]);
		   $descr.=ucwords($zona)."<br />"; 
           }
           
		   // + logo
		   $fileArt=$cartVetr."/".$attivita['logo'][$i]; $allegato="";
		   $thumb=$cartVetr."/th_".$attivita['logo'][$i];

		   		   if ($attivita['logo'][$i]!=""){  // && is_file($fileArt)
				   $descr.="<br /><br /><img src='".$thumb."' alt=''/>";
                   $allegato="<enclosure url='".$fileArt."' type='image/jpeg' />";
				   }
                   
    	   // Chisiamo
           if ($attivita['chisiamo'][$i]!="") {
		   $chisiamo=ripulisci($attivita['chisiamo'][$i]);
		   $descr.="<br /><br />".$chisiamo;
           }

		   $descr.="<br /><br /></b><br /></p>";
		   print "<description><![CDATA[".$descr."]]></description>";


		   // allegato (logo)
		   if ($allegato!=""){  // && is_file($fileArt)
                print $allegato;
           }

		   // Categoria: ragione sociale
           if ($attivita['ragsoc'][$i]!="") {
		   $ragsoc=ripulisci($attivita['ragsoc'][$i]);
    	   print "<category>".$ragsoc."</category>";
           }
		   
		   // Categoria: zona
           if ($attivita['zona'][$i]!="") {
		   $zona=ripulisci($attivita['zona'][$i]);
		   print "<category>".strtoupper($zona)."</category>"; 
           }

		   // Data registrazione
           if ($attivita['dataReg'][$i]>0) {
		   $fd=pubDate($attivita['dataReg'][$i]);
    	   print "<pubDate>".$fd."</pubDate>";
           }

    print "</item>";
    }
    }
    }
    print "</channel>";
print "</rss>";

?>