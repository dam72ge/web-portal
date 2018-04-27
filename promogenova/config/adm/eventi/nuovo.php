<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../eventi">Eventi</a> | Crea NUOVO Evento</h3>

<?php
if(isset($_POST['titolo'])){
    $sql = 
    "
    INSERT INTO eventi
    (id,home,titolo,img) 
    VALUES 
    ( 
    '',
    '".mysql_real_escape_string(stripslashes($_POST['home']))."',
    '".mysql_real_escape_string(stripslashes($_POST['titolo']))."',
    ''
    )";
    $query=mysql_query($sql);

    // id nuovo
   	$idNuovoEvento=mysql_insert_id();
    //print $idNuovoEvento; exit;
}
if(isset($_FILES['newImg']['name'])){
   $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
   $urlCompleto=$url."locandine/".$idNuovoEvento.".".$ext;
   @rename($_FILES['newImg']['tmp_name'], $urlCompleto);
   $locandina=$idNuovoEvento.".".$ext;   

	// aggiungi a media e medialink
    $sql = 
    "
    INSERT INTO media
    (idMedia,img) 
    VALUES 
    ( 
    '',
    '".mysql_real_escape_string(stripslashes($locandina))."'
    )";
    $query=mysql_query($sql);
   	$idNuovoMedia=mysql_insert_id();

    $sql = 
    "
    INSERT INTO media_link
    (idML,idMedia,id,idAlbum,idVideo) 
    VALUES 
    ( 
    '',
    '".$idNuovoMedia."',
    '".$idNuovoEvento."',
    '0',
    '0'
    )";
    $query=mysql_query($sql);

/*
   $sql="UPDATE eventi SET
   img='".mysql_real_escape_string(stripslashes($locandina))."'
   WHERE id='".$idNuovoEvento."'";
   $query=mysql_query($sql);
*/
	  // crea thumb
	  $dirFile=$url."locandine/"; //cartella
	  $myobj->creathumb($dirFile,$locandina,250,250,$dirFile,"th_");
	  $myobj->creathumb($dirFile,$locandina,48,48,$dirFile,"ico_");
}
if (isset($_POST['testo'])) {
    $sql = 
    "
    INSERT INTO eventi_txt
    (id,testo) 
    VALUES 
    ( 
    '".mysql_real_escape_string(stripslashes($idNuovoEvento))."',
    '".mysql_real_escape_string(stripslashes($_POST['testo']))."'
    )";
    $query=mysql_query($sql);
}
if (isset($_POST['url'])) {
    $sql = 
    "
    INSERT INTO eventi_link
    (id,url) 
    VALUES 
    ( 
    '".mysql_real_escape_string(stripslashes($idNuovoEvento))."',
    '".mysql_real_escape_string(stripslashes($_POST['url']))."'
    )";
    $query=mysql_query($sql);
}
if (isset($_POST['dataInizio']) | isset($_POST['dataFine'])) {
// estrai anno (da dataFine)
$anno=substr($_POST['dataFine'],0,4);

// calcola date avviso (1 mese prima) e scadenza (1 mese dopo)
$dataIn=$_POST['dataInizio'];   
$ggIn=substr($dataIn,6,2); $mmIn=substr($dataIn,4,2); $aaIn=substr($dataIn,0,4);
$dataFine=$_POST['dataFine'];   
$ggF=substr($dataFine,6,2); $mmF=substr($dataFine,4,2); $aaF=substr($dataFine,0,4);
$ev_anno=$aaF;

$ggAvv=$ggIn; $mmAvv=$mmIn-1; $aaAvv=$aaIn;
if ($mmAvv<=0){ $mmAvv=12; $aaAvv=$aaIn-1;}     
$i1=""; if ($mmIn!=$mmAvv && $mmAvv<10){ $i1="0"; }
$i2=""; if ($ggIn!=$ggAvv && $ggAvv<10){ $i2="0"; }
$newDataAvv=$aaAvv.$i1.$mmAvv.$i2.$ggAvv;

$ggOsc=$ggF; $mmOsc=$mmF+1; $aaOsc=$aaF;
if ($mmOsc>12){ $mmOsc=1; $aaOsc=$aaF+1;}  
$i1=""; if ($mmF!=$mmOsc && $mmOsc<10){ $i1="0"; }
$i2=""; if ($ggF!=$ggOsc && $ggOsc<10){ $i2="0"; }
$newDataOsc=$aaOsc.$i1.$mmOsc.$ggOsc;

    $sql = 
    "
    INSERT INTO eventi_dateore
    (id,anno,dataInizio,oreInizio,dataFine,oreFine,dataAvv,dataOsc) 
    VALUES 
    ( 
    '".mysql_real_escape_string(stripslashes($idNuovoEvento))."',
    '".mysql_real_escape_string(stripslashes($anno))."',
    '".mysql_real_escape_string(stripslashes($_POST['dataInizio']))."',
    '".mysql_real_escape_string(stripslashes($_POST['oreInizio']))."',
    '".mysql_real_escape_string(stripslashes($_POST['dataFine']))."',
    '".mysql_real_escape_string(stripslashes($_POST['oreFine']))."',
    '".mysql_real_escape_string(stripslashes($newDataAvv))."',
    '".mysql_real_escape_string(stripslashes($newDataOsc))."'
    )";
    $query=mysql_query($sql);
}
if(isset($_POST['idR'])){
    $sql = 
    "
    INSERT INTO eventi_zone
    (id,idR,idP,idC,idM,idQ) 
    VALUES 
    ( 
    '".mysql_real_escape_string(stripslashes($idNuovoEvento))."',
    '".mysql_real_escape_string(stripslashes($_POST['idR']))."',
    '".mysql_real_escape_string(stripslashes($_POST['idP']))."',
    '".mysql_real_escape_string(stripslashes($_POST['idC']))."',
    '".mysql_real_escape_string(stripslashes($_POST['idM']))."',
    '".mysql_real_escape_string(stripslashes($_POST['idQ']))."'
    )";
    $query=mysql_query($sql);

    // vai a modifica
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='evento.php?id=".$idNuovoEvento."';\n"; 
    echo "</script>"; 
}

print "<h4>Crea NUOVO Evento</h4>";
?>

  <form id="nuovoEvento" method="post" enctype="multipart/form-data" action="?"><p>
  <label>Titolo evento</label><br /> <input type="text" size="50" name="titolo" value="" /><br /><br />
  <label>Testo evento</label><br /> <textarea name="testo" rows="10" cols="40"></textarea><br /><br />

  <label>Data INIZIO [<strong>annommgg</strong>]</label> <input type="text" size="8" name="dataInizio" value="" />
  <label>Ore INIZIO</label>
  <select name="oreInizio" options="1">
  <option value="00:00" selected>00:00</option>
  <?php
    for ($i=1;$i<24;$i++) {
        $i1=""; if ($i<10) { $i1="0"; } 
        print "<option value='".$i1.$i.":00'>".$i1.$i.":00</option>";
        print "<option value='".$i1.$i.":30'>".$i1.$i.":30</option>";
    }
  ?>
  </select>
  <br />
  
  <label>Data FINE [<strong>annommgg</strong>]</label> <input type="text" size="8" name="dataFine" value="" /> 
  <label>Ore FINE</label>
  <select name="oreFine" options="1">
  <option value="00:00" selected>00:00</option>
  <?php
    for ($i=1;$i<24;$i++) {
        $i1=""; if ($i<10) { $i1="0"; } 
        print "<option value='".$i1.$i.":00'>".$i1.$i.":00</option>";
        print "<option value='".$i1.$i.":30'>".$i1.$i.":30</option>";
    }
  ?>
  </select>
  <br /><br />
  


<?php
print "<label>Regione</label>";
print "<select options='1' name='idR'>";
print "<option value='0' selected>TUTTA ITALIA + ESTERO</option>";
$sql_d="SELECT idR,regione FROM regioni ORDER BY regione ASC";
$query_d=mysql_query($sql_d); 
while($elenco=mysql_fetch_array($query_d)){
    print "<option value='".$elenco['idR']."'";
    if ($elenco['idR']=="1") { print " selected"; }
    print ">".$elenco['regione']."</option>";
}
print "</select><br />";
print "<label>Provincia</label>";
print "<select options='1' name='idP'>";
print "<option value='0' selected>TUTTE LE PROVINCE</option>";
$sql_d="SELECT idP,provincia,sigla FROM province ORDER BY provincia ASC";
$query_d=mysql_query($sql_d); 
while($elenco=mysql_fetch_array($query_d)){
    print "<option value='".$elenco['idP']."'";
    if ($elenco['idP']=="1") { print " selected"; }
    print ">".$elenco['provincia']." (".$elenco['sigla'].") </option>";
}
print "</select><br />";

print "<label>Città (Prov)</label>";
print "<select options='1' name='idC'>";
print "<option value='0' selected>TUTTI I COMUNI</option>";
$sql_d="SELECT idC,comune,sigla FROM comuni,province WHERE comuni.idP=province.idP ORDER BY comune ASC";
$query_d=mysql_query($sql_d); 
while($elenco=mysql_fetch_array($query_d)){
    print "<option value='".$elenco['idC']."'";
    if ($elenco['idC']=="25") { print " selected"; }
    print ">".$elenco['comune']." (".$elenco['sigla'].") </option>";
    }
print "</select><br />";

print "<label>Municipio (Ge)</label>";
print "<select options='1' name='idM'>";
print "<option value='0' selected>TUTTI I MUNICIPI</option>";
$sql_d="SELECT idM,municipio FROM municipi ORDER BY municipio ASC";
$query_d=mysql_query($sql_d); 
while($elenco=mysql_fetch_array($query_d)){
    print "<option value='".$elenco['idM']."'";
    print ">".$elenco['municipio']."</option>";
    }
print "</select><br />";

print "<label>Quartiere (Ge)</label>";
print "<select options='1' name='idQ'>";
print "<option value='0' selected>TUTTI I QUARTIERI</option>";
$sql_d="SELECT idQ,quartiere,municipio FROM quartieri,municipi WHERE quartieri.idM=municipi.idM ORDER BY quartiere ASC";
$query_d=mysql_query($sql_d); 
while($elenco=mysql_fetch_array($query_d)){
    print "<option value='".$elenco['idQ']."'";
    print ">".$elenco['quartiere']." (".$elenco['municipio'].")</option>";
    }
print "</select><br />";
?>    

<br /><br />
  <label>In HOMEPAGE su Promogenova?</label><br />
  <select options="1" name="home">
  <?php
    print "<option value='n' selected>NO</option><option value='s'>Sì, METTILO in Homepage</option>";
  ?>
  </select>
<br /><br />  

  <label>Sito di riferimento</label><br /><input type="text" size="80" name="url" value="" /><br /><br />


<label>Locandina</label><br />
<input type="file" name="newImg" value="" /><br /><br />


<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />


