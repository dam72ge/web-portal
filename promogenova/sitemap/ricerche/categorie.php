<?php
// RSS ULTIMI ARTICOLI
$url="../../";
$inc=$url."config/conn-xml.php"; include $inc;

// intestazione xml
header("Content-type: text/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
print "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.9\">";

// indicizza
$oggi=date("Ymd");

    $sql_cat="SELECT idMacro FROM macro ORDER BY macro ASC";
    $query_cat=mysql_query($sql_cat);			
    while($cat=mysql_fetch_array($query_cat)){
            print "<url>";
            print "<loc>";
            print $baseLink."/ricerche/macro.php?idMacro=".$cat['idMacro'];
            print "</loc>";
            print "<changefreq>yearly</changefreq>";      
            print "<priority>0.7</priority>";
            print "</url>";
	}    

// Fine del file
print "</urlset>";

?>
