<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../attivita">Attivita'</a> | <a href="../attivita/seleziona.php">Seleziona attivita'</a> | Modifica singolo</h3>

<?php
// recupera dati da url
$id=$_GET['id'];

// modifiche
if (isset($_POST['attivita'])) {
      $attivita=$_POST['attivita'];
	  $sql="UPDATE attivita SET 
	  attivita='".mysqli_real_escape_string($conn,stripslashes($attivita))."'
	  WHERE idAttivita='".$id."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['osc'])) {
      $osc=$_POST['osc'];
	  $sql="UPDATE att_scad SET 
	  osc='".mysqli_real_escape_string($conn,stripslashes($osc))."'
	  WHERE idAttivita='".$id."'";
      $query=mysqli_query($conn,$sql);
}
if (isset($_POST['utente'])) {
	  $sql="UPDATE att_clienti SET 
	  utente='".mysqli_real_escape_string($conn,stripslashes($_POST['utente']))."',
	  vetrOmaggio='".mysqli_real_escape_string($conn,stripslashes($_POST['vetrOmaggio']))."',
	  assistPeriod='".mysqli_real_escape_string($conn,stripslashes($_POST['assistPeriod']))."',
	  creaEventi='".mysqli_real_escape_string($conn,stripslashes($_POST['creaEventi']))."',
	  creaPromo='".mysqli_real_escape_string($conn,stripslashes($_POST['creaPromo']))."'
	  WHERE idAttivita='".$id."'";
      $query=mysqli_query($conn,$sql);
}

if (isset($_POST['newCart'])) {
      $oldCart=$_POST['oldCart']; $urlOld=$url.$oldCart;
      $newCart=$_POST['newCart']; $urlNew=$url.$newCart;
      rename($urlOld,$urlNew);
	  $sql="UPDATE vetrine SET 
	  cartella='".mysqli_real_escape_string($conn,stripslashes($newCart))."'
	  WHERE idAttivita='".$id."'";
      $query=mysqli_query($conn,$sql);
}

if (isset($_POST['ragsoc'])) {
	  $sql="UPDATE att_ragsoc SET 
	  ragsoc='".mysqli_real_escape_string($conn,stripslashes($_POST['ragsoc']))."',
	  partitaiva='".mysqli_real_escape_string($conn,stripslashes($_POST['partitaiva']))."',
	  codfisc='".mysqli_real_escape_string($conn,stripslashes($_POST['codfisc']))."'
	  WHERE idAttivita='".$id."'";
      $query=mysqli_query($conn,$sql);
}

if (isset($_POST['telefono'])) {
      $telefono=$_POST['telefono'];
      $email=$_POST['email'];
      $nota=$_POST['nota'];
	  $sql="UPDATE att_clienti_contatti SET 
	  telefono='".mysqli_real_escape_string($conn,stripslashes($telefono))."',
	  email='".mysqli_real_escape_string($conn,stripslashes($email))."',
	  nota='".mysqli_real_escape_string($conn,stripslashes($nota))."'
	  WHERE idAttivita='".$id."'";
      $query=mysqli_query($conn,$sql);
}


