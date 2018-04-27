<?php
// registra accessi vetrine

// url pagina
$urlPag=$_SERVER['SCRIPT_NAME']; //$_SERVER['PHP_SELF']; //$_SERVER['REQUEST_URI'];

//temp fix for REQUEST_URI
if ($_SERVER['QUERY_STRING'] != '') { 
   $urlPag .= '?'.$_SERVER['QUERY_STRING'];
}

// controlla se titolo già presente nel db
    $where="title='".mysqli_real_escape_string($conn,stripslashes($title))."'";
    $selAttivita=0; $selRete=0;
    switch ($tipoPag){ 
        case "evento-cliente":
        $selAttivita=$promotAttivita; $selRete=0;
        $where.=" AND idAttivita='".mysqli_real_escape_string($conn,stripslashes($selAttivita))."'";
        break;
        case "evento-rete":
        $selAttivita=0; $selRete=$promotRete;
        $where.=" AND idRete='".mysqli_real_escape_string($conn,stripslashes($selRete))."'";
        break;
    }    

    $sql="SELECT idStat,id,title,url,visite,idAttivita,idRete FROM stat_eventi WHERE ".$where;
    $query=mysqli_query($conn,$sql);			
	$riga=mysqli_fetch_array($query,MYSQLI_ASSOC);

	// 1. NUOVO RECORD
	if ($riga['idStat']=="" && $riga['visite']<=0){
    $tabella="stat_eventi";
    $q['sel'][0]="idStat"; $q['val'][0]="";
    $q['sel'][1]="id"; $q['val'][1]=$id;
    $q['sel'][2]="title"; $q['val'][2]=mysqli_real_escape_string($conn,stripslashes($title));
    $q['sel'][3]="url"; $q['val'][3]=mysqli_real_escape_string($conn,stripslashes($urlPag));
    $q['sel'][4]="visite"; $q['val'][4]=1;
    $q['sel'][5]="idAttivita"; $q['val'][5]=$selAttivita;
    $q['sel'][6]="idRete"; $q['val'][6]=$selRete;
    $db->tbl_insert($conn,$tabella,$q);
	} 	
    
    // 2. MODIFICA ESISTENTE
    else{
	$addVisit=$riga['visite']+1;
    $tabella="stat_eventi";
    $q['sel'][0]="id"; $q['val'][0]=$id;
    $q['sel'][1]="title"; $q['val'][1]=mysqli_real_escape_string($conn,stripslashes($riga['title']));
    $q['sel'][2]="url"; $q['val'][2]=mysqli_real_escape_string($conn,stripslashes($riga['url']));
    $q['sel'][3]="visite"; $q['val'][3]=$addVisit;
    $q['sel'][4]="idAttivita"; $q['val'][4]=$selAttivita;
    $q['sel'][5]="idRete"; $q['val'][5]=$selRete;
    $where="idStat='".$riga['idStat']."' AND idAttivita='".mysqli_real_escape_string($conn,stripslashes($selAttivita))."' AND idRete='".mysqli_real_escape_string($conn,stripslashes($selRete))."'";
    //print $id.", att=".$selAttivita.", rete=".$selRete.", vis=".$riga['visite']."->".$addVisit;
    $db->tbl_update($conn,$tabella,$q,$where);
	}

?>
