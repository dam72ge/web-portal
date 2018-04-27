<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../album">Album</a> | Crea NUOVO Album</h3>

<?php
if(isset($_POST['album'])){
    $sql = 
    "
    INSERT INTO album
    (idAlbum,album,copertina,url,anno,dataUp,giorno) 
    VALUES 
    ( 
    default,
    '".mysqli_real_escape_string($conn,stripslashes($_POST['album']))."',
    '0',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['url']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['anno']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['dataUp']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['giorno']))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovo=mysqli_insert_id($conn);

	// zone
    $sql = 
    "
    INSERT INTO album_zone
    (idAlbum,idR,idP,idC,idM,idQ) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idR']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idP']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idC']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idM']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idQ']))."'
    )";
    $query=mysqli_query($conn,$sql);

	// medialink
   $sql="UPDATE media_link SET
   idAlbum='".$idNuovo."'
   WHERE idMedia='".$_POST['idMedia']."'";
   $query=mysqli_query($conn,$sql);
   
    // vai a modifica
    echo "<script language=\"JavaScript\">\n";
    //echo "location.href='album.php?idAlbum=".$idNuovo."';\n"; 
    echo "</script>"; 
}



print "<h4>Crea NUOVO Album</h4>";
?>




  <form id="nuovoAlbum" method="post" enctype="multipart/form-data" action="?"><p>
  <label>Titolo album</label><br /> <input type="text" size="50" name="album" value="" /><br /><br />
  <label>Url (se immagini su sito esterno)</label><br /> <input type="text" size="50" name="url" value="" /><br /><br />
  <label>Anno</label><br /> <input type="text" size="4" name="anno" value="" /><br /><br />
  <label>Data album</label><br /> <textarea name="giorno" rows="2" cols="40"></textarea><br /><br />
  <label>Data caricamento [<strong>annommgg</strong>]</label><br /> <input type="text" size="15" name="dataUp" value="" /><br /><br />
  

<?php
print "<label>Regione</label>";
print "<select options='1' name='idR'>";
print "<option value='0'>TUTTA ITALIA + ESTERO</option>";
$sql_d="SELECT idR,regione FROM regioni ORDER BY regione ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idR']."'";
    if ($elenco['idR']=="1") { print " selected"; }
    print ">".$elenco['regione']."</option>";
}
print "</select><br />";
print "<label>Provincia</label>";
print "<select options='1' name='idP'>";
print "<option value='0'>TUTTE LE PROVINCE</option>";
$sql_d="SELECT idP,provincia,sigla FROM province ORDER BY provincia ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idP']."'";
    if ($elenco['idP']=="1") { print " selected"; }
    print ">".$elenco['provincia']." (".$elenco['sigla'].") </option>";
}
print "</select><br />";

print "<label>Citta' (Prov)</label>";
print "<select options='1' name='idC'>";
print "<option value='0'>TUTTI I COMUNI</option>";
$sql_d="SELECT idC,comune,sigla FROM comuni,province WHERE comuni.idP=province.idP ORDER BY comune ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idC']."'";
    if ($elenco['idC']=="25") { print " selected"; }
    print ">".$elenco['comune']." (".$elenco['sigla'].") </option>";
    }
print "</select><br />";

print "<label>Municipio (Ge)</label>";
print "<select options='1' name='idM'>";
print "<option value='0' selected>TUTTI I MUNICIPI</option>";
$sql_d="SELECT idM,municipio FROM municipi ORDER BY municipio ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idM']."'";
    print ">".$elenco['municipio']."</option>";
    }
print "</select><br />";

print "<label>Quartiere (Ge)</label>";
print "<select options='1' name='idQ'>";
print "<option value='0' selected>TUTTI I QUARTIERI</option>";
$sql_d="SELECT idQ,quartiere,municipio FROM quartieri,municipi WHERE quartieri.idM=municipi.idM ORDER BY quartiere ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idQ']."'";
    print ">".$elenco['quartiere']." (".$elenco['municipio'].")</option>";
    }
print "</select><br />";
?>    

<br/>
<label>Locandina collegata</label><br />
<?php
print "<select options='1' name='idMedia'>";
print "<option value='0' selected>NESSUNA</option>";
$sql_d="
SELECT idMedia,img
FROM media 
ORDER BY idMedia DESC
";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idMedia']."'>";
    print $elenco['idMedia'].") ".$elenco['img']."</option>";
}
print "</select><br /><br/>";

?>

<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />


