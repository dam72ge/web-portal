<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../reti">Reti</a> | <a href="../reti/seleziona.php">Seleziona rete</a> | Modifica singola Rete</h3>

<?php
// recupera dati da url
$idRete=$_GET['idRete'];

// immagine logo
if(isset($_FILES['newImg']['name'])){
   $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
   $urlCompleto=$url."reti/loghi/".$idRete.".".$ext;
   @rename($_FILES['newImg']['tmp_name'], $urlCompleto);
   $logo=$idRete.".".$ext;   
	  $sql="UPDATE reti SET 
	  logo='".mysqli_real_escape_string($conn,stripslashes($logo))."'
	  WHERE idRete='".$idRete."'";
      $query=mysqli_query($conn,$sql);

	  // crea thumb
	  $dirFile=$url."reti/loghi/"; //cartella
	  $myobj->creathumb($dirFile,$logo,250,250,$dirFile,"th_");
	  $myobj->creathumb($dirFile,$logo,48,48,$dirFile,"ico_");

    // ricarica pagina
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='rete.php?idRete=".$idRete."';\n"; 
    echo "</script>"; 
}

// modifica
if (isset($_POST['rete'])) {
	  $sql="UPDATE reti SET 
	  rete='".mysqli_real_escape_string($conn,stripslashes($_POST['rete']))."',
	  descriz='".mysqli_real_escape_string($conn,stripslashes($_POST['descriz']))."',
	  url='".mysqli_real_escape_string($conn,stripslashes($_POST['url']))."',
	  idSett='".mysqli_real_escape_string($conn,stripslashes($_POST['idSett']))."'
	  WHERE idRete='".$idRete."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['osc'])) {
	  $sql="UPDATE reti SET 
	  osc='".mysqli_real_escape_string($conn,stripslashes($_POST['osc']))."'
	  WHERE idRete='".$idRete."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['idR'])) {
      // salva nuovo indirizzo
	  $sql="UPDATE reti_zone SET 
	  idR='".mysqli_real_escape_string($conn,stripslashes($_POST['idR']))."',
	  idP='".mysqli_real_escape_string($conn,stripslashes($_POST['idP']))."',
	  idC='".mysqli_real_escape_string($conn,stripslashes($_POST['idC']))."',
	  idM='".mysqli_real_escape_string($conn,stripslashes($_POST['idM']))."',
	  idQ='".mysqli_real_escape_string($conn,stripslashes($_POST['idQ']))."'
	  WHERE idRete='".$idRete."'";
      $query=mysqli_query($conn,$sql);
}

print "<h4>Modifica Rete ID:".$idRete." - ";
$succ=$idRete+1; print "<a href='rete.php?idRete=".$succ."'>Successivo</a> | ";
$prec=$idRete-1; print "<a href='rete.php?idRete=".$prec."'>Precedente</a></h4>";

	 $sql="SELECT reti.idRete,rete,osc,descriz,url,logo,reti.idSett,idR,idP,idC,idM,idQ
     FROM reti,reti_settori,reti_zone
     WHERE reti.idSett=reti_settori.idSett 
     AND reti.idRete=reti_zone.idRete
     AND reti.idRete='".$idRete."'";
	 
	 $query=mysqli_query($conn,$sql);
	 $rete=mysqli_fetch_array($query,MYSQLI_ASSOC);

// eliminare?
if (isset($_POST['rimoz'])) {
if ($_POST['rimoz']=="s") {
   $urlFile=$url."reti/loghi/".$rete['logo'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."reti/loghi/th_".$rete['logo'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."reti/loghi/ico_".$rete['logo'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $sql="DELETE FROM reti WHERE idRete='".$idRete."'"; $query=mysqli_query($conn,$sql); 
   $sql="DELETE FROM reti_zone WHERE idRete='".$idRete."'"; $query=mysqli_query($conn,$sql); 
    // ricarica pagina
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='index.php';\n"; 
    echo "</script>"; 
}
}
     
// eliminare solo il logo?
if (isset($_POST['rimLogo'])) {
if ($_POST['rimLogo']=="s") {
   $urlFile=$url."reti/loghi/".$_POST['logo'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."reti/loghi/th_".$_POST['logo'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."reti/loghi/ico_".$_POST['logo'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
	  $sql="UPDATE reti SET 
	  logo=''
	  WHERE idRete='".$idRete."'";
      $query=mysqli_query($conn,$sql);
    // ricarica pagina
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='rete.php?idRete=".$idRete."';\n"; 
    echo "</script>"; 
}
}
     
?>

  <form id="retePrincip" method="post" action="?idRete=<?php print $rete['idRete']; ?>"><p>
  <label>Rete/Progetto/Laboratorio/...</label><br /> <input type="text" size="50" name="rete" value="<?php print $rete['rete']; ?>" /><br /><br />
  <label>Descrizione</label><br /> <textarea name="descriz" rows="3" cols="40"><?php print $rete['descriz']; ?></textarea><br /><br />
  <label>Sito di riferimento</label><br /><input type="text" size="80" name="url" value="<?php print $rete['url']; ?>" /><br /><br />


<?php
print "<label>Regione</label>";
print "<select options='1' name='idR'>";
print "<option value='0'"; if ($rete['idR']==0) { print " selected";} print ">TUTTA ITALIA + ESTERO</option>";
$sql_d="SELECT idR,regione FROM regioni ORDER BY regione ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idR']."'";
    if ($elenco['idR']==$rete['idR']) { print " selected";}
    print ">".$elenco['regione']."</option>";
}
print "</select><br />";
if ($rete['idR']==0) {
    print "<input type='hidden' name='idP' value='0'>";
    print "<input type='hidden' name='idC' value='0'>";
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($rete['idR']>0) {
print "<label>Provincia</label>";
print "<select options='1' name='idP'>";
print "<option value='0'"; if ($rete['idP']==0) { print " selected";} print ">TUTTE LE PROVINCE</option>";
$where=""; if ($rete['idR']>0) { $where="WHERE province.idR='".$rete['idR']."'";} 
$sql_d="SELECT idP,provincia,sigla FROM province ".$where." ORDER BY provincia ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idP']."'";
    if ($elenco['idP']==$rete['idP']) { print " selected";}
    print ">".$elenco['provincia']." (".$elenco['sigla'].") </option>";
}
print "</select><br />";
}
if ($rete['idP']==0) {
    print "<input type='hidden' name='idC' value='0'>";
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($rete['idP']>0) {
print "<label>Città (Prov)</label>";
print "<select options='1' name='idC'>";
print "<option value='0'"; if ($rete['idC']==0) { print " selected";} print ">TUTTI I COMUNI</option>";
$where=""; if ($rete['idP']>0) { $where="AND province.idP='".$rete['idP']."'";} 
$sql_d="SELECT idC,comune,sigla FROM comuni,province WHERE comuni.idP=province.idP ".$where." ORDER BY comune ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elencoC=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elencoC['idC']."'";
    if ($elencoC['idC']==$rete['idC']) { print " selected";}
    print ">".$elencoC['comune']." (".$elencoC['sigla'].") </option>";
    }
print "</select><br />";
}
if ($rete['idC']==0 | $rete['idC']!=25) {
    print "<input type='hidden' name='idM' value='0'>";
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($rete['idC']==25) {
print "<label>Municipio (Ge)</label>";
print "<select options='1' name='idM'>";
print "<option value='0'"; if ($rete['idM']==0) { print " selected";} print ">TUTTI I MUNICIPI</option>";
$sql_d="SELECT idM,municipio FROM municipi ORDER BY municipio ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idM']."'";
    if ($elenco['idM']==$rete['idM']) { print " selected";}
    print ">".$elenco['municipio']."</option>";
    }
print "</select><br />";
}
if ($rete['idC']==25 && $rete['idM']==0) {
    print "<input type='hidden' name='idQ' value='0'>";
}    

if ($rete['idC']==25 && $rete['idM']>0) {
print "<label>Quartiere (Ge)</label>";
print "<select options='1' name='idQ'>";
print "<option value='0'"; if ($rete['idQ']==0) { print " selected";} print ">TUTTI I QUARTIERI</option>";
$where=""; if ($rete['idM']>0) { $where=" AND quartieri.idM='".$rete['idM']."'";} 
$sql_d="SELECT idQ,quartiere,municipio FROM quartieri,municipi WHERE quartieri.idM=municipi.idM ".$where." ORDER BY quartiere ASC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idQ']."'";
    if ($elenco['idQ']==$rete['idQ']) { print " selected";}
    print ">".$elenco['quartiere']." (".$elenco['municipio'].")</option>";
    }
print "</select><br />";
}

?>    

<label>Settore di riferimento</label><br />
<select name="idSett" options="1" >
<?php
$sql_s="SELECT idSett,settore FROM reti_settori ORDER BY settore ASC";
$query_s=mysqli_query($conn,$sql_s); 
while($elencoS=mysqli_fetch_array($query_s,MYSQLI_ASSOC)){
    print "<option value='".$elencoS['idSett']."'";
    if ($elencoS['idSett']==$rete['idSett']) { print " selected";}
    print ">".$elencoS['settore']."</option>";
}
?>    
</select>
<br /><br />

<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />


  <form id="retiOsc" method="post" action="?idRete=<?php print $rete['idRete']; ?>"><p> 
  <label>Oscuramento</label><br />
  <select options="1" name="osc">
  <?php
  if ($rete['osc']=="n") {
    print "<option value='n' selected>Rete attiva</option><option value='s'>OSCURA questa Rete</option>";
	} else {
	print "<option value='s' selected>Rete OSCURATA</option><option value='n'>RIATTIVA questa Rete</option>";  }
  ?>
  </select>
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />


<?php
// MODIFICA LOGO ESISTENTE
if ($rete['logo']!="") {
print "<h3>Logo</h3>";
    	  // crea thumb
	  $dirFile=$url."reti/loghi/"; //cartella
      $copertina=$rete['logo'];
	  $myobj->creathumb($dirFile,$copertina,250,250,$dirFile,"th_");
	  $myobj->creathumb($dirFile,$copertina,48,48,$dirFile,"ico_");          
print "formati thumb e icona<br /><img src='".$url."reti/loghi/th_".$rete['logo']."' alt=''> ";
print "<img src='".$url."reti/loghi/ico_".$rete['logo']."' alt=''><br />";
print "formato originale<br /><img src='".$url."reti/loghi/".$rete['logo']."' alt=''><br />";
?>
  <form id="reteLogoCanc" method="post" action="?idRete=<?php print $rete['idRete']; ?>"><p>
  <select name="rimLogo" options="1">
  <option value="n" selected>Mantieni logo</option>
  <option value="s">RIMUOVI LOGO</option>
  </select>
  <input type="hidden" name="logo" value="<?php print $rete['logo']; ?>" />
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />
<?php
}
else{
?>
  <h3>Carica immagine logo</h3>
  <form id="reteLogo" method="post" enctype="multipart/form-data" action="?idRete=<?php print $rete['idRete']; ?>"><p>
  <label>Logo</label><br /><input type="file" name="newImg" value="<?php print $rete['logo']; ?>" /><br /><br />
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />
<?php
}
?>

<h3>Rimuovere questa Rete?</h3>
  <form id="rimuoviRete" method="post" action="?idRete=<?php print $idRete; ?>"><p>
  <label>Rimuovere?</label><br />
  <select options="1" name="rimoz">
  <option value="n" selected>NO</option>
  <option value="s">SI, elimina tutti i dati</option>
  </select>
<br /><br />  
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />

