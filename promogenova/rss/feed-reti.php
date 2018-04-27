<?php
// RSS RETI
$url="../";
include "../config/conn-xml.php";

// carica eventi
require_once "../config/class_reti.php"; $mysql=new mysql;
$reti=$mysql->elenco_reti($conn,"");

// riordina reti per idRete decrescente
array_multisort(
$reti['idRete'],SORT_DESC,SORT_NUMERIC,
$reti['rete'],SORT_ASC,SORT_REGULAR,
$reti['zona'],SORT_ASC,SORT_REGULAR,
$reti['settore'],SORT_ASC,SORT_REGULAR,
$reti['logo'],SORT_ASC,SORT_REGULAR,
$reti['descriz'],SORT_ASC,SORT_REGULAR
);


$titoloFeed="Reti";
$linkFeed="/reti";
include "intestazione.php";

for ($i=0; $i<count($reti['idRete']);$i++) {
if ($reti['idRete'][$i]>0){
print "<item>";

           // Titolo           
		   $tit=ripulisci($reti['rete'][$i]);
           print "<title>".ucfirst($tit)."</title>";

    	   // Link alla pagina
           $linkRete=$baseLink."/reti/scheda.php?idRete=".$reti['idRete'][$i];
           $linkRete=htmlentities($linkRete);
           print "<link>".$linkRete."</link>";

    	   // Descrizione
            $descr="<p>";

                // zona
                if ($reti['zona'][$i]!="") {
                $zona=ripulisci($reti['zona'][$i]);
               $descr.="Zona: ".strtoupper($zona);    
                }
 
		        // settore
              if ($reti['settore'][$i]!=""){
	       	  $txtConv=ripulisci($reti['settore'][$i]);
		      $descr.=" - Settore: <i>".$txtConv."</i>";
		      }

 		   // + immagine
		   $fileArt=$baseLink."/reti/loghi/".$reti['logo'][$i]; $allegato="";
		   $thumb=$baseLink."/reti/loghi/th_".$reti['logo'][$i];

                if ($reti['logo'][$i]!="") { // && file_exists($fileArt)
	               $descr.="<br /><br /><img src='".$thumb."' alt='Rete_".$reti['idRete'][$i]."' />";
                   $allegato="<enclosure url='".$fileArt."' type='image/jpeg' />";
				}

		   // descrizione
           if ($reti['descriz'][$i]!=""){
           $descr.="<br /><br />";
           $txtConv=ripulisci($reti['descriz'][$i]);
		   $descr.="<br /><br />".$txtConv;
		   }

		   $descr.="<br /><br /></p>";
		   print "<description><![CDATA[".$descr."]]></description>";

		   // allegato (logo)
		   if ($allegato!=""){  // && is_file($fileArt)
                print $allegato;
           }
		   
		   // Categoria: zona
           if ($reti['zona'][$i]!="") {
		   $zona=ripulisci($reti['zona'][$i]);
		   print "<category>".strtoupper($zona)."</category>"; 
           }

		   // Categoria: settore
              if ($reti['settore'][$i]!=""){
	       	  $txtConv=ripulisci($reti['settore'][$i]);
		      print "<category>".$txtConv."</category>";
		      }
           
    print "</item>";
}
}
print "</channel>";
print "</rss>";

?>
