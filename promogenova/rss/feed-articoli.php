<?php
// RSS ARTICOLI
$url="../";
include "../config/conn-xml.php";

$titoloFeed="Articoli";
$linkFeed="/ricerche/tutti-gli-articoli.php";
include "intestazione.php";

// leggi db
    $sql="SELECT articoli.idArt,img,titolo,testo,macro, att_clienti.dataReg, dataOsc, attivita,cartella
    FROM articoli,articoli_dat,macro,articoli_txt, attivita,att_scad,att_clienti,vetrine
    WHERE articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro
    AND articoli_dat.idAttivita=attivita.idAttivita
    AND attivita.idAttivita=att_scad.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND attivita.idAttivita=att_clienti.idAttivita
    AND articoli.osc='n'    
    AND att_scad.osc='n'    
    ORDER BY articoli.idArt DESC, dataReg DESC, titolo ASC";
    $query=mysqli_query($conn,$sql);			
    while($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if ($oggi<=$riga['dataOsc'] && $riga['titolo']!="") {

        print "<item>";
	   
           // Titolo
		   $tit=ripulisci($riga['titolo']);
           print "<title>".$tit."</title>";

    	   // Link alla pagina
           print "<link>".$baseLink."/".$riga['cartella']."/articoli.php?idArt=".$riga['idArt']."</link>";
           print "<guid>".$baseLink."/".$riga['cartella']."/articoli.php?idArt=".$riga['idArt']."</guid>";
           
    	   // Descrizione
           $descr="<p>";           
		   
           $tit=ripulisci($riga['attivita']);
		   $descr.="Pubblicato da: <a href='".$baseLink."/".$riga['cartella']."'><b>".$tit."</b></a><br /><br />";


		   // + immagine
		   $fileArt=$baseLink."/".$riga['cartella']."/articoli/".$riga['img']; $allegato="";
		   $thumb=$baseLink."/".$riga['cartella']."/articoli/th_".$riga['img'];

                if ($riga['img']!="") { // && file_exists($fileArt)
	               $descr.="<img src='".$thumb."' alt='img_".$riga['idArt']."' /><br /><br />";
                   $allegato="<enclosure url='".$fileArt."' type='image/jpeg' />";
				   }

		   if($riga['testo']!=""){
		   $txtConv=ripulisci($riga['testo']);
		   $descr.="<br /><i>".$txtConv."</i><br /><br />";
		   }
		   
		   $descr.="</p>";		   
		   print "<description><![CDATA[".$descr."]]></description>";

		   // allegato (logo)
		   if ($allegato!=""){  // && is_file($fileArt)
                print $allegato;
           }

		   // Categoria: macro
		   if($riga['macro']!=""){
           $txtConv=ripulisci($riga['macro']);
    	   print "<category>".ucfirst($txtConv)."</category>";
		   }
		   
		   // Categoria: attività
		   if($riga['attivita']!=""){
           $txtConv=ripulisci($riga['attivita']);
    	   print "<category>".ucfirst($txtConv)."</category>";
		   }

		   // Data registrazione
		   if($riga['dataReg']>0){
		   $fd=pubDate($riga['dataReg']);
    	   print "<pubDate>".$fd."</pubDate>";
		   }
        print "</item>";
    }       
    }
    print "</channel>";
print "</rss>";
?>
