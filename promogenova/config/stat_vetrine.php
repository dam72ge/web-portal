<?php
// registra accessi vetrine

// url pagina
$urlPag=$_SERVER['SCRIPT_NAME']; //$_SERVER['PHP_SELF']; //$_SERVER['REQUEST_URI'];

//temp fix for REQUEST_URI
if ($_SERVER['QUERY_STRING'] != '') { 
   $urlPag .= '?'.$_SERVER['QUERY_STRING'];
}


// controlla se titolo già presente nel db
    $sql="SELECT idStat,title,url,tipo,visite,idAttivita,idArt FROM stat_vetrine WHERE title ='".mysqli_real_escape_string($conn,stripslashes($title))."'";
    $query=mysqli_query($conn,$sql);			
	$riga=mysqli_fetch_array($query,MYSQLI_ASSOC);

	if (!isset($idArt)){ $idArt=0; } 

	// 1. NUOVO RECORD
	if ($riga['idStat']=="" | $riga['visite']<=0){
    $tabella="stat_vetrine";
    $q['sel'][0]="idStat"; $q['val'][0]="";
    $q['sel'][1]="title"; $q['val'][1]=mysqli_real_escape_string($conn,stripslashes($title));
    $q['sel'][2]="url"; $q['val'][2]=mysqli_real_escape_string($conn,stripslashes($urlPag));
    $q['sel'][3]="tipo"; $q['val'][3]=$tipoPag;
    $q['sel'][4]="visite"; $q['val'][4]=1;
    $q['sel'][5]="idAttivita"; $q['val'][5]=$vetrina['idAttivita'][0];
    $q['sel'][6]="idArt"; $q['val'][6]=$idArt;
    $db->tbl_insert($conn,$tabella,$q);
	} 	// 2. MODIFICA ESISTENTE
	else{
	$addVisit=$riga['visite']+1;
    $tabella="stat_vetrine";
    $q['sel'][0]="title"; $q['val'][0]=mysqli_real_escape_string($conn,stripslashes($title));
    $q['sel'][1]="url"; $q['val'][1]=mysqli_real_escape_string($conn,stripslashes($urlPag));
    $q['sel'][2]="tipo"; $q['val'][2]=$tipoPag;
    $q['sel'][3]="visite"; $q['val'][3]=$addVisit;
    $q['sel'][4]="idAttivita"; $q['val'][4]=$vetrina['idAttivita'][0];
    $q['sel'][5]="idArt"; $q['val'][5]=$idArt;
    $where="idStat='".$riga['idStat']."'";
    $db->tbl_update($conn,$tabella,$q,$where);
	}

?>
