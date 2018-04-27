<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../video">video</a> | <a href="../video/seleziona.php">Seleziona video</a> | Modifica singolo video</h3>

<?php
// recupera dati da url
$idVideo=$_GET['idVideo'];

// modifica
if (isset($_POST['video'])) {
	  $sql="UPDATE video SET 
	  video='".mysqli_real_escape_string($conn,stripslashes($_POST['video']))."',
	  url='".mysqli_real_escape_string($conn,stripslashes($_POST['url']))."',
	  dataUp='".mysqli_real_escape_string($conn,stripslashes($_POST['dataUp']))."',
	  giorno='".mysqli_real_escape_string($conn,stripslashes($_POST['giorno']))."',
	  anno='".mysqli_real_escape_string($conn,stripslashes($_POST['anno']))."'
	  WHERE idVideo='".$idVideo."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['idR'])) {
      // salva nuovo indirizzo
	  $sql="UPDATE video_zone SET 
	  idR='".mysqli_real_escape_string($conn,stripslashes($_POST['idR']))."',
	  idP='".mysqli_real_escape_string($conn,stripslashes($_POST['idP']))."',
	  idC='".mysqli_real_escape_string($conn,stripslashes($_POST['idC']))."',
	  idM='".mysqli_real_escape_string($conn,stripslashes($_POST['idM']))."',
	  idQ='".mysqli_real_escape_string($conn,stripslashes($_POST['idQ']))."'
	  WHERE idVideo='".$idVideo."'";
      $query=mysqli_query($conn,$sql);
}

print "<h4>Modifica video ID:".$idVideo." - ";
$succ=$idVideo+1; print "<a href='video.php?idVideo=".$succ."'>Successivo</a> | ";
$prec=$idVideo-1; print "<a href='video.php?idVideo=".$prec."'>Precedente</a></h4>";

	 $sql="SELECT video.idVideo,video,giorno,anno,dataUp,url,idR,idP,idC,idM,idQ
     FROM video,video_zone  
     WHERE video.idVideo=video_zone.idVideo 
     AND video.idVideo='".$idVideo."'";

	 $query=mysqli_query($conn,$sql);
	 $video=mysqli_fetch_array($query,MYSQLI_ASSOC);


// eliminare?
if (isset($_POST['rimoz'])) {
if ($_POST['rimoz']=="s") {
   $sql="DELETE FROM video WHERE idVideo='".$idVideo."'"; $query=mysqli_query($conn,$sql); 
   $sql="DELETE FROM video_zone WHERE idVideo='".$idVideo."'"; $query=mysqli_query($conn,$sql); 
}
}
     
?>

  <form id="videoPrincip" method="post" action="?idVideo=<?php print $idVideo; ?>"><p>
  <label>Titolo video</label><br /> <input type="text" size="50" name="video" value="<?php print $video['video']; ?>" /><br /><br />
  <label>URL (codice youtube)</label><br /><input type="text" size="80" name="url" value="<?php print $video['url']; ?>" /><br /><br />

  <label>Anno</label><br /> <input type="text" size="4" name="anno" value="<?php print $video['anno']; ?>" /><br /><br />
  <label>Data video</label><br /> <textarea name="giorno" rows="3" cols="40"><?php print $video['giorno']; ?></textarea><br /><br />
  <label>Data caricamento video [<strong>annommgg</strong>]</label><br /> <input type="text" size="15" name="dataUp" value="<?php print $video['dataUp']; ?>" /><br /><br />
  

