<?php
// RSS ULTIMI ARTICOLI
$url="../";
include "../config/conn-xml.php";

$titoloFeed="Marchi";
include "intestazione.php";

// leggi db
$oggi=date("Ymd");
    $sql_m="
    SELECT marchio,dataOsc,cartella,attivita
    FROM vetrine_marchi,vetrine,att_scad,attivita 
    WHERE att_scad.idAttivita=vetrine_marchi.idAttivita
    AND att_scad.idAttivita=vetrine.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND osc='n' 
    ORDER BY id DESC";
    $query_m=mysql_query($sql_m);			
    while($marchi=mysql_fetch_array($query_m)){
        if ($oggi<=$marchi['dataOsc'] && $marchi['marchio']!=""){

        print "<item>";

           // Titolo
		   $titMarchio=ripulisci($marchi['marchio']);
           print "<title>".ucfirst($titMarchio)."</title>";

    	   // Descrizione
           if ($marchi['attivita']!="") {
           $descr="<p>Il marchio ".strtoupper($titMarchio)." e' trattato da ";
		   $tit=ripulisci($marchi['attivita']);
           $descr.="<a href='".$baseLink."/".$marchi['cartella']."'>".strtoupper($tit)."</a><br />"; 
           $descr.="Vetrina web: <a href='".$baseLink."/".$marchi['cartella']."'>".$baseLink."/".$marchi['cartella']."</a><br />"; 
		   $descr.="<br /></p>";
		   print "<description><![CDATA[".$descr."]]></description>";
           }

           // link diretto ->ricerche/tutti-i-marchi.php#marchio // ?marchio=".strtolower($titMarchio)." 
           print "<link>".$baseLink."/ricerche/tutti-i-marchi.php#".strtolower($titMarchio)."</link>"; 

		   // Categoria: nome marchio
    	   print "<category>".$titMarchio."</category>";

           // Categoria: nome attività
           if ($marchi['attivita']!="") {
		   $tit=ripulisci($marchi['attivita']);
           print "<category>".$tit."</category>"; 
           }

        print "</item>";
        }
    }
           
print "</channel>";
print "</rss>";
?>