<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../album">album</a> | <a href="../album/seleziona.php">Seleziona album per data</a> | Modifica singolo album</h3>

<?php
// recupera dati da url
$idAlbum=$_GET['idAlbum'];

// modifica
if (isset($_POST['album'])) {
	  $sql="UPDATE album SET 
	  album='".mysql_real_escape_string($conn,stripslashes($_POST['album']))."',
	  url='".mysql_real_escape_string($conn,stripslashes($_POST['url']))."',
	  dataUp='".mysql_real_escape_string($conn,stripslashes($_POST['dataUp']))."',
	  giorno='".mysql_real_escape_string($conn,stripslashes($_POST['giorno']))."',
	  anno='".mysql_real_escape_string($conn,stripslashes($_POST['anno']))."'
	  WHERE idAlbum='".$idAlbum."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['idR'])) {
      // salva nuovo indirizzo
	  $sql="UPDATE album_zone SET 
	  idR='".mysql_real_escape_string($conn,stripslashes($_POST['idR']))."',
	  idP='".mysql_real_escape_string($conn,stripslashes($_POST['idP']))."',
	  idC='".mysql_real_escape_string($conn,stripslashes($_POST['idC']))."',
	  idM='".mysql_real_escape_string($conn,stripslashes($_POST['idM']))."',
	  idQ='".mysql_real_escape_string($conn,stripslashes($_POST['idQ']))."'
	  WHERE idAlbum='".$idAlbum."'";
      $query=mysqli_query($conn,$sql);
}

print "<h4>Modifica album ID:".$idAlbum." - ";
$succ=$idAlbum+1; print "<a href='album.php?idAlbum=".$succ."'>Successivo</a> | ";
$prec=$idAlbum-1; print "<a href='album.php?idAlbum=".$prec."'>Precedente</a></h4>";

	 $sql="SELECT album.idAlbum,album,giorno,anno,dataUp,copertina,url,idR,idP,idC,idM,idQ
     FROM album,album_zone  
     WHERE album.idAlbum=album_zone.idAlbum 
     AND album.idAlbum='".$idAlbum."'";

	 $query=mysqli_query($conn,$sql);
	 $album=mysqli_fetch_array($query,MYSQLI_ASSOC);


// eliminare?
if (isset($_POST['rimoz'])) {
if ($_POST['rimoz']=="s") {
   $sql="DELETE FROM album WHERE idAlbum='".$idAlbum."'"; $query=mysqli_query($conn,$sql); 
   $sql="DELETE FROM album_zone WHERE idAlbum='".$idAlbum."'"; $query=mysqli_query($conn,$sql); 
   
   	 $sql="SELECT media.idMedia,img
     FROM media,media_link
     WHERE media.idMedia=media_link.idMedia
     AND media_link.idAlbum='".$idAlbum."'";
	 $query=mysqli_query($conn,$sql);
	 $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
	if ($row['img']!="") {
		$sql="UPDATE media_link SET
		idAlbum='0'
		WHERE idAlbum='".$idAlbum."'";
		$query=mysqli_query($conn,$sql);
		}

}

    // vai a seleziona
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='index.php';\n"; 
    echo "</script>"; 
}
     
?>

  <form id="albumPrincip" method="post" action="?idAlbum=<?php print $idAlbum; ?>"><p>
  <label>Titolo album</label><br /> <input type="text" size="50" name="album" value="<?php print $album['album']; ?>" /><br /><br />
  <label>Anno</label><br /> <input type="text" size="4" name="anno" value="<?php print $album['anno']; ?>" /><br /><br />
  <label>Data album</label><br /> <textarea name="giorno" rows="3" cols="40"><?php print $album['giorno']; ?></textarea><br /><br />
  <label>Data caricamento album [<strong>annommgg</strong>]</label><br /> <input type="text" size="15" name="dataUp" value="<?php print $album['dataUp']; ?>" /><br /><br />
  

