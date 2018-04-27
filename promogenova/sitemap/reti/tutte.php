<?php
// RSS ULTIMI ARTICOLI
$url="../../";
$inc=$url."config/conn-xml.php"; include $inc;

// carica elenchi
$inc=$url."config/class_reti.php"; 
require_once $inc; $mysql=new mysql;
$reti=$mysql->elenco_reti("");

// intestazione xml
header("Content-type: text/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
print "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.9\" xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\">";

// indicizza
for ($i=1;$i<count($reti['idRete']);$i++) {
if ($reti['rete']!="") {

print "<url>";
print "<loc>";
print $baseLink."/reti/scheda.php?idRete=".$reti['idRete'][$i];
print "</loc>";

            $imgLogo=$baseLink."/reti/loghi/".$reti['logo'][$i]; 
            if ($reti['logo'][$i]!="" && file_exists($imgLogo)) {  
                print "<image:image>";
                print "<image:loc>".$imgLogo."</image:loc>"; 
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
