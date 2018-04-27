<?php
// RSS ULTIMI ARTICOLI
$url="../../";
$inc=$url."config/conn-xml.php"; include $inc;

// carica elenchi
$q=$myobj->regioni("","");

// intestazione xml
header("Content-type: text/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
print "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.9\">";

// indicizza
for ($i=1;$i<count($q['idR']);$i++) {
print "<url>";
print "<loc>";
print $baseLink."/territorio/regioni.php?idR=".$q['idR'][$i];
print "</loc>";
print "<changefreq>never</changefreq>";      
print "<priority>0.4</priority>";
print "</url>";
}

// Fine del file
print "</urlset>";

?>