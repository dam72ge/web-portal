<?php
// FUNZIONI DATABASE 

class mysql extends pagina{

// Elenco reti
  function elenco_settori($conn,$where){
    
    $dati=array(
	"idSett" => array (""),
	"settore" => array (""),
	"totReti" => array (""),
	"totAttivita" => array ("")
    );

    $sql="
    SELECT idSett,settore 
    FROM reti_settori
     ".$where." 
    ORDER BY settore ASC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idSett'][]=$riga['idSett'];
        $dati['settore'][]=$riga['settore'];

        $totReti=0;        
        $totAttivita=0;        

            $sql1="
            SELECT idRete
            FROM reti
            WHERE osc='n'
            AND idSett='".$riga['idSett']."'";
            $query1=mysqli_query($conn,$sql1);			
            $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            if ($row['idRete']>0) { 
                $totReti++;             
                $sql2="
                SELECT idAttivita
                FROM vetrine_reti
                WHERE idRete='".$row['idRete']."'";
                $query2=mysqli_query($conn,$sql2);			
                while ($a=mysqli_fetch_array($query2,MYSQLI_ASSOC)){
                $totAttivita++;
                }
            }
        $dati['totReti'][]=$totReti;
        $dati['totAttivita'][]=$totAttivita;
    }	
    return $dati;
  }

// Elenco attività per settore
  function attivita_per_settore($conn,$idSett){
    
    $dati=array(
	"idAttivita" => array (""),
	"attivita" => array (""),
	"cartella" => array (""),
	"logo" => array (""),
	"zona" => array ("")
    );

    $oggi=date("Ymd");
    $sql="
    SELECT idRete
    FROM reti
    WHERE idSett='".$idSett."'";
    $query=mysqli_query($conn,$sql);			
    $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
    if ($row['idRete']>0) { 

        $sql2="
        SELECT attivita.idAttivita,attivita,cartella,logo,comune,sigla,altro,dataOsc
        FROM attivita,vetrine,vetrine_reti,att_indirizzi,comuni,province,att_scad
        WHERE attivita.idAttivita=vetrine.idAttivita
        AND attivita.idAttivita=att_scad.idAttivita
        AND attivita.idAttivita=vetrine_reti.idAttivita
        AND attivita.idAttivita=att_indirizzi.idAttivita
        AND att_indirizzi.idC=comuni.idC
        AND att_indirizzi.idP=province.idP
        AND att_scad.osc='n' 
        AND idRete='".$row['idRete']."'";
        $query2=mysqli_query($conn,$sql2);			
        while ($riga=mysqli_fetch_array($query2,MYSQLI_ASSOC)){
        if ($oggi<=$riga['dataOsc']) {
        $dati['idAttivita'][]=$riga['idAttivita'];
        $dati['attivita'][]=$riga['attivita'];
        $dati['cartella'][]=$riga['cartella'];
        $dati['logo'][]=$riga['logo'];
        $zona="";
        if ($riga['comune']!="") {$zona.=$riga['comune'];}
        if ($riga['sigla']!="") {$zona.=" (".$riga['sigla'].") ";}
        if ($zona=="") {$zona=$riga['altro'];}
        $dati['zona'][]=$zona;
        }
        }
    }
    return $dati;
  }

