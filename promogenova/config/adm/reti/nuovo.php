<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../reti">Reti</a> | <a href="../reti/seleziona.php">Seleziona rete</a> | AGGIUNGI NUOVA Rete</h3>

<?php
// aggiungi
if (isset($_POST['rete'])) {
    
    $sql = 
    "
    INSERT INTO reti
    (idRete,osc,rete,descriz,url,logo,idSett) 
    VALUES 
    ( 
    default,
    's',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['rete']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['descriz']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['url']))."',
    '',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idSett']))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovaRete=mysql_insert_id($conn);

if(isset($_FILES['newImg']['name'])){
   $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
   $urlCompleto=$url."reti/loghi/".$idNuovaRete.".".$ext;
   @rename($_FILES['newImg']['tmp_name'], $urlCompleto);
   $logo=$idNuovaRete.".".$ext;   
   $sql="UPDATE reti SET
   logo='".mysqli_real_escape_string($conn,stripslashes($logo))."'
   WHERE idRete='".$idNuovaRete."'";
   $query=mysqli_query($conn,$sql);
}

    $sql = 
    "
    INSERT INTO reti_zone
    (idRete,idR,idP,idC,idM,idQ) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovaRete))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idR']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idP']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idC']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idM']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idQ']))."'
    )";
    $query=mysqli_query($conn,$sql);

    // vai a modifica
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='rete.php?idRete=".$idNuovaRete."';\n"; 
    echo "</script>"; 
}


print "<h4>Aggiungi nuova Rete</h4>";
?>

  <form id="newRete" enctype="multipart/form-data" method="post" action="?>"><p>
  <label>Nome Rete/Progetto/Laboratorio/...</label><br /> <input type="text" size="50" name="rete" value="" /><br /><br />
  <label>Descrizione</label><br /> <textarea name="descriz" rows="3" cols="40"></textarea><br /><br />
  <label>Sito di riferimento</label><br /><input type="url" size="80" name="url" value="" /><br /><br />


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
    print "<option value='".$elenco['idM']."'>".$elenco['municipio']."</option>";
    }
print "</select><br />";

print "<label>Quartiere (Ge)</label>";
print "<select options='1' name='idQ'>";
print "<option value='0' selected>TUTTI I QUARTIERI</option>";
$sql_d="SELECT idQ,quartiere,municipio FROM quartieri,municipi WHERE quartieri.idM=municipi.idM ORDER BY quartiere ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idQ']."'>".$elenco['quartiere']." (".$elenco['municipio'].")</option>";
    }
print "</select><br />";
?>    
<br />

<label>Settore di riferimento</label><br />
<select name="idSett" options="1" >
<?php
$sql_s="SELECT idSett,settore FROM reti_settori ORDER BY settore ASC";
$query_s=mysqli_query($conn,$sql_s); 
while($elencoS=mysqli_fetch_array($query_s,MYSQLI_ASSOC)){
    print "<option value='".$elencoS['idSett']."'>".$elencoS['settore']."</option>";
}
?>    
</select>
<br /><br />

<label>Logo</label><br />
<input type="hidden" name="action" value="upload" />
<input id="file" type="file" size="0" name="newImg" value="" />";
<br /><br />

<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />


