<?php
// registra accessi vetrine

// titolo: $titleStat

// url pagina
$urlPag=$_SERVER['SCRIPT_NAME']; //$_SERVER['PHP_SELF']; //$_SERVER['REQUEST_URI'];

//temp fix for REQUEST_URI
if ($_SERVER['QUERY_STRING'] != '') { 
   $urlPag .= '?'.$_SERVER['QUERY_STRING'];
}

// controlla se titolo già presente nel db
    $sql="SELECT idStat,idRete,url,title,visite FROM stat_reti WHERE title='".mysqli_real_escape_string($conn,stripslashes($title))."'";
    $query=mysqli_query($conn,$sql);			
	$riga=mysqli_fetch_array($query,MYSQLI_ASSOC);

	// 1. NUOVO RECORD
	if ($riga['idStat']=="" | $riga['visite']<=0){
    $tabella="stat_reti";
    $q['sel'][0]="idStat"; $q['val'][0]="";
    $q['sel'][1]="idRete"; $q['val'][1]=$idRete;
    $q['sel'][2]="title"; $q['val'][2]=mysqli_real_escape_string($conn,stripslashes($title));
    $q['sel'][3]="url"; $q['val'][3]=mysqli_real_escape_string($conn,stripslashes($urlPag));
    $q['sel'][4]="visite"; $q['val'][4]=1;
    //print $title.", nuovo";
    $db->tbl_insert($conn,$tabella,$q);

	} 	// 2. MODIFICA ESISTENTE
	else{
	$addVisit=$riga['visite']+1;
    $tabella="stat_reti";
    $q['sel'][0]="idRete"; $q['val'][0]=$riga['idRete'];
    $q['sel'][1]="title"; $q['val'][1]=mysqli_real_escape_string($conn,stripslashes($riga['title']));
    $q['sel'][2]="url"; $q['val'][2]=mysqli_real_escape_string($conn,stripslashes($riga['url']));
    $q['sel'][3]="visite"; $q['val'][3]=$addVisit;
    $where="idStat='".$riga['idStat']."'";
    //print $title.", visite:".$addVisit;
    $db->tbl_update($conn,$tabella,$q,$where);
	}

?>
