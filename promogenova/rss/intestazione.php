<?php
// Modifico l'intestazione e il tipo di documento da PHP a XML
header("Content-type: text/xml");

// Eseguo le operazioni di scrittura sul file
print "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
print "<rss version=\"2.0\">";
    print "<channel>";
    print "<title>Promogenova.it - ".$titoloFeed."</title>";
    print "<link>".$baseLink.$linkFeed."</link>";
    print "<description>Vetrine web, Eventi, Comunicazione</description>";
    print "<copyright>Copyright 2009-13 Promogenova.it</copyright>";
    print "<docs>http://blogs.law.harvard.edu/tech/rss</docs>";
    //echo "<managingEditor>email@miosito.com</managingEditor>\n";
    //echo "<webMaster>mia-email@miosito.com</webMaster>\n";
    print "<language>IT-it</language>";

print "<image>
      <url>http://www.promogenova.it/img/logo.png</url>
      <title>Promogenova</title>
      <link>http://www.promogenova.it</link>
      <width>135</width>
      <height>90</height>
    </image>";
?>
