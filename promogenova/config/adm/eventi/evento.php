<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../eventi">Eventi</a> | <a href="../eventi/seleziona.php">Seleziona eventi per data</a> | Modifica singolo Evento</h3>

<?php
// recupera dati da url
$id=$_GET['id'];

// nuova immagine locandina
if(isset($_FILES['newImg']['name'])){
	
   $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
   $urlTemp=$url."locandine/temp.".$ext;
   @rename($_FILES['newImg']['tmp_name'], $urlTemp);

	// aggiungi a media e medialink
    $sql = 
    "
    INSERT INTO media
    (idMedia,img) 
    VALUES 
    ( 
    default,
    ''
    )";
    $query=mysqli_query($conn,$sql);
   	$idNuovoMedia=mysqli_insert_id($conn);

    $sql = 
    "
    INSERT INTO media_link
    (idML,idMedia,id,idAlbum,idVideo) 
    VALUES 
    ( 
    default,
    '".$idNuovoMedia."',
    '".$id."',
    '0',
    '0'
    )";
    $query=mysqli_query($conn,$sql);

   //$ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
   $urlCompleto=$url."locandine/".$idNuovoMedia.".".$ext;
   //$urlTemp=$url."locandine/temp.".$ext;
   @rename($urlTemp, $urlCompleto);
   $locandina=$idNuovoMedia.".".$ext;   

	  $sql="UPDATE media SET 
	  img='".mysqli_real_escape_string($conn,stripslashes($locandina))."'
	  WHERE idMedia='".$idNuovoMedia."'";
      $query=mysqli_query($conn,$sql);

	  // crea thumb
	  $dirFile=$url."locandine/"; //cartella
	  $myobj->creathumb($dirFile,$locandina,250,250,$dirFile,"th_");
	  $myobj->creathumb($dirFile,$locandina,48,48,$dirFile,"ico_");
}

// modifica
if (isset($_POST['titolo'])) {
	  $sql="UPDATE eventi SET 
	  titolo='".mysqli_real_escape_string($conn,stripslashes($_POST['titolo']))."',
	  home='".mysqli_real_escape_string($conn,stripslashes($_POST['home']))."'
	  WHERE id='".$id."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['testo'])) {
	  $sql="UPDATE eventi_txt SET 
	  testo='".mysqli_real_escape_string($conn,stripslashes($_POST['testo']))."'
	  WHERE id='".$id."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['url'])) {
	  $sql="UPDATE eventi_link SET 
	  url='".mysqli_real_escape_string($conn,stripslashes($_POST['url']))."'
	  WHERE id='".$id."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['anno']) | isset($_POST['dataInizio']) | isset($_POST['dataFine'])) {
	  $sql="UPDATE eventi_dateore SET 
	  dataInizio='".mysqli_real_escape_string($conn,stripslashes($_POST['dataInizio']))."',
	  oreInizio='".mysqli_real_escape_string($conn,stripslashes($_POST['oreInizio']))."',
	  dataFine='".mysqli_real_escape_string($conn,stripslashes($_POST['dataFine']))."',
	  oreFine='".mysqli_real_escape_string($conn,stripslashes($_POST['oreFine']))."',
	  dataAvv='".mysqli_real_escape_string($conn,stripslashes($_POST['dataAvv']))."',
	  dataOsc='".mysqli_real_escape_string($conn,stripslashes($_POST['dataOsc']))."',
	  anno='".mysqli_real_escape_string($conn,stripslashes($_POST['anno']))."'
	  WHERE id='".$id."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['idR'])) {
      // salva nuovo indirizzo
	  $sql="UPDATE eventi_zone SET 
	  idR='".mysqli_real_escape_string($conn,stripslashes($_POST['idR']))."',
	  idP='".mysqli_real_escape_string($conn,stripslashes($_POST['idP']))."',
	  idC='".mysqli_real_escape_string($conn,stripslashes($_POST['idC']))."',
	  idM='".mysqli_real_escape_string($conn,stripslashes($_POST['idM']))."',
	  idQ='".mysqli_real_escape_string($conn,stripslashes($_POST['idQ']))."'
	  WHERE id='".$id."'";
      $query=mysqli_query($conn,$sql);
}