// Elenco attività per rete
  function attivita_per_rete($conn,$idRete){

    $dati=array(
	"idAttivita" => array (""),
	"attivita" => array (""),
	"cartella" => array (""),
	"logo" => array (""),
	"zona" => array ("")
    );
    $oggi=date("Ymd");
    $sql="
    SELECT attivita.idAttivita,dataOsc,attivita,cartella,logo,comune,sigla,altro
    FROM attivita,vetrine,vetrine_reti,att_indirizzi,comuni,province,att_scad 
    WHERE attivita.idAttivita=att_scad.idAttivita  
    AND attivita.idAttivita=vetrine.idAttivita
    AND attivita.idAttivita=vetrine_reti.idAttivita
    AND attivita.idAttivita=att_indirizzi.idAttivita
    AND att_indirizzi.idC=comuni.idC
    AND att_indirizzi.idP=province.idP
    AND att_scad.osc='n' 
    AND idRete='".$idRete."'";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    if ($oggi<=$riga['dataOsc']) {
	    $dati['idAttivita'][]=$riga['idAttivita'];
        $dati['attivita'][]=$riga['attivita'];
        $dati['cartella'][]=$riga['cartella'];
        $dati['logo'][]=$riga['logo'];
        $zona="";
        if ($riga['comune']!="") {$zona.=$riga['comune'];}
        if ($riga['sigla']!="") {$zona.=" (".$riga['sigla'].") ";}
        if ($zona=="") {$zona=$riga['altro'];}
        $dati['zona'][]=$zona;
    }
    }
    return $dati;
  }


// Elenco eventi per rete (ultimi 5)
  function eventi_per_rete($conn,$idRete){    

    $dati=array(
	"id" => array (""),
	"titolo" => array (""),
	"dataInizio" => array (""),
	"dataFine" => array (""),
	"img" => array ("")
    );

    $conta=0;
    $sql="
    SELECT eventi.id,titolo,img,dataInizio,dataFine
    FROM eventi,eventi_promot,eventi_dateore
    WHERE eventi.id=eventi_promot.id 
    AND eventi.id=eventi_dateore.id     
    AND idRete='".$idRete."'
    ORDER BY dataOsc DESC, anno DESC, titolo ASC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if ($conta<5) {
            $dati['id'][]=$riga['id'];
            $dati['titolo'][]=$riga['titolo'];
            $dati['dataInizio'][]=$riga['dataInizio'];
            $dati['dataFine'][]=$riga['dataFine'];
            $dati['img'][]=$riga['img'];
            $conta++;
        }        
    }
    return $dati;
  }


// Elenco reti
  function elenco_reti($conn,$where){
    
    $dati=array(
	"idRete" => array (""),
	"rete" => array (""),
	"descriz" => array (""),
	"url" => array (""),
	"logo" => array (""),

	"idSett" => array (""),
	"settore" => array (""),
    
	"idR" => array (""),
	"idP" => array (""),
	"idC" => array (""),
	"idM" => array (""),
	"idQ" => array (""),
 	"zona" => array ("")
    );


    $sql="
    SELECT reti.idRete,rete,descriz,url,idSett,logo,idR,idP,idC,idM,idQ 
    FROM reti,reti_zone 
    WHERE reti.osc='n' 
    AND reti.idRete=reti_zone.idRete 
     ".$where." 
    ORDER BY rete ASC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idRete'][]=$riga['idRete'];
        $dati['rete'][]=$riga['rete'];
        $dati['descriz'][]=$riga['descriz'];
        $dati['url'][]=$riga['url'];
        $dati['idSett'][]=$riga['idSett'];
        $dati['logo'][]=$riga['logo'];        

            // settore
            $sql1="SELECT settore FROM reti_settori WHERE idSett='".$riga['idSett']."'";
            $query1=mysqli_query($conn,$sql1);			
            $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            $dati['settore'][]=$row['settore'];
        
            // zona
            $zona="";
            if ($riga['idR']!=1 && $riga['idR']>0 ) {
                $sql1="SELECT regione FROM regioni WHERE idR='".$riga['idR']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=$row['regione']." ";}
            if ($riga['idC']!=25 && $riga['idP']>0) {
                $sql1="SELECT sigla FROM province WHERE idP='".$riga['idP']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1, MYSQLI_ASSOC);
                $zona.=" (".$row['sigla'].") ";}
            if ($riga['idC']>0) { 
                $sql1="SELECT comune FROM comuni WHERE idC='".$riga['idC']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1, MYSQLI_ASSOC);
                $zona.=$row['comune']." ";}
            if ($riga['idM']>0) { 
                $sql1="SELECT municipio FROM municipi WHERE idM='".$riga['idM']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=$row['municipio']." ";}
            if ($riga['idQ']>0) {
                $sql1="SELECT quartiere FROM quartieri WHERE idQ='".$riga['idQ']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=$row['quartiere']." ";}
            if ($riga['idR']==0 && $riga['idP']==0 && $riga['idC']==0 && $riga['idM']==0 && $riga['idQ']==0) {
                $zona="Tutta Italia";}

        $dati['idR'][]=$riga['idR'];        
        $dati['idP'][]=$riga['idP'];        
        $dati['idC'][]=$riga['idC'];        
        $dati['idM'][]=$riga['idM'];        
        $dati['idQ'][]=$riga['idQ'];        
        $dati['zona'][]=$zona;        
	 }	
    return $dati;
  }

