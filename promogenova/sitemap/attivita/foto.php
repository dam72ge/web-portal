<?php
// RSS ULTIMI ARTICOLI
$url="../../";
$inc=$url."config/conn-xml.php"; include $inc;

// intestazione xml
header("Content-type: text/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
print "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.9\" xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\">";

// indicizza
$oggi=date("Ymd");

    $sql_m="
    SELECT vetrine_foto.id,foto,dataOsc,cartella
    FROM vetrine_foto,vetrine,att_scad,attivita 
    WHERE att_scad.idAttivita=vetrine.idAttivita
    AND attivita.idAttivita=vetrine_foto.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND att_scad.osc='n' 
    ORDER BY vetrine_foto.id DESC";
    $query_m=mysql_query($sql_m);			
    while($elenco=mysql_fetch_array($query_m)){
        if ($oggi<=$elenco['dataOsc'] && $elenco['foto']!=""){

            $imgFoto=$baseLink."/".$elenco['cartella']."/foto/".$elenco['foto']; 
            if ($elenco['foto']!="" ) { // && file_exists($imgFoto)
            print "<url>";
            print "<loc>";
            print $baseLink."/".$elenco['cartella']."/foto.php?id=".$elenco['id'];
            print "</loc>";
            print "<image:image>";
            print "<image:loc>".$imgFoto."</image:loc>"; 
            print "</image:image>";
            //print "<changefreq>weekly</changefreq>";      
            //print "<priority>0.6</priority>";
            print "</url>";
            }
       }       
	}    

// Fine del file
print "</urlset>";

?>