if (isset($_POST['idEvento'])) {
if ($_POST['rimozPromot']=="s") {
   $sql="DELETE FROM eventi_promot WHERE idEvento='".$_POST['idEvento']."'"; 
   $query=mysqli_query($conn,$sql);
   }
}
// addRete
if (isset($_POST['addRete'])) {
    $sql = 
    "
    INSERT INTO eventi_promot
    (idEvento,id,idAttivita,idRete) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($id))."',
    '0',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['addRete']))."'
    )";
    $query=mysqli_query($conn,$sql);
}
// addCliente
if (isset($_POST['addAttivita'])) {
    $sql = 
    "
    INSERT INTO eventi_promot
    (idEvento,id,idAttivita,idRete) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($id))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['addAttivita']))."',
    '0'
    )";
    $query=mysqli_query($conn,$sql);
}

print "<h4>Modifica Evento ID:".$id." - ";
$succ=$id+1; print "<a href='evento.php?id=".$succ."'>Successivo</a> | ";
$prec=$id-1; print "<a href='evento.php?id=".$prec."'>Precedente</a></h4>";

// carica dati
	 $sql="SELECT eventi.id,home,titolo,testo,anno,dataInizio,oreInizio,dataFine,oreFine,dataAvv,dataOsc,url,idR,idP,idC,idM,idQ
     FROM eventi,eventi_zone,eventi_link,eventi_promot,eventi_dateore,eventi_txt
     WHERE eventi.id=eventi_zone.id 
     AND eventi.id=eventi_txt.id
     AND eventi.id=eventi_dateore.id
     AND eventi.id=eventi_link.id 
     AND eventi.id='".$id."'";
	 $query=mysqli_query($conn,$sql);
	 $evento=mysqli_fetch_array($query,MYSQLI_ASSOC);

	 // recupera immagine e idMedia
	 $sql1="SELECT media.idMedia,media.img
     FROM eventi,media,media_link
     WHERE eventi.id=media_link.id
     AND media.idMedia=media_link.idMedia
     AND eventi.id='".$id."'";
	 $query1=mysqli_query($conn,$sql1);
	 $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
	 $idMedia=0; if ($row['idMedia']>=0) { $idMedia=$row['idMedia']; }   
	 $imgEvento=""; if ($row['img']!="") { $imgEvento=$row['img']; }   


// eliminare?
if (isset($_POST['rimoz'])) {
if ($_POST['rimoz']=="s") {
   $urlFile=$url."locandine/".$evento['img'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."locandine/th_".$evento['img'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."locandine/ico_".$evento['img'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $sql="DELETE FROM media WHERE idMedia='".$idMedia."'"; $query=mysqli_query($conn,$sql); 
   $sql="DELETE FROM media_link WHERE idMedia='".$idMedia."'"; $query=mysqli_query($conn,$sql); 
   $sql="DELETE FROM eventi WHERE id='".$id."'"; $query=mysqli_query($conn,$sql); 
   $sql="DELETE FROM eventi_txt WHERE id='".$id."'"; $query=mysqli_query($conn,$sql); 
   $sql="DELETE FROM eventi_dateore WHERE id='".$id."'"; $query=mysqli_query($conn,$sql); 
   $sql="DELETE FROM eventi_link WHERE id='".$id."'"; $query=mysqli_query($conn,$sql); 
   $sql="DELETE FROM eventi_promot WHERE id='".$id."'"; $query=mysqli_query($conn,$sql); 
   $sql="DELETE FROM eventi_zone WHERE id='".$id."'"; $query=mysqli_query($conn,$sql); 
    // ricarica pagina
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='index.php';\n"; 
    echo "</script>"; 
}
}
     
// eliminare solo la locandina?
if (isset($_POST['rimLoc'])) {
if ($_POST['rimLoc']=="s") {
   $urlFile=$url."locandine/".$_POST['img'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."locandine/th_".$_POST['img'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."locandine/ico_".$_POST['img'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
	  $sql="UPDATE media SET 
	  img=''
	  WHERE idMedia='".$idMedia."'";
      $query=mysqli_query($conn,$sql);
	  $sql="UPDATE media_link SET 
	  id='0'
	  WHERE idMedia='".$idMedia."'";
      $query=mysqli_query($conn,$sql);
    // ricarica pagina
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='evento.php?id=".$id."';\n"; 
    echo "</script>"; 
}
}
     
?>

  <form id="eventoPrincip" method="post" action="?id=<?php print $id; ?>"><p>
  <label>Titolo evento</label><br /> <input type="text" size="50" name="titolo" value="<?php print $evento['titolo']; ?>" /><br /><br />
  <label>Testo evento</label><br /> <textarea name="testo" rows="10" cols="40"><?php print $evento['testo']; ?></textarea><br /><br />
  <label>Anno</label><br /> <input type="text" size="4" name="anno" value="<?php print $evento['anno']; ?>" /><br /><br />
  <label>Data INIZIO [<strong>annommgg</strong>]</label> <input type="text" size="8" name="dataInizio" value="<?php print $evento['dataInizio']; ?>" /> 
  <label>Ore INIZIO [<strong>hh:mm</strong>]</label>  <input type="text" size="5" name="oreInizio" value="<?php print $evento['oreInizio']; ?>" /><br />
  <label>Data FINE [<strong>annommgg</strong>]</label> <input type="text" size="8" name="dataFine" value="<?php print $evento['dataFine']; ?>" /> 
  <label>Ore FINE [<strong>hh:mm</strong>]</label> <input type="text" size="5" name="oreFine" value="<?php print $evento['oreFine']; ?>" /><br /><br />
  <label>Data AVVISO (1 mese prima)</label> <input type="text" size="8" name="dataAvv" value="<?php print $evento['dataAvv']; ?>" /><br />
  <label>Data SCADENZA (1 mese dopo)</label> <input type="text" size="8" name="dataOsc" value="<?php print $evento['dataOsc']; ?>" /><br /><br />


<?php
print "<label>Regione</label>";
print "<select options='1' name='idR'>";
print "<option value='0'"; if ($evento['idR']==0) { print " selected";} print ">TUTTA ITALIA + ESTERO</option>";
$sql_d="SELECT idR,regione FROM regioni ORDER BY regione ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idR']."'";
    if ($elenco['idR']==$evento['idR']) { print " selected";}
    print ">".$elenco['regione']."</option>";
}
print "</select><br />";
if ($evento['idR']==0) {
    print "<input type='hidden' name='idP' value='0'>";
    print "<input type='hidden' name='idC' value='0'>";
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($evento['idR']>0) {
print "<label>Provincia</label>";
print "<select options='1' name='idP'>";
print "<option value='0'"; if ($evento['idP']==0) { print " selected";} print ">TUTTE LE PROVINCE</option>";
$where=""; if ($rete['idR']>0) { $where="WHERE province.idR='".$evento['idR']."'";} 
$sql_d="SELECT idP,provincia,sigla FROM province ".$where." ORDER BY provincia ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idP']."'";
    if ($elenco['idP']==$evento['idP']) { print " selected";}
    print ">".$elenco['provincia']." (".$elenco['sigla'].") </option>";
}
print "</select><br />";
}
if ($evento['idP']==0) {
    print "<input type='hidden' name='idC' value='0'>";
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($evento['idP']>0) {
print "<label>Città (Prov)</label>";
print "<select options='1' name='idC'>";
print "<option value='0'"; if ($evento['idC']==0) { print " selected";} print ">TUTTI I COMUNI</option>";
$where=""; if ($evento['idP']>0) { $where="AND province.idP='".$evento['idP']."'";} 
$sql_d="SELECT idC,comune,sigla FROM comuni,province WHERE comuni.idP=province.idP ".$where." ORDER BY comune ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elencoC=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elencoC['idC']."'";
    if ($elencoC['idC']==$evento['idC']) { print " selected";}
    print ">".$elencoC['comune']." (".$elencoC['sigla'].") </option>";
    }
print "</select><br />";
}
if ($evento['idC']==0 | $evento['idC']!=25) {
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($evento['idC']==25) {
print "<label>Municipio (Ge)</label>";
print "<select options='1' name='idM'>";
print "<option value='0'"; if ($evento['idM']==0) { print " selected";} print ">TUTTI I MUNICIPI</option>";
$sql_d="SELECT idM,municipio FROM municipi ORDER BY municipio ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idM']."'";
    if ($elenco['idM']==$evento['idM']) { print " selected";}
    print ">".$elenco['municipio']."</option>";
    }
print "</select><br />";
}
if ($evento['idC']==25 && $evento['idM']==0) {
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($evento['idC']==25 && $evento['idM']>0) {
print "<label>Quartiere (Ge)</label>";
print "<select options='1' name='idQ'>";
print "<option value='0'"; if ($evento['idQ']==0) { print " selected";} print ">TUTTI I QUARTIERI</option>";
$where=""; if ($evento['idM']>0) { $where=" AND quartieri.idM='".$evento['idM']."'";} 
$sql_d="SELECT idQ,quartiere,municipio FROM quartieri,municipi WHERE quartieri.idM=municipi.idM ".$where." ORDER BY quartiere ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idQ']."'";
    if ($elenco['idQ']==$evento['idQ']) { print " selected";}
    print ">".$elenco['quartiere']." (".$elenco['municipio'].")</option>";
    }
print "</select><br />";
}
?>    

<br /><br />
  <label>In HOMEPAGE su Promogenova?</label><br />
  <select options="1" name="home">
  <?php
  if ($evento['home']=="n") {
    print "<option value='n' selected>NO</option><option value='s'>METTI in Homepage</option>";
	} else {
	print "<option value='s' selected>SI</option><option value='n'>TOGLI da Homepage</option>";  }
  ?>
  </select>
<br /><br />  
  <label>Sito di riferimento</label><br /><input type="text" size="80" name="url" value="<?php print $evento['url']; ?>" /><br /><br />


<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />


<h3>Promotori evento / Rete</h3>
<?php
$sql_ps="
SELECT reti.idRete,rete,idEvento 
FROM reti,eventi_promot
WHERE reti.idRete=eventi_promot.idRete 
AND eventi_promot.id='".$id."'
ORDER BY rete ASC
";
$query_ps=mysqli_query($conn,$sql_ps); 
while($elenco_ps=mysqli_fetch_array($query_ps,MYSQLI_ASSOC)){
    print "<form id='elPromotCl_".$elenco_ps['idEvento']."' method='post' action='?id=".$id."'>";
    print "<input type='hidden' name='idEvento' value='".$elenco_ps['idEvento']."'>";
    print "<input type='hidden' name='idRete' value='".$elenco_ps['idRete']."'>";
    print "<input type='text' size='30' name='rete' value='".$elenco_ps['rete']."' disabled='yes'> ";
    print "<select name='rimozPromot' option='1'>";
    print "<option value='n' selected>mantieni</option>";
    print "<option value='s' >RIMUOVI</option>";
    print "</select>";
    print " <input type='submit' name='salva' value='SALVA' />";
    print "</form>";
}
    print "<em>Aggiungi rete</em><br /><form id='newPromotCl' method='post' action='?id=".$id."'>";
    print "<select name='addRete' option='1'>";
$sql_add="
SELECT reti.idRete,rete
FROM reti
ORDER BY rete ASC
";
$query_add=mysqli_query($conn,$sql_add); 
while($add=mysqli_fetch_array($query_add,MYSQLI_ASSOC)){
    print "<option value='".$add['idRete']."'>".$add['rete']."</option>";
}
    print "</select>";
    print " <input type='submit' name='salva' value='SALVA' />";
    print "</form>";

?>    
<br /><br />



<h3>Promotori evento / Attivita</h3>
<?php
$sql_ps="
SELECT attivita.idAttivita,attivita,idEvento 
FROM attivita,eventi_promot
WHERE attivita.idAttivita=eventi_promot.idAttivita 
AND eventi_promot.id='".$id."'
ORDER BY attivita ASC
";
$query_ps=mysqli_query($conn,$sql_ps); 
while($elenco_ps=mysqli_fetch_array($query_ps,MYSQLI_ASSOC)){
    print "<form id='elPromotCl_".$elenco_ps['idEvento']."' method='post' action='?id=".$id."'>";
    print "<input type='hidden' name='idEvento' value='".$elenco_ps['idEvento']."'>";
    print "<input type='hidden' name='idAttivita' value='".$elenco_ps['idAttivita']."'>";
    print "<input type='text' size='30' name='attivita' value='".$elenco_ps['attivita']."' disabled='yes'> ";
    print "<select name='rimozPromot' option='1'>";
    print "<option value='n' selected>mantieni</option>";
    print "<option value='s' >RIMUOVI</option>";
    print "</select>";
    print " <input type='submit' name='salva' value='SALVA' />";
    print "</form>";
}
    print "<em>Aggiungi rete</em><br /><form id='newPromotCl' method='post' action='?id=".$id."'>";
    print "<select name='addAttivita' option='1'>";
$sql_add="
SELECT attivita.idAttivita,attivita
FROM attivita
ORDER BY attivita ASC
";
$query_add=mysqli_query($conn,$sql_add); 
while($add=mysqli_fetch_array($query_add,MYSQLI_ASSOC)){
    print "<option value='".$add['idAttivita']."'>".$add['attivita']."</option>";
}
    print "</select>";
    print " <input type='submit' name='salva' value='SALVA' />";
    print "</form>";

?>    
<br /><br />


<?php
// MODIFICA LOCANDINA
if ($imgEvento!="" && $idMedia>0) {
print "<h3>Locandina <a href='../media/locandina.php?idMedia=".$idMedia."'>#".$idMedia."</a></h3>";
    	  // crea thumb
	  $dirFile=$url."locandine/"; //cartella
      $copertina=$imgEvento;
	  $myobj->creathumb($dirFile,$copertina,250,250,$dirFile,"th_");
	  $myobj->creathumb($dirFile,$copertina,48,48,$dirFile,"ico_");
          
print "formati thumb e icona<br /><img src='".$url."locandine/th_".$imgEvento."' alt=''> ";
print "<img src='".$url."locandine/ico_".$imgEvento."' alt=''><br />";
print "formato originale<br /><img src='".$url."locandine/".$imgEvento."' alt=''><br />";
?>
  <form id="imgLocandCanc" method="post" action="?id=<?php print $id; ?>"><p>
  <select name="rimLoc" options="1">
  <option value="n" selected>Mantieni locandina</option>
  <option value="s">RIMUOVI LOCANDINA</option>
  </select>
  <input type="hidden" name="img" value="<?php print $imgEvento; ?>" />
  <input type="hidden" name="idMedia" value="<?php print $idMedia; ?>" />
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />

<?php
}
else{
?>
  <h3>Carica immagine locandina</h3>

  <form id="eventoLocandina" method="post" enctype="multipart/form-data" action="?id=<?php print $id; ?>"><p>
  <label>Locandina</label><br /><input type="file" name="newImg" value="" /><br /><br />
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />
<?php
}
?>  
  
  
<h3>Rimuovere evento?</h3>
  <form id="rimuoviEvento" method="post" action="?id=<?php print $id; ?>"><p>
  <select options="1" name="rimoz">
  <option value="n" selected>NO</option>
  <option value="s">SI, elimina tutti i dati</option>
  </select>
<br /><br />  
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />

