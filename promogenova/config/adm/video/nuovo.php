<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../video">Video</a> | Aggiungi NUOVO Video</h3>

<?php
if(isset($_POST['video'])){
    $sql = 
    "
    INSERT INTO video
    (idVideo,video,url,anno,dataUp,giorno) 
    VALUES 
    ( 
    default,
    '".mysql_real_escape_string(stripslashes($_POST['video']))."',
    '".mysql_real_escape_string(stripslashes($_POST['url']))."',
    '".mysql_real_escape_string(stripslashes($_POST['anno']))."',
    '".mysql_real_escape_string(stripslashes($_POST['dataUp']))."',
    '".mysql_real_escape_string(stripslashes($_POST['giorno']))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovo=mysqli_insert_id($conn);
}

if(isset($_POST['idR'])){
    $sql = 
    "
    INSERT INTO video_zone
    (idVideo,idR,idP,idC,idM,idQ) 
    VALUES 
    ( 
    '".mysql_real_escape_string(stripslashes($idNuovo))."',
    '".mysql_real_escape_string(stripslashes($_POST['idR']))."',
    '".mysql_real_escape_string(stripslashes($_POST['idP']))."',
    '".mysql_real_escape_string(stripslashes($_POST['idC']))."',
    '".mysql_real_escape_string(stripslashes($_POST['idM']))."',
    '".mysql_real_escape_string(stripslashes($_POST['idQ']))."'
    )";
    $query=mysqli_query($conn,$sql);
}

print "<h4>Crea NUOVO Video</h4>";
?>




  <form id="nuovoVideo" method="post" action="?"><p>
  <label>Titolo video</label><br /> <input type="text" size="50" name="video" value="" /><br /><br />
  <label>Url (codice YouTube)</label><br /> <input type="text" size="50" name="url" value="" /><br /><br />
  <label>Anno</label><br /> <input type="text" size="4" name="anno" value="" /><br /><br />
  <label>Data video</label><br /> <textarea name="giorno" rows="3" cols="40"></textarea><br /><br />
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

print "<label>Città (Prov)</label>";
print "<select options='1' name='idC'>";
print "<option value='0' selected>TUTTI I COMUNI</option>";
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


<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />


