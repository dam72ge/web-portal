<?php
// RSS ULTIMI ARTICOLI
$url="../../";
$inc=$url."config/conn-xml.php"; include $inc;

// carica elenchi
$inc=$url."config/class_attivita.php"; 
require_once $inc; $mysql=new mysql;
$attivita=$mysql->elenco_attivita($url,"idAttivita DESC, attivita ASC");

// intestazione xml
header("Content-type: text/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
print "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.9\" xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\">";

// indicizza
for ($i=1;$i<count($attivita['idAttivita']);$i++) { 
print "<url>";
print "<loc>";
print $baseLink."/".$attivita['cartella'][$i];
print "</loc>";

            $imgLogo=$baseLink."/".$attivita['cartella'][$i]."/".$attivita['logo'][$i]; 
            if ($attivita['logo'][$i]!="" && file_exists($imgLogo)) {  
                print "<image:image>";
                print "<image:loc>".$imgLogo."</image:loc>"; 
                print "</image:image>";
            }       

print "<changefreq>monthly</changefreq>";      
print "<priority>0.8</priority>";
print "</url>";
}

// Fine del file
print "</urlset>";

?>
