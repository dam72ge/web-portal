<?php
// RSS ALBUM
$url="../";
include "../config/conn-xml.php";

// carica eventi
require_once "../config/class_album.php"; $mysql=new mysql;
$album=$mysql->elenco_album($conn);
$totAlbum=count($album['idAlbum'])-1;

$titoloFeed="Album";
$linkFeed="/album";
include "intestazione.php";


for ($i=1;$i<count($album['idAlbum']);$i++) {
print "<item>";


           // Titolo           
		   $tit=ripulisci($album['album'][$i]);
           print "<title>".ucfirst($tit)."</title>";

    	   // Link alla pagina
           $linkAlbum=htmlentities($album['url'][$i]);
           print "<link>".$linkAlbum."</link>";

    	   // Descrizione
            $descr="<p>";

            if ($album['zona'][$i]!="") {
            $zona=ripulisci($album['zona'][$i]);
            $descr.="Localita': ".strtoupper($zona);    
            }
 
		   // data
           if ($album['giorno'][$i]!=""){
		   $txtConv=ripulisci($album['giorno'][$i]);
		   $descr.=" - Data: <i>".$txtConv."</i>";
		   }

 		   // + immagine
		   $fileArt=$baseLink."/album/copertine/".$album['copertina'][$i]; $allegato="";
		   $thumb=$baseLink."/album/copertine/th_".$album['copertina'][$i];

                if ($album['copertina'][$i]!="") { // && file_exists($fileArt)
	               $descr.="<br /><br /><img src='".$thumb."' alt='Locandina_".$album['idAlbum'][$i]."' />";
                   $allegato="<enclosure url='".$fileArt."' type='image/jpeg' />";
				}


		   // tipo di social
           $socnet="";
           if(strstr($album['url'][$i],"facebook")){ $socnet="Facebook"; }
           if(strstr($album['url'][$i],"pinterest")){ $socnet="Pinterest"; }
           if(strstr($album['url'][$i],"flickr")){ $socnet="Flickr"; }           

		   // link
           if ($album['url'][$i]!=""){
           $descr.="<br /><br />";
           if($socnet!=""){ $descr.="Caricato su <b>".$socnet."</b> - "; }

           $linkAlbum=htmlentities($album['url'][$i]);
		   $descr.="Link diretto: <a href='".$linkAlbum."'>".$linkAlbum."</a>";
		   }

		   $descr.="<br /><br /></p>";
		   print "<description><![CDATA[".$descr."]]></description>";

		   // allegato (logo)
		   if ($allegato!=""){  // && is_file($fileArt)
                print $allegato;
           }
		   
		   // Categoria: zona
           if ($album['zona'][$i]!="") {
		   $zona=ripulisci($album['zona'][$i]);
		   print "<category>".strtoupper($zona)."</category>"; 
           }

		   // Categoria: social
           if ($socnet!="") {
		   print "<category>".$socnet."</category>"; 
           }
           
           // Data album           
           if ($album['dataUp'][$i]>0) {
		   $fd=pubDate($album['dataUp'][$i]);
    	   print "<pubDate>".$fd."</pubDate>";
           }
/*
*/
    print "</item>";
}
print "</channel>";
print "</rss>";

?>