<?php
print "<label>Regione</label>";
print "<select options='1' name='idR'>";
print "<option value='0'"; if ($video['idR']==0) { print " selected";} print ">TUTTA ITALIA + ESTERO</option>";
$sql_d="SELECT idR,regione FROM regioni ORDER BY regione ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idR']."'";
    if ($elenco['idR']==$video['idR']) { print " selected";}
    print ">".$elenco['regione']."</option>";
}
print "</select><br />";
if ($video['idR']==0) {
    print "<input type='hidden' name='idP' value='0'>";
    print "<input type='hidden' name='idC' value='0'>";
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($video['idR']>0) {
print "<label>Provincia</label>";
print "<select options='1' name='idP'>";
print "<option value='0'"; if ($video['idP']==0) { print " selected";} print ">TUTTE LE PROVINCE</option>";
$where=""; if ($rete['idR']>0) { $where="WHERE province.idR='".$video['idR']."'";} 
$sql_d="SELECT idP,provincia,sigla FROM province ".$where." ORDER BY provincia ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idP']."'";
    if ($elenco['idP']==$video['idP']) { print " selected";}
    print ">".$elenco['provincia']." (".$elenco['sigla'].") </option>";
}
print "</select><br />";
}
if ($video['idP']==0) {
    print "<input type='hidden' name='idC' value='0'>";
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($video['idP']>0) {
print "<label>Città (Prov)</label>";
print "<select options='1' name='idC'>";
print "<option value='0'"; if ($video['idC']==0) { print " selected";} print ">TUTTI I COMUNI</option>";
$where=""; if ($video['idP']>0) { $where="AND province.idP='".$video['idP']."'";} 
$sql_d="SELECT idC,comune,sigla FROM comuni,province WHERE comuni.idP=province.idP ".$where." ORDER BY comune ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elencoC=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elencoC['idC']."'";
    if ($elencoC['idC']==$video['idC']) { print " selected";}
    print ">".$elencoC['comune']." (".$elencoC['sigla'].") </option>";
    }
print "</select><br />";
}
if ($video['idC']==0 | $video['idC']!=25) {
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($video['idC']==25) {
print "<label>Municipio (Ge)</label>";
print "<select options='1' name='idM'>";
print "<option value='0'"; if ($video['idM']==0) { print " selected";} print ">TUTTI I MUNICIPI</option>";
$sql_d="SELECT idM,municipio FROM municipi ORDER BY municipio ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idM']."'";
    if ($elenco['idM']==$video['idM']) { print " selected";}
    print ">".$elenco['municipio']."</option>";
    }
print "</select><br />";
}
if ($video['idC']==25 && $video['idM']==0) {
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($video['idC']==25 && $video['idM']>0) {
print "<label>Quartiere (Ge)</label>";
print "<select options='1' name='idQ'>";
print "<option value='0'"; if ($video['idQ']==0) { print " selected";} print ">TUTTI I QUARTIERI</option>";
$where=""; if ($video['idM']>0) { $where=" AND quartieri.idM='".$video['idM']."'";} 
$sql_d="SELECT idQ,quartiere,municipio FROM quartieri,municipi WHERE quartieri.idM=municipi.idM ".$where." ORDER BY quartiere ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idQ']."'";
    if ($elenco['idQ']==$video['idQ']) { print " selected";}
    print ">".$elenco['quartiere']." (".$elenco['municipio'].")</option>";
    }
print "</select><br />";
}
?>    


<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />


<h3>Anteprima</h3> <!-- http://www.youtube.com/watch?v=AosIEWroZxI, <iframe src="//www.youtube.com/embed/AosIEWroZxI" allowfullscreen></iframe> -->
<p>
<?php
$myobj->video($video['url']);
?>
</p>
<br /><br />
 
<?php
// LOCANDINA COLLEGATA
	 $sql="SELECT media.idMedia,img
     FROM media,media_link
     WHERE media.idMedia=media_link.idMedia
     AND media_link.idVideo='".$idVideo."'";
	 $query=mysqli_query($conn,$sql);
	 $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
if ($row['img']!="") {
print "<h3>Locandina collegata <a href='../media/locandina.php?idMedia=".$row['idMedia']."'>#".$row['idMedia']."</a></h3>";
print "<img src='".$url."locandine/copertine/th_".$row['img']."' alt=''><br/><br/>";
}
?>
 
  
<h3>Rimuovere video?</h3>
  <form id="rimuovivideo" method="post" action="?idVideo=<?php print $idVideo; ?>"><p>
  <select options="1" name="rimoz">
  <option value="n" selected>NO</option>
  <option value="s">SI, elimina tutti i dati</option>
  </select>
<br /><br />  
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />

