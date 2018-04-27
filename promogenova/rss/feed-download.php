<?php
// RSS AREA DOWNLOAD
$url="../";
include "../config/conn-xml.php";

// db video
    $file=array(
	"idFile" => array (""),
	"nome" => array (""),
	"urlfile" => array (""),
	"descriz" => array (""),
	"tipo" => array (""),
	"peso" => array (""),
	"dataIns" => array ("")
	);

$sql="SELECT idFile,nome,urlfile,descriz,tipo,peso,dataIns FROM download ORDER BY dataIns DESC, idFile ASC";	 
$query=mysqli_query($conn,$sql);
while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) { 
	if($file['urlfile']!=""){ 
	$file['idFile'][]=$row['idFile'];
	$file['nome'][]=$row['nome'];
	$file['urlfile'][]=$row['urlfile'];
	$file['descriz'][]=$row['descriz'];
	$file['tipo'][]=$row['tipo'];
	$file['peso'][]=$row['peso'];
	$file['dataIns'][]=$row['dataIns'];
	}
}
$totFile=count($file['idFile'])-1;

$titoloFeed="Download"; 
$linkFeed="/download";
include "intestazione.php";

// leggi db
for ($i=1;$i<count($file['idFile']);$i++) {

        print "<item>";

           // Titolo
           $txtConv=$myobj->convTxt($file['nome'][$i]);
		   $tit=ripulisci($txtConv);
           print "<title>".ucfirst($tit)."</title>";

    	   // Descrizione
            $descr="<p>";
            //$descr.="Video YOUTUBE (url: <a href='".$video['url'][$i]."'>".$video['url'][$i]."</a>) pubblicato sul Canale di Promogenova";           
            $txtConv=$myobj->convTxt($file['descriz'][$i]);
            $descr.=$txtConv."<br/>";           

				// dati
				$urlfile=$url."download/".$file['urlfile'][$i];
				$peso=filesize($urlfile); $kb=ceil($peso/1024);

				if ($kb>0) {
				$descr.="<br/><b>Peso file: ".$kb." Kb</b>";    
				}

				if ($file['dataIns'][$i]!="") {
				$descr.="<br/><b>File caricato il ".substr($file['dataIns'][$i],6,2)."/".substr($file['dataIns'][$i],4,2)."/".substr($file['dataIns'][$i],0,4)."</b>";            	
				}
		   
            $descr.="</p>";
            print "<description><![CDATA[".$descr."]]></description>";
            
            // includi file
            //print "<enclosure url='".$video['url'][$i]."' length='0' type='video/wmv' />";
                         
       	    // Link alla pagina
           print "<link>".$baseLink."/download/".$file['urlfile'][$i]."</link>";
           print "<guid>".$baseLink."/download/".$file['urlfile'][$i]."</guid>";

            // Categoria: tipo file
            if ($file['tipo'][$i]!="") {
            $tipo=$myobj->convTxT($file['tipo'][$i]);
            $tipo=ripulisci($tipo);
            print "<category>".$tipo."</category>";    
            }
		   
		   // Data registrazione
           if ($file['dataIns'][$i]>0) {
		   $fd=pubDate($file['dataIns'][$i]);
    	   print "<pubDate>".$fd."</pubDate>";
           }
           

        print "</item>";

        }       
print "</channel>";
print "</rss>";
?>