// singola rete
  function singola_rete($conn,$id){
    
    $dati=array(
	"idRete" => array (""),
	"rete" => array (""),
	"descriz" => array (""),
	"url" => array (""),
	"logo" => array (""),

	"idSett" => array (""),
	"settore" => array (""),
    
	"idR" => array (""),
	"idP" => array (""),
	"idC" => array (""),
	"idM" => array (""),
	"idQ" => array (""),
 	"zona" => array ("")
    );


    $sql="
    SELECT reti.idRete,rete,descriz,url,idSett,logo,idR,idP,idC,idM,idQ 
    FROM reti,reti_zone 
    WHERE  
    reti.idRete=reti_zone.idRete 
    AND reti.idRete='".$id."'";
    $query=mysqli_query($conn,$sql);			
    $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);
    
        $dati['idRete'][0]=$riga['idRete'];
        $dati['rete'][0]=$riga['rete'];
        $dati['descriz'][0]=$riga['descriz'];
        $dati['url'][0]=$riga['url'];
        $dati['idSett'][0]=$riga['idSett'];
        $dati['logo'][0]=$riga['logo'];        

            // settore
            $sql1="SELECT settore FROM reti_settori WHERE idSett='".$riga['idSett']."'";
            $query1=mysqli_query($conn,$sql1);			
            $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            $dati['settore'][0]=$row['settore'];
        
            // zona
            $zona="";
            if ($riga['idR']!=1 && $riga['idR']>0 ) {
                $sql1="SELECT regione FROM regioni WHERE idR='".$riga['idR']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=ucwords($row['regione'])." ";}
            if ($riga['idC']!=25 && $riga['idP']>0) {
                $sql1="SELECT provincia FROM province WHERE idP='".$riga['idP']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=" Prov. di ".ucwords($row['provincia'])." ";}
            if ($riga['idC']>0) { 
                $sql1="SELECT comune FROM comuni WHERE idC='".$riga['idC']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=" ".ucfirst($row['comune'])." ";}
            if ($riga['idM']>0) { 
                $sql1="SELECT municipio FROM municipi WHERE idM='".$riga['idM']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=" ".ucwords($row['municipio'])." ";}
            if ($riga['idQ']>0) {
                $sql1="SELECT quartiere FROM quartieri WHERE idQ='".$riga['idQ']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=" ".ucfirst($row['quartiere'])." ";}
            if ($riga['idR']==0 && $riga['idP']==0 && $riga['idC']==0 && $riga['idM']==0 && $riga['idQ']==0) {
                $zona=" Tutta Italia ";}

        $dati['idR'][0]=$riga['idR'];        
        $dati['idP'][0]=$riga['idP'];        
        $dati['idC'][0]=$riga['idC'];        
        $dati['idM'][0]=$riga['idM'];        
        $dati['idQ'][0]=$riga['idQ'];        
        $dati['zona'][0]=$zona;        
    return $dati;
  }

}
?>
