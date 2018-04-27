<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../download">Download</a> | Modifica singolo file</h3>

<?php
// recupera dati da url
$id=$_GET['id'];

// modifiche
if (isset($_POST['new_nome'])) {
	  $sql="UPDATE download SET 
	  nome='".mysqli_real_escape_string($conn,stripslashes($_POST['new_nome']))."'
	  WHERE idFile='".$id."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['new_urlfile'])) {
	  $sql="UPDATE download SET 
	  urlfile='".mysqli_real_escape_string($conn,stripslashes($_POST['new_urlfile']))."'
	  WHERE idFile='".$id."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['new_descriz'])) {
	  $sql="UPDATE download SET 
	  descriz='".mysqli_real_escape_string($conn,stripslashes($_POST['new_descriz']))."'
	  WHERE idFile='".$id."'";
      $query=mysqli_query($conn,$sql);
}

if (isset($_POST['new_dataIns'])) {
	  $sql="UPDATE download SET 
	  dataIns='".mysqli_real_escape_string($conn,stripslashes($_POST['new_dataIns']))."'
	  WHERE idFile='".$id."'";
      $query=mysqli_query($conn,$sql);
}

if (isset($_POST['new_peso'])) {
	  $sql="UPDATE download SET 
	  peso='".mysqli_real_escape_string($conn,stripslashes($_POST['new_peso']))."'
	  WHERE idFile='".$id."'";
      $query=mysqli_query($conn,$sql);
}

if (isset($_POST['new_tipo'])) {
	  $sql="UPDATE download SET 
	  tipo='".mysqli_real_escape_string($conn,stripslashes($_POST['new_tipo']))."'
	  WHERE idFile='".$id."'";
      $query=mysqli_query($conn,$sql);
}

// eliminazione
if (isset($_POST['elimina']) && $_POST['elimina']=="s") {
    $sql="DELETE FROM download WHERE idFile='".$id."'";
    $query=mysqli_query($conn,$sql);
	$redirUrl="index.php";
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
}



print "<h4>Modifica dati File ID:".$id." - ";
$succ=$id+1; print "<a href='file.php?id=".$succ."'>Successivo</a> | ";
$prec=$id-1; print "<a href='file.php?id=".$prec."'>Precedente</a></h4>";

	 $sql="SELECT 
	 nome,urlfile,tipo,peso,descriz,dataIns
     
     FROM 
     download
     
     WHERE 
     idFile='".$id."'";
	 
	 $query=mysqli_query($conn,$sql);
	 $file=mysqli_fetch_array($query,MYSQLI_ASSOC);
     
	 $urlfile=$url."download/".$file['urlfile'];
	 $peso=filesize($urlfile); $kb=ceil($peso/1024);
	 $oggi= date('Ymd');

?>


  <form id="clPrincip" method="post" action="?id=<?php print $id; ?>"><p>
	<?php
			print "<label>File sul server</label> <input type='text' size='40' name='new_urlfile' value='".$file['urlfile']."' disabled /> ";
			print "<label>Peso KB</label> <input type='text' size='10' name='new_peso' value='".$kb."' /><br />";
			print "<label>Nome da visualizzare</label> <input type='text' size='40' name='new_nome' value='".$file['nome']."' /><br />";
			print "<label>Data inserimento (annommgg)</label> <input type='text' size='10' name='new_dataIns' value='".$file['dataIns']."' /><br />";
			print "<label>Descrizione</label><br/><textarea name='new_descriz' rows='4' cols='50'/>".$file['descriz']."</textarea><br />";

	?>

  <label>Tipo</label> 
  <select options="1" name="new_tipo">
  <?php
    print "<option value='generico'";
    if ($file['tipo']=="generico") { print " selected";} 
    print ">File non specificato</option>";
    print "<option value='documento'";
    if ($file['tipo']=="documento") { print " selected";} 
    print ">Documento</option>";
    print "<option value='pdf'";
    if ($file['tipo']=="pdf") { print " selected";} 
    print ">PDF</option>";
    print "<option value='immagine'";
    if ($file['tipo']=="immagine") { print " selected";} 
    print ">Immagine</option>";
    print "<option value='excel'";
    if ($file['tipo']=="excel") { print " selected";} 
    print ">Foglio excel</option>";
    print "<option value='ppoint'";
    if ($file['tipo']=="ppoint") { print " selected";} 
    print ">Presentazione/slide</option>";
    print "<option value='media'";
    if ($file['tipo']=="media") { print " selected";} 
    print ">Audio/video</option>";
  ?>
  </select>
  <br /><br />
  

  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />


  <form id="fileElim" method="post" action="?id=<?php print $id; ?>"><p> 
  <label>Eliminare file?</label><br />
  <select options="1" name="elimina">
    print "<option value='n' selected>NO</option><option value='s'>SI</option>";
  </select>
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />


<br /><br />