// DATE AVVISI E SCADENZA
$msgData="";
if (isset($_POST['oldOsc'])) {
$newAAscad=$_POST['newAAscad'];
$newMMscad=$_POST['newMMscad'];
$newGGscad=$_POST['newGGscad'];
$oldScad=$_POST['oldScad'];
$newAAavv=$_POST['newAAavv']; 
$newMMavv=$_POST['newMMavv'];
$newGGavv=$_POST['newGGavv'];
$oldAvv=$_POST['oldScad'];
$newAAosc=$_POST['newAAosc']; 
$newMMosc=$_POST['newMMosc'];
$newGGosc=$_POST['newGGosc'];
$oldOsc=$_POST['oldOsc'];
$dataReg=$_POST['dataReg'];

// controlla data
   $newData=$newAAscad.$newMMscad.$newGGscad;
   if($newData<=$dataReg){
   $msgData="Nuova data non valida, perché precedente alla data di registrazione!";   
   }
   if($newMMscad<=0 | $newMMscad>12){
   $msgData="Nuova data non valida: MESE non corretto";   
   }
   if($newGGscad<=0 | $newGGscad>31){
   $msgData="Nuova data non valida: GIORNO non corretto";   
   }

// crea nuova data avviso scadenza (2 settimane prima)   
	$ggAvv=$newGGscad-14; $mmAvv=$newMMscad; $aaAvv=$newAAscad;
	if ($ggAvv<=0){ 
	$ggAvv=(31+$ggAvv)-15; 
	$mmAvv=$newMMscad-1;
	if ($mmAvv<=0){ $mmAvv=12; $aaAvv=$newAAscad-1;} 
	}	
	$i1=""; if ($newMMscad!=$mmAvv && $mmAvv<10){ $i1="0"; }
	$i2=""; if ($newGGscad!=$ggAvv && $ggAvv<10){ $i2="0"; }
    $newDataAvv=$aaAvv.$i1.$mmAvv.$i2.$ggAvv;

// crea nuova data oscuramento definitivo: 1 mese dopo la scadenza
	$ggOsc=$newGGscad; $mmOsc=$newMMscad+1; $aaOsc=$newAAscad;
	if ($mmOsc>12){ $mmOsc=1; $aaOsc=$newAAscad+1;}  
	$i1=""; if ($newMMscad!=$mmOsc && $mmOsc<10){ $i1="0"; }
	$i2=""; if ($newGGscad!=$ggOsc && $ggOsc<10){ $i2="0"; }
    $newDataOsc=$aaOsc.$i1.$mmOsc.$ggOsc;

   if($msgData==""){
	  $sql="UPDATE att_scad SET 
	  dataScad='".mysqli_real_escape_string($conn,stripslashes($newData))."',
	  dataAvv='".mysqli_real_escape_string($conn,stripslashes($newDataAvv))."',
	  dataOsc='".mysqli_real_escape_string($conn,stripslashes($newDataOsc))."'
	  WHERE idAttivita='".$id."'";
      $query=mysqli_query($conn,$sql);
   }

}
if (isset($_POST['indirizzo'])) {
      $indirizzo=$_POST['indirizzo'];
      $nciv=$_POST['nciv'];
      $cap=$_POST['cap'];
      $idQ=$_POST['idQ'];
      $idC=$_POST['idC'];
      $altro=$_POST['altro'];
      // zone
      $idM=0;
      if ($idQ>0) { 
      //$idR=1; $idP=1; $idC=25; 
            $sql_d="SELECT idM FROM quartieri WHERE idQ='".$idQ."'"; 
            $query_d=mysql_query($sql_d); 
            $dove=mysql_fetch_array($query_d); 
            $idM=$dove['idM']; 
      } 
            $sql_d="SELECT idP FROM comuni WHERE idC='".$idC."'"; 
            $query_d=mysql_query($sql_d); 
            $dove=mysql_fetch_array($query_d); 
            $idP=$dove['idP']; 
            $sql_d="SELECT idR FROM province WHERE idP='".$idP."'"; 
            $query_d=mysql_query($sql_d); 
            $dove=mysql_fetch_array($query_d); 
            $idR=$dove['idR']; 
      // salva nuovo indirizzo
	  $sql="UPDATE att_indirizzi SET 
	  indirizzo='".mysqli_real_escape_string($conn,stripslashes($indirizzo))."',
	  nciv='".mysqli_real_escape_string($conn,stripslashes($nciv))."',
	  cap='".mysqli_real_escape_string($conn,stripslashes($cap))."',
	  idR='".mysqli_real_escape_string($conn,stripslashes($idR))."',
	  idP='".mysqli_real_escape_string($conn,stripslashes($idP))."',
	  idC='".mysqli_real_escape_string($conn,stripslashes($idC))."',
	  idM='".mysqli_real_escape_string($conn,stripslashes($idM))."',
	  idQ='".mysqli_real_escape_string($conn,stripslashes($idQ))."',
	  altro='".mysqli_real_escape_string($conn,stripslashes($altro))."'
	  WHERE idAttivita='".$id."'";
      $query=mysqli_query($conn,$sql);

      $mappa=$_POST['mappa'];
	  $sql="UPDATE att_map SET 
	  mappa='".mysqli_real_escape_string($conn,stripslashes($mappa))."'
	  WHERE idAttivita='".$id."'";
      $query=mysqli_query($conn,$sql);
}

print "<h4>Modifica dati Attivita' ID:".$id." - ";
$succ=$id+1; print "<a href='cliente.php?id=".$succ."'>Successivo</a> | ";
$prec=$id-1; print "<a href='cliente.php?id=".$prec."'>Precedente</a></h4>";

	 $sql="SELECT 
     attivita.idAttivita,attivita,
     utente,pwd,dataReg,assistPeriod,vetrOmaggio,creaEventi,creaPromo,
     ragsoc,partitaiva,codfisc,
     osc,dataScad,dataAvv,dataOsc,
     telefono,email,nota,
     cartella,
     indirizzo,nciv,cap,idR,idP,idC,idM,idQ,altro,
     mappa
     
     FROM 
     attivita,
     att_clienti,
     att_ragsoc,
     att_scad,
     att_clienti_contatti,
     vetrine,
     att_indirizzi,
     att_map
     
     WHERE 
     attivita.idAttivita=att_clienti.idAttivita 
     AND attivita.idAttivita=att_ragsoc.idAttivita 
     AND attivita.idAttivita=att_scad.idAttivita
     AND attivita.idAttivita=att_clienti_contatti.idAttivita 
     AND attivita.idAttivita=vetrine.idAttivita 
     AND attivita.idAttivita=att_indirizzi.idAttivita 
     AND attivita.idAttivita=att_map.idAttivita 
     AND attivita.idAttivita='".$id."'";
	 
	 $query=mysqli_query($conn,$sql);
	 $cliente=mysqli_fetch_array($query,MYSQLI_ASSOC);
     
    // date
    $dataReg=$cliente['dataReg'];
    $dataAvv=$cliente['dataAvv'];
	$ggAvv=substr($dataAvv,6,2);
	$mmAvv=substr($dataAvv,4,2);
	$aaAvv=substr($dataAvv,0,4);
	$dataScad=$cliente['dataScad'];
	$ggScad=substr($dataScad,6,2);
	$mmScad=substr($dataScad,4,2);
	$aaScad=substr($dataScad,0,4);
	$dataOsc=$cliente['dataOsc'];
	$ggOsc=substr($dataOsc,6,2);
	$mmOsc=substr($dataOsc,4,2);
	$aaOsc=substr($dataOsc,0,4);
    
?>
  <form id="clPrincip" method="post" action="?id=<?php print $id; ?>"><p>
  <label>Cliente</label> <input type="text" size="40" name="attivita" value="<?php print $cliente['attivita']; ?>" /><br /><br />
  <label>Utente</label> <input type="text" size="40" name="utente" value="<?php print $cliente['utente']; ?>" /><br /><br />
  <label>Password</label> <input type="text" size="40" name="password" value="<?php print $cliente['pwd']; ?>" disabled="yes" /><br /><br />

  <label>Vetrina Omaggio?</label> 
  <select options="1" name="vetrOmaggio">
  <?php
  if ($cliente['vetrOmaggio']=="n") {
    print "<option value='n' selected>NO</option><option value='s'>SI</option>";
	} else {
	print "<option value='s' selected>SI</option><option value='n'>NO</option>";  }
  ?>
  </select>
  <br /><br />
  
  <label>Riceve assistenza periodica?</label> 
  <select options="1" name="assistPeriod">
  <?php
  if ($cliente['assistPeriod']=="n") {
    print "<option value='n' selected>NO</option><option value='s'>SI</option>";
	} else {
	print "<option value='s' selected>SI</option><option value='n'>NO</option>";  }
  ?>
  </select>
  <br /><br />

  <label>Puo' creare eventi?</label> 
  <select options="1" name="creaEventi">
  <?php
  if ($cliente['creaEventi']=="n") {
    print "<option value='n' selected>NO</option><option value='s'>SI</option>";
	} else {
	print "<option value='s' selected>SI</option><option value='n'>NO</option>";  }
  ?>
  </select>
  <br /><br />
  
  <label>Puo' promuovere Articoli fuori zona?</label> 
  <select options="1" name="creaPromo">
  <?php
  if ($cliente['creaPromo']=="n") {
    print "<option value='n' selected>NO</option><option value='s'>SI</option>";
	} else {
	print "<option value='s' selected>SI</option><option value='n'>NO</option>";  }
  ?>
  </select>
  <br /><br />

  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />


  <form id="clOsc" method="post" action="?id=<?php print $id; ?>"><p> 
  <label>Oscuramento</label><br />
  <select options="1" name="osc">
  <?php
  if ($cliente['osc']=="n") {
    print "<option value='n' selected>Vetrina attiva</option><option value='s'>OSCURA questa vetrina</option>";
	} else {
	print "<option value='s' selected>Vetrina OSCURATA</option><option value='n'>RIATTIVA questa vetrina</option>";  }
  ?>
  </select>
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />


  <form id="clDate" method="post" action="?id=<?php print $id; ?>"><p>
  <label>Data di scadenza del contratto</label><br />
  <input name="newGGscad" size="2" value="<?php print $ggScad; ?>" /> /
  <input name="newMMscad" size="2" value="<?php print $mmScad; ?>" /> /
  <input name="newAAscad" size="4" value="<?php print $aaScad; ?>" />
  <input type="hidden" name="oldScad" value="<?php print $cliente['dataScad']; ?>" />  
  <?php
  if($msgData!="") print "<br /><span style='color: #FD0702'><b>ATTENZIONE! ".$msgData."</b></span>";
  ?>
  <br /><br />
Avviso scadenza (2 settimane prima): 
<span style="color: #03A861">
<?php 
print substr($dataAvv,6,2)."/".substr($dataAvv,4,2)."/".substr($dataAvv,0,4);
?>
</span>
<input name="newGGavv" type="hidden" size="2" value="<?php print $ggAvv; ?>" />
<input name="newMMavv" type="hidden" size="2" value="<?php print $mmAvv; ?>" />
<input name="newAAavv" type="hidden" size="4" value="<?php print $aaAvv; ?>" />
<input type="hidden" name="oldAvv" value="<?php print $cliente['dataAvv']; ?>" />
<br/>
Data disattivazione (1 mese dopo scadenza): 
<span style="color: #03A861">
<?php 
print substr($dataOsc,6,2)."/".substr($dataOsc,4,2)."/".substr($dataOsc,0,4);
?>
</span>
<input name="newGGosc" type="hidden" size="2" value="<?php print $ggOsc; ?>" />
<input name="newMMosc" type="hidden" size="2" value="<?php print $mmOsc; ?>" />
<input name="newAAosc" type="hidden" size="4" value="<?php print $aaOsc; ?>" />
<input type="hidden" name="oldOsc" value="<?php print $cliente['dataOsc']; ?>" />
<br/>
Data prima registazione: 
<b>
<?php 
print substr($dataReg,6,2)."/".substr($dataReg,4,2)."/".substr($dataReg,0,4);
?>
<input type="hidden" name="dataReg" value="<?php print $dataReg; ?>" />  
</b>
<br/><br/>
<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />


  <form id="clVetrina" method="post" action="?id=<?php print $id; ?>"><p>
  <label>Cartella vetrina</label><br /> <input type="text" size="40" name="newCart" value="<?php print $cliente['cartella']; ?>" />
  <input type="hidden" name="oldCart" value="<?php print $cliente['cartella']; ?>" />
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />

  <form id="clRs" method="post" action="?id=<?php print $id; ?>"><p>
  <label>Ragione sociale</label><br /> <textarea name="ragsoc" cols="50" rows="3"><?php print $cliente['ragsoc']; ?></textarea><br /><br />
  <label>Partita IVA</label> <input type="text" size="40" name="partitaiva" value="<?php print $cliente['partitaiva']; ?>" /><br /><br />
  <label>Codice fiscale</label> <input type="text" size="40" name="codfisc" value="<?php print $cliente['codfisc']; ?>" /><br /><br />
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />
  

  <form id="mappaindirizzo" method="post" action="?id=<?php print $id; ?>"><p>
  <label>Indirizzo</label><br /> <textarea name="indirizzo" cols="50" rows="3"><?php print $cliente['indirizzo']; ?></textarea><br />
  <label>N. civ.</label> <input type="text" size="10" name="nciv" value="<?php print $cliente['nciv']; ?>" /> <br /><br />
  <label>Cap</label> <input type="text" size="10" name="cap" value="<?php print $cliente['cap']; ?>" /><br /><br />

<label>Citta' (Prov)</label><br />
<select options="1" name="idC">
<?php
$nomecitta="";
$sql_d="SELECT idC,comune,sigla FROM comuni,province WHERE comuni.idP=province.idP ORDER BY comune ASC";
$query_d=mysql_query($sql_d); 
while($elencoC=mysql_fetch_array($query_d)){
    print "<option value='".$elencoC['idC']."'";
    if ($elencoC['idC']==$cliente['idC']) { print " selected"; $nomecitta=$elencoC['comune']; }
    print ">".$elencoC['comune']." (".$elencoC['sigla'].") </option>";
}
?>    
</select>
<br /><br />


<?php
if ($cliente['idC']==25){
print "<label>Quartiere (Genova)</label><br />";    
print "<select options='1' name='idQ'>";
    //if ($cliente['idQ']==0) { print "<option value='0' selected>===</option>";}
    $sql_d="SELECT idQ,quartiere FROM quartieri ORDER BY quartiere ASC";
    $query_d=mysql_query($sql_d); 
    while($elencoQ=mysql_fetch_array($query_d)){
        print "<option value='".$elencoQ['idQ']."'";
        if ($elencoQ['idQ']==$cliente['idQ']) { print " selected";}
        print ">".$elencoQ['quartiere']."</option>";
    }
print "</select>";
}
else { print "<input type='hidden' name='idQ' value='0' />";} 
?>
<br /><br />

<label>Altro/Estero</label><br /> <textarea name="altro" cols="50" rows="3"><?php print $cliente['altro']; ?></textarea><br /><br />

<?php
if ($cliente['mappa']!="") {
	print $cliente['mappa']."<br/><br/>";
//print "<iframe width='425' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='".$cliente['mappa']."'></iframe><br /><br />";	
}
?>
<label>Codice mappa
- <i>
<?php
print $cliente['indirizzo'].", ".$nomecitta;
?>
</i>
- <a href="http://www.openstreetmap.org" target="_blank">localizza su <em>Openstreetmap.org</em></a>
</label><br />
<textarea name="mappa" cols="50" rows="3"><?php print $cliente['mappa']; ?></textarea><br /><br />
<br /><br />

  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />
  

<h3>Dati riservati a uso interno</h3>
  <form id="clContatti" method="post" action="?id=<?php print $id; ?>"><p>
  <label>Tel</label> <input type="text" size="40" name="telefono" value="<?php print $cliente['telefono']; ?>" /><br /><br />
  <label>Email</label> <input type="email" size="40" name="email" value="<?php print $cliente['email']; ?>" /><br /><br />
  <label>Nota</label><br /> <textarea name="nota" cols="50" rows="3"><?php print $cliente['nota']; ?></textarea><br /><br />
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />
  

<br /><br />
