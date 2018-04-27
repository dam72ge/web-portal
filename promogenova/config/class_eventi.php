<?php

// FUNZIONI DATABASE 

class mysql extends pagina{

// Singolo evento
  function singolo_evento($conn,$id){
	 $sql="SELECT eventi.id,home,titolo,testo,media.img,anno,dataInizio,oreInizio,dataFine,oreFine,dataAvv,dataOsc,idR,idP,idC,idM,idQ
     FROM eventi,eventi_dateore,eventi_txt,eventi_zone,media,media_link
     WHERE eventi.id=eventi_dateore.id 
     AND eventi.id=eventi_txt.id 
     AND eventi.id=eventi_zone.id 
     AND media_link.idMedia=media.idMedia 
     AND media_link.id=eventi.id
     AND eventi.id='".$id."'";
     $query=mysqli_query($conn,$sql);		
     $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);

            // zona
            $zona=""; 
            $riga['regione']="";
            $riga['provincia']="";
            $riga['sigla']="";
            $riga['comune']="";
            $riga['municipio']="";
            $riga['quartiere']="";            
            
            if ($riga['idR']>0 ) {
                $sql1="SELECT regione FROM regioni WHERE idR='".$riga['idR']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                    if ($riga['idR']!=1) {
                    $zona.=$row['regione']." ";
                    } 
                $riga['regione']=ucwords($row['regione']);
                $riga['regione']=$this->mb_convert_encoding($riga['regione']);
                } 
            if ($riga['idP']>0) {
                $sql1="SELECT provincia, sigla FROM province WHERE idP='".$riga['idP']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                    if ($riga['idC']!=25) {
                    $zona.=" (".$row['sigla'].") ";
                    } 
                $riga['provincia']=ucfirst($row['provincia']); $riga['sigla']=strtoupper($row['sigla']);
                $riga['provincia']=$this->mb_convert_encoding($riga['provincia']);
                }
            if ($riga['idC']>0) { 
                $sql1="SELECT comune FROM comuni WHERE idC='".$riga['idC']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=$row['comune']." "; 
                $riga['comune']=ucfirst($row['comune']); 
                $riga['comune']=$this->mb_convert_encoding($riga['comune']);
                }
            if ($riga['idM']>0) { 
                $sql1="SELECT municipio FROM municipi WHERE idM='".$riga['idM']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=$row['municipio']." ";
                $riga['municipio']=ucfirst($row['municipio']); 
                $riga['municipio']=$this->mb_convert_encoding($riga['municipio']);
                }
            if ($riga['idQ']>0) {
                $sql1="SELECT quartiere FROM quartieri WHERE idQ='".$riga['idQ']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=$row['quartiere']." ";
                $riga['quartiere']=ucfirst($row['quartiere']); 
                $riga['quartiere']=$this->mb_convert_encoding($riga['quartiere']);
                }
            if ($riga['idR']==0 && $riga['idP']==0 && $riga['idC']==0 && $riga['idM']==0 && $riga['idQ']==0) {
                $zona="Tutta Italia";}
        
        $riga['zona']=$zona;        
        $riga['url']="";        
        $riga['idAttivita']=0;        
        $riga['idRete']=0;        

     // aggiorna url
		$sql="SELECT url FROM eventi,eventi_link 
        WHERE eventi.id=eventi_link.id 
        AND eventi.id='".$id."'";
        $query=mysqli_query($conn,$sql);			
        $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
        if (isset($row['url']) && $row['url']!="") {
        $riga['url']=$row['url'];
        }
     
     // aggiorna idAttivita e idRete
		$sql="SELECT idAttivita,idRete FROM eventi,eventi_promot 
        WHERE eventi.id=eventi_promot.id 
        AND eventi.id='".$id."'";
        $query=mysqli_query($conn,$sql);			
        $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
        if (isset($row['idAttivita']) && $row['idAttivita']>0) {
        $riga['idAttivita']=$row['idAttivita'];
        }
        if (isset($row['idRete']) && $row['idRete']>0) {
        $riga['idRete']=$row['idRete'];
        }

    return $riga;
  }

// Elenco eventi
  function elenco_eventi($conn){
  $conta=0;
    
    $dati=array(
	"id" => array (""),
	"home" => array (""),
	"titolo" => array (""),
	"testo" => array (""),
	"img" => array (""),
	"anno" => array (""),
	"dataInizio" => array (""),
	"oreInizio" => array (""),    
	"dataFine" => array (""),
	"oreFine" => array (""),    
	"dataAvv" => array (""),
	"dataOsc" => array (""),    
	"idR" => array (""),
	"idP" => array (""),
	"idC" => array (""),
	"idM" => array (""),
	"idQ" => array (""),
 	"zona" => array (""),

 	"url" => array (""),
 	"idAttivita" => array (""),
 	"idRete" => array ("")
    );


	 $sql="SELECT eventi.id,home,titolo,testo,media.img,anno,dataInizio,oreInizio,dataFine,oreFine,dataAvv,dataOsc,idR,idP,idC,idM,idQ
     FROM eventi,eventi_dateore,eventi_txt,eventi_zone,media,media_link
     WHERE eventi.id=eventi_dateore.id 
     AND eventi.id=eventi_txt.id 
     AND eventi.id=eventi_zone.id 
     AND media_link.idMedia=media.idMedia 
     AND media_link.id=eventi.id
     ORDER BY dataOsc DESC, eventi.id DESC, anno DESC";

    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        
        $dati['id'][]=$riga['id'];
        $dati['home'][]=$riga['home'];
        $dati['titolo'][]=$riga['titolo'];
        $dati['testo'][]=$riga['testo'];
        $dati['img'][]=$riga['img'];
        $dati['anno'][]=$riga['anno'];
        $dati['dataInizio'][]=$riga['dataInizio'];        
        $dati['oreInizio'][]=$riga['oreInizio'];        
        $dati['dataFine'][]=$riga['dataFine'];        
        $dati['oreFine'][]=$riga['oreFine'];        
        $dati['dataAvv'][]=$riga['dataAvv'];        
        $dati['dataOsc'][]=$riga['dataOsc'];        

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
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
                $zona.=" (".$row['sigla'].") ";}
            if ($riga['idC']>0) { 
                $sql1="SELECT comune FROM comuni WHERE idC='".$riga['idC']."'";
                $query1=mysqli_query($conn,$sql1);			
                $row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
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

        $dati['url'][]="";
        $dati['idAttivita'][]="0";        
        $dati['idRete'][]="0";        

     $conta++;
	 }	

     // aggiorna idAttivita e idRete
     if ($conta>0) {
     for ($i=0;$i<count($dati['id']);$i++) {
		$sql="SELECT url FROM eventi,eventi_link 
        WHERE eventi.id=eventi_link.id 
        AND eventi.id='".$dati['id'][$i]."'";
        $query=mysqli_query($conn,$sql);			
        $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);
        if (isset($riga['url']) && $riga['url']>0) {
        $dati['url'][$i]=$riga['url'];
        }
     }
     }
     
     // aggiorna url
     if ($conta>0) {
     for ($i=0;$i<count($dati['id']);$i++) {
		$sql="SELECT idAttivita,idRete FROM eventi,eventi_promot 
        WHERE eventi.id=eventi_promot.id 
        AND eventi.id='".$dati['id'][$i]."'";
        $query=mysqli_query($conn,$sql);			
        $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);
        if (isset($riga['idAttivita']) && $riga['idAttivita']>0) {
        $dati['idAttivita'][$i]=$riga['idAttivita'];
        }
        if (isset($riga['idRete']) && $riga['idRete']>0) {
        $dati['idRete'][$i]=$riga['idRete'];
        }
     }
     }     
    return $dati;
  }

// Calcola data corrispondente tot mesi prima
  function dataMesiPrima ($dataIn,$mesi) {
        $ggIn=substr($dataIn,6,2); $mmIn=substr($dataIn,4,2); $aaIn=substr($dataIn,0,4);
    	$ggAvv=$ggIn; $mmAvv=$mmIn-$mesi; $aaAvv=$aaIn;        
	    if ($mmAvv<=0){ $mmAvv=12+$mmAvv; $aaAvv=$aaIn-1;}     
	    $i1=""; if ($mmIn!=$mmAvv && $mmAvv<10){ $i1="0"; }
    	$i2=""; if ($ggIn!=$ggAvv && $ggAvv<10){ $i2="0"; }
        $newDataAvv=$aaAvv.$i1.$mmAvv.$i2.$ggAvv;

    return $newDataAvv;	
  }

// Visualizza estratto singolo evento
  function estratto_singolo($url,$i,$eventi,$formato){

    print "<br /><p>";
    print "<a href='".$url."eventi/?id=".$eventi['id'][$i]."'>";
    $locandina=$url."locandine/ico_".$eventi['img'][$i];
        if ($eventi['img'][$i]!="" && file_exists($locandina)) {
        print "<img src='".$locandina."' alt='Evento".$eventi['id'][$i]."' class='thumb sx' />";
        }
    $titolo=$this->mb_convert_encoding($eventi['titolo'][$i]);
    print "<h4><span class='rosso'>".$titolo."</span></h4></a>";
    
        $oggi=date("Ymd");
        if ($oggi>=$eventi['dataInizio'][$i] && $oggi<=$eventi['dataFine'][$i]) {
            print "Stato dell'evento: <span class='bianco sfVerde'> <b>IN CORSO!</b></span><br />"; }
        if ($oggi>=$eventi['dataAvv'][$i] && $oggi<$eventi['dataInizio'][$i]) {
            print "Stato dell'evento: <span class='rosso sfGiallo'> <b>IMMINENTE!</b></span><br />"; }
        if ($oggi>$eventi['dataFine'][$i] && $oggi<$eventi['dataOsc'][$i]) {
            print "Stato dell'evento: <span class='bianco sfArancio'> <b>PASSATO DA POCO</b></span><br />"; }
        if ($oggi>=$eventi['dataOsc'][$i]) {
            print "Stato dell'evento: <span class='bianco sfGrigio'> <b>PASSATO</b></span><br />"; }

        $zona=$this->mb_convert_encoding($eventi['zona'][$i]);
        print "Dove: <span class='nero'>".$zona."</span><br/>";    

            if ($eventi['dataInizio'][$i]!="") {
            print "Quando: dalle ore <span class='arancio'>".$eventi['oreInizio'][$i]."</span>";
                if ($eventi['dataInizio'][$i]==$eventi['dataFine'][$i]) {
                print " alle ore <span class='arancio'>".$eventi['oreFine'][$i]."</span> del giorno <span class='verde'>".$this->visData($eventi['dataFine'][$i])."</span>"; 
                }
                else {
                print " del <span class='verde'>".$this->visData($eventi['dataInizio'][$i])."</span> alle ore <span class='arancio'>".$eventi['oreFine'][$i]."</span> del <span class='verde'>".$this->visData($eventi['dataFine'][$i])."</span>";
                }	
        }
    
    $annoCfr=date("Y");
    if ($eventi['anno'][$i]!=$annoCfr){
        print "<br />Anno: <span class='verde'>".$eventi['anno'][$i]."</span>";
        }    

    if ($formato=="esteso"){
        $testo=$this->mb_convert_encoding($eventi['testo'][$i]);
        $testo=substr($testo,0,250);
        $testo=strip_tags($testo); // elimina tag html e frame
        print "<br /><br />".$testo."...</i> ";
    }// fine formato

    if ($formato!="esteso"){ print "<br />";}
        print " <a href='".$url."eventi/?id=".$eventi['id'][$i]."'>Vai alla pagina</a>";
        
    print "<br /></p>";

  }


} // fine classe
?>
