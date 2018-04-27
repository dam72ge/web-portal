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

    $sql="SELECT articoli.idArt,titolo,dataOsc,img,cartella
    FROM articoli,articoli_dat,macro,articoli_txt, attivita,att_scad,vetrine
    WHERE articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro
    AND articoli_dat.idAttivita=attivita.idAttivita
    AND attivita.idAttivita=att_scad.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND articoli.osc='n'    
    AND att_scad.osc='n'    
    ORDER BY titolo ASC, articoli.idArt DESC";
    $query=mysql_query($sql);			
    while($q=mysql_fetch_array($query)){
        if ($oggi<=$q['dataOsc'] && $q['titolo']!="") {

            print "<url>";
            print "<loc>";
            print $baseLink."/".$q['cartella']."/articoli.php?idArt=".$q['idArt'];
            print "</loc>";

            $imgArt=$baseLink."/".$q['cartella']."/articoli/".$q['img']; 
            if ($q['img']!="" && file_exists($imgArt) ) { 
                print "<image:image>";
                print "<image:loc>".$imgArt."</image:loc>"; 
                print "</image:image>";
            }       

            print "<changefreq>weekly</changefreq>";      
            print "<priority>0.7</priority>";
            print "</url>";
       }       
	}    

// Fine del file
print "</urlset>";

?>
