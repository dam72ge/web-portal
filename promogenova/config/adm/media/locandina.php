<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../media">Media</a> | <a href="seleziona.php">Seleziona locandine</a> | Modifica locandina</h3>

<?php
// recupera dati da url
$idMedia=$_GET['idMedia'];

// modifica
if (isset($_POST['idMedia']) && isset($_POST['id'])) {
	  $sql="UPDATE media_link SET 
	  id='".$_POST['id']."'
	  WHERE idMedia='".$idMedia."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['idMedia']) && isset($_POST['idAlbum'])) {
	  $sql="UPDATE media_link SET 
	  idAlbum='".$_POST['idAlbum']."'
	  WHERE idMedia='".$idMedia."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['idMedia']) && isset($_POST['idVideo'])) {
	  $sql="UPDATE media_link SET 
	  idVideo='".$_POST['idVideo']."'
	  WHERE idMedia='".$idMedia."'";
      $query=mysqli_query($conn,$sql);
}

// sostituire locandina?
if(isset($_FILES['newImg']['name'])){
   $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
   $urlCompleto=$url."locandine/".$idMedia.".".$ext;
   move_uploaded_file($_FILES['newImg']['tmp_name'], $urlCompleto); //@rename
   $locandina=$idMedia.".".$ext;   
   $sql="UPDATE media SET
   img='".mysqli_real_escape_string($conn,stripslashes($locandina))."'
   WHERE idMedia='".$idMedia."'";
   $query=mysqli_query($conn,$sql);

	  // crea thumb
	  $dirFile=$url."locandine/"; //cartella
	  $myobj->creathumb($dirFile,$locandina,250,250,$dirFile,"th_");
	  $myobj->creathumb($dirFile,$locandina,48,48,$dirFile,"ico_");

    // vai a modifica
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='locandina.php?idMedia=".$idMedia."';\n"; 
    echo "</script>"; 
}


// eliminare tutto?
if (isset($_POST['idMedia']) && isset($_POST['rimLoc']) && $_POST['rimLoc']=="s") {
   $urlFile=$url."locandine/".$_POST['img'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."locandine/th_".$_POST['img'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."locandine/ico_".$_POST['img'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $sql="DELETE FROM media WHERE idMedia='".$idMedia."'"; 
      $query=mysqli_query($conn,$sql);
   $sql="DELETE FROM media_link WHERE idMedia='".$idMedia."'"; 
      $query=mysqli_query($conn,$sql);
    // ricarica pagina
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='seleziona.php';\n"; 
    echo "</script>"; 
}


print "<h4>Modifica locandina ".$idMedia."</h4>";

$succ=$idMedia+1; print "<a href='locandina.php?idMedia=".$succ."'>Successivo</a> | ";
$prec=$idMedia-1; print "<a href='locandina.php?idMedia=".$prec."'>Precedente</a></h4>";

	 $sql="SELECT media.idMedia,img,id,idAlbum,idVideo
     FROM media,media_link
     WHERE media.idMedia=media_link.idMedia
     AND media.idMedia='".$idMedia."'";

	 $query=mysqli_query($conn,$sql);
	 $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
	 
?>

<form id="nuovoMedia" method="post" enctype="multipart/form-data" action="?idMedia=<?php print $idMedia; ?>"><p>
<label>Locandina nro <?php print $idMedia; ?></label><br />

<?php
	 $fileLink=$url."locandine/".$row['img'];
	 $thumb=$url."locandine/ico_".$row['img'];
		if ($row['img']!="" && file_exists($thumb)){
		print "<a href='".$fileLink."'><img src='".$thumb."'></a>";
		}
	 $thumb=$url."locandine/th_".$row['img'];
		if ($row['img']!="" && file_exists($thumb)){
		print "<a href='".$fileLink."'><img src='".$thumb."'></a>";
		}
?>
<br><br/>



<?php
print "<label>Evento collegato</label><br/>";
print "<select options='1' name='id'>";
print "<option value='0' selected>NESSUNO</option>";
$sql_d="SELECT id,titolo FROM eventi ORDER BY titolo ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['id']."'";
    if ($elenco['id']==$row['id']) { print " selected";}
    print ">".substr($elenco['titolo'],0,50)." [".$elenco['id']."]</option>";
}
print "</select><br /><br/>";

print "<label>Album collegato</label><br/>";
print "<select options='1' name='idAlbum'>";
print "<option value='0' selected>NESSUNO</option>";
$sql_d="SELECT idAlbum,album FROM album ORDER BY album ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idAlbum']."'";
    if ($elenco['idAlbum']==$row['idAlbum']) { print " selected";}
    print ">".substr($elenco['album'],0,50)." [".$elenco['idAlbum']."]</option>";
}
print "</select><br /><br/>";

print "<label>Video collegato</label><br/>";
print "<select options='1' name='idVideo'>";
print "<option value='0' selected>NESSUNO</option>";
$sql_d="SELECT idVideo,video FROM video ORDER BY video ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idVideo']."'";
     if ($elenco['idVideo']==$row['idVideo']) { print " selected";}
   print ">".substr($elenco['video'],0,50)." [".$elenco['idVideo']."]</option>";
}
print "</select><br /><br/>";
?>

<label>AZIONI SULLA LOCANDINA</label><br/>
  <select name="rimLoc" options="1">
  <option value="n" selected>Mantieni e/o salva le modifiche</option>
  <option value="s">RIMUOVI LOCANDINA</option>
  </select>

<br/><br/>
<input type="hidden" name="img" value="<?php print $row['img']; ?>" />
<input type="hidden" name="idMedia" value="<?php print $idMedia; ?>" />
<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />




<?php
	 $fileLink=$url."locandine/".$row['img'];
	 $thumb=$url."locandine/ico_".$row['img'];
		//if ($row['img']!="" && file_exists($thumb)){
?>
<form id="sostMedia" method="post" enctype="multipart/form-data" action="?idMedia=<?php print $idMedia; ?>"><p>
<label>Sostituire locandina con nuova?</label><br />
<input type="file" name="newImg" value="" /><br /><br />
<input type="hidden" name="img" value="<?php print $row['img']; ?>" />
<input type="hidden" name="idMedia" value="<?php print $idMedia; ?>" />
<input type="submit" name="salva" value="SALVA NUOVO FILE"  />
</p></form>
<?php
		//}
?>




