<?php
// RSS ULTIMI ARTICOLI
$url="../../";
$inc=$url."config/conn-xml.php"; include $inc;

// carica elenchi
$inc=$url."config/class_eventi.php"; require_once $inc; $mysql=new mysql;
$eventi=$mysql->elenco_eventi();

// intestazione xml
header("Content-type: text/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
print "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.9\">";

// indicizza
for ($i=1;$i<count($eventi['id']);$i++) { 
	if ($eventi['titolo'][$i]!="" | $eventi['id'][$i]<=0 | $eventi['id'][$i]=="") {
		print "<url>";
		print "<loc>";
		print $baseLink."/eventi/index.php?id=".$eventi['id'][$i];
		print "</loc>";
		print "<changefreq>weekly</changefreq>";      
		print "<priority>0.8</priority>";
		print "</url>";
	}
}
// Fine del file
print "</urlset>";

?>
