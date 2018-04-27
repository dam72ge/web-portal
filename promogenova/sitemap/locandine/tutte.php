<?php
// RSS LOCANDINE
$url="../../";
$inc=$url."config/conn-xml.php"; include $inc;

// intestazione xml
header("Content-type: text/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
print "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.9\" xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\">";

// indicizza
$oggi=date("Ymd");

    $sql_m="
    SELECT idMedia,img 
    FROM media
    ORDER BY idMedia ASC, img ASC";
    $query_m=mysql_query($sql_m);
    while($elenco=mysql_fetch_array($query_m)){
        if ($elenco['img']!=""){
            print "<url><loc>".$baseLink."/locandine/".$elenco['img']."</loc>";
			//print "<image:title>Locandina n.".$elenco['idMedia']." - Promogenova.it</image:title>";
            print "<image:image><image:loc>".$baseLink."/locandine/".$elenco['img']."</image:loc></image:image>";
			//print "<image:caption>Locandina n.".$elenco['idMedia']." pubblicata su Promogenova.it</image:caption>";
            print "</url>";

            print "<url><loc>".$baseLink."/locandine/th_".$elenco['img']."</loc>";
			//print "<image:title>Thumb locandina n.".$elenco['idMedia']." - Promogenova.it</image:title>";
            print "<image:image><image:loc>".$baseLink."/locandine/th_".$elenco['img']."</image:loc></image:image>";
			//print "<image:caption>Thumb - Locandina n.".$elenco['idMedia']." pubblicata su Promogenova.it</image:caption>";
            print "</url>";

            print "<url><loc>".$baseLink."/locandine/th_".$elenco['img']."</loc>";
			//print "<image:title>Minithumb locandina n.".$elenco['idMedia']." - Promogenova.it</image:title>";
            print "<image:image><image:loc>".$baseLink."/locandine/ico_".$elenco['img']."</image:loc></image:image>";
			//print "<image:caption>Minithumb - Locandina n.".$elenco['idMedia']." pubblicata su Promogenova.it</image:caption>";
            print "</url>";
       }       
	}    

// Fine del file
print "</urlset>";

?>
