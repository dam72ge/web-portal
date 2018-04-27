<?php
// RSS ULTIMI ARTICOLI
$url="../";
include "../config/conn-xml.php";

// db video
require_once "../config/class_video.php"; $mysql=new mysql;
$video=$mysql->elenco_video();
$totVideo=count($video['idVideo'])-1;

$titoloFeed="Video";
include "intestazione.php";

// leggi db
for ($i=1;$i<count($video['idVideo']);$i++) {

        print "<item>";

           // Titolo
           $txtConv=$myobj->convTxt($video['video'][$i]);
		   $tit=ripulisci($txtConv);
           print "<title>".ucfirst($tit)."</title>";
           
    	   // Descrizione
            $descr="<p>";
            $descr.="Video YOUTUBE (url: <a href='".$video['url'][$i]."'>".$video['url'][$i]."</a>) pubblicato sul Canale di Promogenova";           
            if ($video['giorno'][$i]!="") {
            $giorno=$myobj->convTxT($video['giorno'][$i]);
            $descr.=" - ".$giorno;            	
            }

            if ($video['zona'][$i]!="") {
            $zona=$myobj->convTxT($video['zona'][$i]);
            $descr.=" - Luogo: ".$zona;    
            }
		   
            $descr.="</p>";
            print "<description><![CDATA[".$descr."]]></description>";
            
            // includi video
            print "<source url='http://www.youtube.com/user/promogenova'>Canale You Tube di Promogenova</source>";
            print "<enclosure url='".$video['url'][$i]."' type='text/html' />";
                         
            // link diretto
            print "<link>".$video['url'][$i]."</link>";


            // Categoria: zona
            if ($video['zona'][$i]!="") {
            $zona=$myobj->convTxT($video['zona'][$i]);
            print "<category>".$zona."</category>";    
            }
		   
            // Categoria: anno
            if ($video['anno'][$i]>0) {
            print "<category>".$video['anno'][$i]." (anno)</category>";    
            }

		   // Data registrazione
           if ($video['dataUp'][$i]>0) {
		   $fd=pubDate($video['dataUp'][$i]);
    	   print "<pubDate>".$fd."</pubDate>";
           }
           

        print "</item>";

        }       
print "</channel>";
print "</rss>";
?>