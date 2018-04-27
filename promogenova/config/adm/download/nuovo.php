<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../download">Download</a> | CREA NUOVO FILE</h3>

<?php
// modifiche
if (isset($_POST['urlfile']) && $_POST['urlfile']!="") {

    $sql = 
    "
    INSERT INTO download
    (idFile,nome,urlfile,tipo,peso,descriz,dataIns) 
    VALUES 
    ( 
    default,
    '".mysqli_real_escape_string($conn,stripslashes($_POST['nome']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['urlfile']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['tipo']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['peso']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['descriz']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['dataIns']))."'
    )";
    $query=mysqli_query($conn,$sql);
	//print $sql."<br />"; exit;

    // id nuovo file
   	$idNuovo=mysqli_insert_id($conn);

// VAI DIRETTAMENTE ALLA PAGINA DI MODIFICA
$redirUrl="file.php?id=".$idNuovo;

        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 

}
?>



<i>Attenzione! I file devono essere gi&agrave; caricati sul server (cartella: download) per poter essere registrati sul database</i><br/><br/>

<?php
$n=0; $registrato="n";
//Imposto la directory da leggere
$directory = $url."download/";
// Apriamo una directory e leggiamone il contenuto.
if (is_dir($directory)) {
    //Apro l'oggetto directory
    if ($directory_handle = opendir($directory)) {
        //Scorro l'oggetto fino a quando non è termnato cioè false
        while (($file = readdir($directory_handle)) !== false) {
            //Se l'elemento trovato è diverso da una directory
            //o dagli elementi . e .. lo visualizzo a schermo
            if( (!is_dir($file))&($file!=".")&($file!="..") && $file!="index.php"){
            $n++;
			$urlfile=$url."download/".$file;
			$peso=filesize($urlfile); $kb=ceil($peso/1024);
			$oggi= date('Ymd');

			$sql="SELECT idFile FROM download WHERE urlfile='".$file."'";	 
			$query=mysqli_query($conn,$sql);
			$row=mysqli_fetch_array($query,MYSQLI_ASSOC);
			if ($row['idFile']==""){

			// FORM INSERIMENTO FILE IN DATABASE						
			print "<b>Inserimento file #".$n."</b><br/>";
			print "<form name='insFile".$n."' method='post' action='?'><p>";
			print "<input type='hidden' size='40' name='urlfile' value='".$file."' />";
			print "<input type='hidden' size='40' name='peso' value='".$peso."' />";
			print "<label>File sul server</label> <input type='text' size='40' name='dis_urlfile' value='".$file."' disabled /> ";
			print "<label>Peso KB</label> <input type='text' size='10' name='dis_peso' value='".$kb."' disabled /><br />";
			print "<label>Nome da visualizzare</label> <input type='text' size='40' name='nome' value='' /><br />";
			print "<label>Tipo file</label> <select options='1' name='tipo'>";
			print "<option value='generico' selected>File non specificato</option>";
			print "<option value='documento'>Documento</option>";
			print "<option value='pdf'>PDF</option>";
			print "<option value='immagine'>Immagine</option>";
			print "<option value='excel'>Foglio excel</option>";
			print "<option value='ppoint'>Presentazione/slide</option>";
			print "<option value='media'>Audio/video</option>";
			print "</select> ";
			print "<label>Data inserimento (annommgg)</label> <input type='text' size='10' name='dataIns' value='".$oggi."' /><br />";
			print "<label>Descrizione</label><br/><textarea name='descriz' rows='4' cols='50' /></textarea><br />";
								
			print "<input type='submit' name='salva' value='SALVA'  />";
			print "</p></form><br/><br/>";
			}
			}

 
        }
        //Chiudo la lettura della directory.
        closedir($directory_handle);
    }
}


?>



