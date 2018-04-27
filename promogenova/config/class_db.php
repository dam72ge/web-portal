<?php
// classe database - generici e lettura tutte le tabelle
class db {


// 1. GENERICI
// insert
function tbl_insert($conn,$tabella,$q){
    
    $tot=count($q['val']); // array
    $selettori="";
    $valori="";

    if ($tot>1) {
        for($i=0;$i<$tot;$i++){
        $selettori.=$q['sel'][$i];
        $valori.="'".mysqli_real_escape_string($conn,stripslashes($q['val'][$i]))."'";
        if ($i<($tot-1)) { $selettori.=","; $valori.=",";}
        }
    }
    else{
        $selettori.=$q['sel'][$i];
        $valori="'".mysqli_real_escape_string($conn,stripslashes($q['val'][0]))."'";
    }
        
    $sql = "INSERT INTO ".$tabella." ( ".$selettori." ) VALUES ( ".$valori." )";
    //print $sql."<br /><br />"; 
    $query=mysqli_query($conn,$sql);
}

// update
function tbl_update($conn,$tabella,$q,$where){
    
    $tot=count($q['val']); // array
    $settaggio="";

    if ($tot>1) {
        for($i=0;$i<$tot;$i++){
        $settaggio.=$q['sel'][$i]."='".mysqli_real_escape_string($conn,stripslashes($q['val'][$i]))."'";
        if ($i<($tot-1)) { $settaggio.=","; }
        }
    }
    else{
        $settaggio.=$q['sel'][0]."='".mysqli_real_escape_string($conn,stripslashes($q['val'][0]))."'";
    }

    $sql="UPDATE ".$tabella." SET ".$settaggio." WHERE ".$where;
    $query=mysqli_query($conn,$sql);
}
// delete
function tbl_delete($conn,$tabella,$where){
    $sql="DELETE FROM ".$tabella." WHERE ".$where; $query=mysqli_query($conn,$sql); 
}




// 2. TERRITORIO
// regioni
  function regioni($conn,$where,$orderby){    
    $dati=array(
	"idR" => array (""),
	"regione" => array ("")
    );
    $sql="
    SELECT idR,regione 
    FROM regioni 
    ".$where." ".$orderby;
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idR'][]=$riga['idR'];
        $dati['regione'][]=$riga['regione'];
    }
    return $dati;
  }



// 3. CATEGORIE
// 4. EVENTI - Promogenova
// 5. ALBUM - Promogenova
// 6. VIDEO - Promogenova
// 7. RETI 
// 8. ATTIVITA' CLIENTI
	
} // chiude classe
?>
