<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
    $file=array(
	"idFile" => array (""),
	"nome" => array (""),
	"urlfile" => array (""),
	"descriz" => array (""),
	"tipo" => array (""),
	"peso" => array (""),
	"dataIns" => array ("")
	);

$totFile=0;
$sql="SELECT idFile,nome,urlfile,descriz,tipo,peso,dataIns FROM download ORDER BY dataIns DESC, idFile ASC";	 
$query=mysqli_query($conn,$sql);
while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) { 
	if($file['urlfile']!=""){ 
	$totFile++;
	$file['idFile'][]=$row['idFile'];
	$file['nome'][]=$row['nome'];
	$file['urlfile'][]=$row['urlfile'];
	$file['descriz'][]=$row['descriz'];
	$file['tipo'][]=$row['tipo'];
	$file['peso'][]=$row['peso'];
	$file['dataIns'][]=$row['dataIns'];
	}
}
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_attivita.php"; $mysql=new mysql;

// struttura html
$title="Area download";
$metaDescription="Area download di Promogenova - Documenti, immagini e materiale vario caricato dal portale e messo a disposizione di tutti i visitatori";
$metaKeywords="download promogenova, documenti promogenova, immagini promogenova, pdf promogenova, file promogenova, consultazione";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Area download</h1>
<p>Vuoi saperne di pi&ugrave; sul portale? <a href="<?php print $url; ?>faq/" rel="index" ><img src="../lay/continua.png" alt="->" /> Clicca qui!</a><br /><br /></p>
</div>
<div class="colonna-1-4">
<p><img src="<?php print $url; ?>img/download.png" alt="areadownload" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="verde">In questa pagina</h4>
<p>Documenti, immagini e materiale vario caricato dal portale e messo a disposizione di tutti i visitatori. Tutti i file presenti sono sicuri e garantiti, il download &egrave; libero e gratuito.</p>
</div>
</div>

<?php
// LISTA FILE CARICATI E DISPONIBILI
if ($totFile>0) {
	
    for($i=1;$i<count($file['idFile']);$i++){
		print "<div class='riga'>";
		print "<div class='colonna-1-4'><p class='testo'>";
		if ($file['tipo'][$i]=="generico"){ print "<img src='".$url."ico/file.gif' alt='file' /><br/>File"; }
		if ($file['tipo'][$i]=="documento"){ print "<img src='".$url."ico/documento.gif' alt='file' /><br/>Documento"; }
		if ($file['tipo'][$i]=="pdf"){ print "<img src='".$url."ico/pdf.gif' alt='file' /><br/>Pdf"; }
		if ($file['tipo'][$i]=="immagine"){ print "<img src='".$url."ico/immagine.png' alt='file' /><br/>Immagine"; }
		if ($file['tipo'][$i]=="excel"){ print "<img src='".$url."ico/excel.gif' alt='file' /><br/>Excel"; }
		if ($file['tipo'][$i]=="ppoint"){ print "<img src='".$url."ico/ppoint.gif' alt='file' /><br/>Ppoint"; }
		if ($file['tipo'][$i]=="media"){ print "<img src='".$url."ico/filemedia.png' alt='file' /><br/>Audio/Video"; }
		$urlfile=$url."download/".$file['urlfile'][$i];
		$peso=filesize($urlfile); $kb=ceil($peso/1024);
		print "<br/><br/>Peso:<br/><span class='verde'>".$kb." Kb</span>";
		print "</p></div>";
		print "<div class='colonna-1-2'><p class='testo'>";
		print "<a href='".$url."download/".$urlfile."' style='color:black'><h3>".$file['nome'][$i]."</h3></a>";
		$txtConv=$mysql->mb_convert_encoding($file['descriz'][$i]);
        print "Descrizione:<br/><span class='nero'>".$txtConv."</span><br/><br/>";
		print "Download:<br/>";
		print "<a href='".$url."download/".$urlfile."'>www.promogenova.it/download/".$file['urlfile'][$i]."</a><br/>";
		print "</p></div>";
		print "<div class='colonna-1-4'><p class='testo' style='text-align: center'>";
		print "Data di pubblicazione:<br/>";
		print "<span class='arancio'>".substr($file['dataIns'][$i],6,2)."/".substr($file['dataIns'][$i],4,2)."/".substr($file['dataIns'][$i],0,4)."</span><br/><br/>";
		print "<a href='".$url."download/".$urlfile."'><img src='".$url."ico/download.png' alt='bottonedownload' class='scala' /></a><br/>";
		print "</p></div>";

		print "</div>";

    }
	
	
	
	
	}
// NESSUN FILE CARICATO E DISPONIBILE
else{
print "<div class='riga'><div class='colonna-1'><p>Al momento non ci sono file da scaricare.<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></p></div></div>";	
	}
?>



<?php
include "../config/footer.php";
?>
