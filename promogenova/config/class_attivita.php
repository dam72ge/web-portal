<?php

// FUNZIONI DATABASE 

class mysql extends pagina{

// IDENTIFICA CLIENTE
  function elenco_attivita($conn,$url,$orderby){
    
    $dati=array(
	"idAttivita" => array (""),
	"attivita" => array (""),
	"cartella" => array (""),
	"logo" => array (""),
	"ragsoc" => array (""),
	"zona" => array (""),
	"dataReg" => array (""),
	"chisiamo" => array ("")
	);

    $oggi=date('Ymd');
    $sql="
    SELECT attivita.idAttivita,attivita,cartella,logo,idR,idP,idC,idM,idQ,ragsoc,dataOsc,dataReg,chisiamo
    FROM attivita,att_clienti,att_scad,att_indirizzi,att_ragsoc,vetrine,vetrine_chisiamo 
    WHERE att_scad.osc='n' 
    AND attivita.idAttivita=att_scad.idAttivita
    AND attivita.idAttivita=att_indirizzi.idAttivita
    AND attivita.idAttivita=att_ragsoc.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita 
    AND attivita.idAttivita=att_clienti.idAttivita    
    AND attivita.idAttivita=vetrine_chisiamo.idAttivita    
    ORDER BY ".$orderby;

    $query=mysqli_query($conn,$sql);			
    while($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
	if (($riga['dataOsc']-$oggi)>0){
	$vetr=$url.$riga['cartella'];
    $zona="";
	if (is_dir($vetr)){
	   
		// zona vetrina
		if ($riga['idC']=='25' && $riga['idQ']>0){
    	$sql1="SELECT quartiere FROM quartieri WHERE idQ='".$riga['idQ']."'";
    	$query1=mysqli_query($conn,$sql1);			
    	$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);		
		$zona.="Genova ".$row['quartiere'];
		}
		else{
    	$sql1="SELECT comune,sigla FROM comuni,province WHERE province.idP=comuni.idP AND comuni.idC='".$riga['idC']."'";
    	$query1=mysqli_query($conn,$sql1);			
    	$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);		
		$zona.=$row['comune']." (".$row['sigla'].")";		
		}
        
    $dati['attivita'][]=$riga['attivita'];
    $dati['idAttivita'][]=$riga['idAttivita'];
    $dati['cartella'][]=$riga['cartella'];
    $dati['logo'][]=$riga['logo'];
    $dati['ragsoc'][]=$riga['ragsoc'];
    $dati['zona'][]=$zona;     
    $dati['dataReg'][]=$riga['dataReg'];
    $dati['chisiamo'][]=$riga['chisiamo'];
    }
    }
    }
  return $dati;
  }


} // chiude classe
?>