<?php
print "<label>Regione</label>";
print "<select options='1' name='idR'>";
print "<option value='0'"; if ($album['idR']==0) { print " selected";} print ">TUTTA ITALIA + ESTERO</option>";
$sql_d="SELECT idR,regione FROM regioni ORDER BY regione ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idR']."'";
    if ($elenco['idR']==$album['idR']) { print " selected";}
    print ">".$elenco['regione']."</option>";
}
print "</select><br />";
if ($album['idR']==0) {
    print "<input type='hidden' name='idP' value='0'>";
    print "<input type='hidden' name='idC' value='0'>";
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($album['idR']>0) {
print "<label>Provincia</label>";
print "<select options='1' name='idP'>";
print "<option value='0'"; if ($album['idP']==0) { print " selected";} print ">TUTTE LE PROVINCE</option>";
$where=""; if ($rete['idR']>0) { $where="WHERE province.idR='".$album['idR']."'";} 
$sql_d="SELECT idP,provincia,sigla FROM province ".$where." ORDER BY provincia ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idP']."'";
    if ($elenco['idP']==$album['idP']) { print " selected";}
    print ">".$elenco['provincia']." (".$elenco['sigla'].") </option>";
}
print "</select><br />";
}
if ($album['idP']==0) {
    print "<input type='hidden' name='idC' value='0'>";
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($album['idP']>0) {
print "<label>Città (Prov)</label>";
print "<select options='1' name='idC'>";
print "<option value='0'"; if ($album['idC']==0) { print " selected";} print ">TUTTI I COMUNI</option>";
$where=""; if ($album['idP']>0) { $where="AND province.idP='".$album['idP']."'";} 
$sql_d="SELECT idC,comune,sigla FROM comuni,province WHERE comuni.idP=province.idP ".$where." ORDER BY comune ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elencoC=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elencoC['idC']."'";
    if ($elencoC['idC']==$album['idC']) { print " selected";}
    print ">".$elencoC['comune']." (".$elencoC['sigla'].") </option>";
    }
print "</select><br />";
}
if ($album['idC']==0 | $album['idC']!=25) {
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($album['idC']==25) {
print "<label>Municipio (Ge)</label>";
print "<select options='1' name='idM'>";
print "<option value='0'"; if ($album['idM']==0) { print " selected";} print ">TUTTI I MUNICIPI</option>";
$sql_d="SELECT idM,municipio FROM municipi ORDER BY municipio ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idM']."'";
    if ($elenco['idM']==$album['idM']) { print " selected";}
    print ">".$elenco['municipio']."</option>";
    }
print "</select><br />";
}
if ($album['idC']==25 && $album['idM']==0) {
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($album['idC']==25 && $album['idM']>0) {
print "<label>Quartiere (Ge)</label>";
print "<select options='1' name='idQ'>";
print "<option value='0'"; if ($album['idQ']==0) { print " selected";} print ">TUTTI I QUARTIERI</option>";
$where=""; if ($album['idM']>0) { $where=" AND quartieri.idM='".$album['idM']."'";} 
$sql_d="SELECT idQ,quartiere,municipio FROM quartieri,municipi WHERE quartieri.idM=municipi.idM ".$where." ORDER BY quartiere ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idQ']."'";
    if ($elenco['idQ']==$album['idQ']) { print " selected";}
    print ">".$elenco['quartiere']." (".$elenco['municipio'].")</option>";
    }
print "</select><br />";
}
?>    

  <label>Sito di riferimento</label><br /><input type="text" size="80" name="url" value="<?php print $album['url']; ?>" /><br /><br />


<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />



<?php
// LOCANDINA COLLEGATA
	 $sql="SELECT media.idMedia,img
     FROM media,media_link
     WHERE media.idMedia=media_link.idMedia
     AND media_link.idAlbum='".$idAlbum."'";
	 $query=mysqli_query($conn,$sql);
	 $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
if ($row['img']!="") {
print "<h3>Locandina collegata <a href='../media/locandina.php?idMedia=".$row['idMedia']."'>#".$row['idMedia']."</a></h3>";
print "formati thumb e icona<br /><img src='".$url."locandine/copertine/th_".$row['img']."' alt=''> ";
print "<img src='".$url."locandine/ico_".$row['img']."' alt=''><br />";
print "formato originale<br /><img src='".$url."locandine/".$row['img']."' alt=''><br />";
}
?>
  
  
<h3>Rimuovere album?</h3>
  <form id="rimuovialbum" method="post" action="?idAlbum=<?php print $idAlbum; ?>"><p>
  <select options="1" name="rimoz">
  <option value="n" selected>NO</option>
  <option value="s">SI, elimina tutti i dati</option>
  </select>
<br /><br />  
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />

