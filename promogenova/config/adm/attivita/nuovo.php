<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../attivita">Attività</a> | CREA NUOVO CLIENTE</h3>

<?php

// modifiche
if (isset($_POST['attivita']) && $_POST['attivita']!="") {

    $sql = 
    "
    INSERT INTO attivita
    (idAttivita,attivita) 
    VALUES 
    ( 
    default,
    '".mysqli_real_escape_string($conn,stripslashes($_POST['attivita']))."'
    )";
    $query=mysqli_query($conn,$sql);
//print $sql."<br />";

    // id nuova attivita
   	$idNuovo=mysqli_insert_id($conn);
//print $idNuovo."<br />";

    //data
    $oggi=date("Ymd");
    
    $sql = 
    "
    INSERT INTO att_clienti
    (idAttivita,utente,pwd,dataReg,vetrOmaggio,creaEventi,assistPeriod,creaPromo) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['utente']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['pwd']))."',
    '".mysqli_real_escape_string($conn,stripslashes($oggi))."',
    'n',
    'n',
    'n',
    'n'    
    )";
    $query=mysqli_query($conn,$sql);
//print $sql."<br />";

    $sql = 
    "
    INSERT INTO att_clienti_contatti
    (idAttivita,telefono,email,nota) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '',
    '',
    ''    
    )";
    $query=mysqli_query($conn,$sql);
//print $sql."<br />";

    $sql = 
    "
    INSERT INTO att_indirizzi
    (idAttivita,indirizzo,nciv,cap,idR,idP,idC,idM,idQ,altro) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '',
    '',
    '16100',
    '1',
    '1',
    '25',
    '0',
    '0',
    ''    
    )";
    $query=mysqli_query($conn,$sql);
//print $sql."<br />";
    
    $sql = 
    "
    INSERT INTO att_map
    (idAttivita,mappa) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    ''    
    )";
    $query=mysqli_query($conn,$sql);
//print $sql."<br />";
    
    $sql = 
    "
    INSERT INTO att_ragsoc
    (idAttivita,ragsoc,partitaiva,codfisc) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '',
    '',
    ''    
    )";
    $query=mysqli_query($conn,$sql);
//print $sql."<br />";


	// crea data in formato numerico; data scadenza = 1 anno dopo
	$newData= date('Ymd');
	$newScad=$newData+10000;

	$newGGscad=substr($newScad,6,2);
	$newMMscad=substr($newScad,4,2);
	$newAAscad=substr($newScad,0,4);

// crea nuova data avviso scadenza (2 settimane prima)   
	$ggAvv=$newGGscad-14; $mmAvv=$newMMscad; $aaAvv=$newAAscad;
	if ($ggAvv<=0){ 
	$ggAvv=(31+$ggAvv)-15; 
	$mmAvv=$newMMscad-1;
	if ($mmAvv<=0){ $mmAvv=12; $aaAvv=$newAAscad-1;} 
	}	
	$i1=""; if ($newMMscad!=$mmAvv && $mmAvv<10){ $i1="0"; }
	$i2=""; if ($newGGscad!=$ggAvv && $ggAvv<10){ $i2="0"; }
    $newAvv=$aaAvv.$i1.$mmAvv.$i2.$ggAvv;

// crea nuova data oscuramento definitivo: 1 mese dopo la scadenza
	$ggOsc=$newGGscad; $mmOsc=$newMMscad+1; $aaOsc=$newAAscad;
	if ($mmOsc>12){ $mmOsc=1; $aaOsc=$newAAscad+1;}  
	$i1=""; if ($newMMscad!=$mmOsc && $mmOsc<10){ $i1="0"; }
	$i2=""; if ($newGGscad!=$ggOsc && $ggOsc<10){ $i2="0"; }
    $newOsc=$aaOsc.$i1.$mmOsc.$ggOsc;

    $sql = 
    "
    INSERT INTO att_scad
    (idAttivita,osc,dataScad,dataAvv,dataOsc) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    's',
    '".mysqli_real_escape_string($conn,stripslashes($newScad))."',
    '".mysqli_real_escape_string($conn,stripslashes($newAvv))."',
    '".mysqli_real_escape_string($conn,stripslashes($newOsc))."'
    )";
    $query=mysqli_query($conn,$sql);
//print $sql."<br />";


// crea nome provvisorio per la cartella
	$cop_tit=strtolower($_POST['attivita']);
       $cop_tit=str_replace("'", "", $cop_tit);
       $virg=chr(34);
       $cop_tit=str_replace($virg, "", $cop_tit);
       $cop_tit=str_replace("!", "", $cop_tit);
       $cop_tit=str_replace("?", "", $cop_tit);
       $cop_tit=str_replace(".", "", $cop_tit);
       $cop_tit=str_replace(";", "", $cop_tit);
       $cop_tit=str_replace("-", "", $cop_tit);
       $cop_tit=str_replace("(", "", $cop_tit);
       $cop_tit=str_replace(")", "", $cop_tit);
       $cop_tit=str_replace(",", "", $cop_tit);
       $cop_tit=str_replace(":", "", $cop_tit);
       $cop_tit=str_replace("«", "", $cop_tit);
       $cop_tit=str_replace("»", "", $cop_tit);
       $cop_tit=str_replace(" ", "-", $cop_tit);
	$cartella=$cop_tit;

    $sql = 
    "
    INSERT INTO vetrine
    (idAttivita,cartella,logo) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    '".mysqli_real_escape_string($conn,stripslashes($cartella))."',
    ''
    )";
    $query=mysqli_query($conn,$sql);
//print $sql."<br />";
    
	// crea cartella e sottocartelle vetrina 
	$cartella=$url.$cartella;
	mkdir($cartella);
	$cart1=$cartella."/foto"; mkdir($cart1);
	$cart2=$cartella."/articoli"; mkdir($cart2);

	// copia file da 'cfg/gestione/modello-vetrina'
	$modello=$url."config/modello-vetrina/index.php"; $destin=$cartella."/index.php"; copy($modello, $destin);
	$modello=$url."config/modello-vetrina/foto.php"; $destin=$cartella."/foto.php"; copy($modello, $destin);
	$modello=$url."config/modello-vetrina/articoli.php"; $destin=$cartella."/articoli.php"; copy($modello, $destin);

    $sql = 
    "
    INSERT INTO vetrine_chisiamo
    (idAttivita,chisiamo) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    ''
    )";
    $query=mysqli_query($conn,$sql);
//print $sql."<br />";

    $sql = 
    "
    INSERT INTO vetrine_orari
    (idAttivita,orari) 
    VALUES 
    ( 
    '".mysqli_real_escape_string($conn,stripslashes($idNuovo))."',
    ''
    )";
    $query=mysqli_query($conn,$sql);
//print $sql."<br />";

// VAI DIRETTAMENTE ALLA MODIFICA CLIENTE
$redirUrl="cliente.php?id=".$idNuovo;

        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 

} 
?>


  <form id="newcliente" method="post" action="?"><p>
  <label>Attività</label> <input type="text" size="40" name="attivita" value="" /><br /><br />
  <label>Utente</label> <input type="text" size="40" name="utente" value="" /><br /><br />
  <label>Password</label> <input type="text" size="40" name="pwd" value="" /><br /><br />

  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
  <br /><br />

