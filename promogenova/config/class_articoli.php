<?php
// articoli
class myart extends pagina{
    
// riconosci articolo cliente
function cliente_articolo($conn,$idArt){
    $sql="SELECT idAttivita
    FROM articoli_dat
    WHERE 
    idArt='".$idArt."'";
    $query=mysqli_query($conn,$sql);			
    $q=mysqli_fetch_array($query,MYSQLI_ASSOC);
    return $q['idAttivita'];
    }

// tutti gli articoli del cliente
function elenco_articoli($conn,$idAttivita,$where){    
    $totArticoli=0;

    $articoli=array(
	"idArt" => array (""),
	"dataReg" => array (""),
	"osc" => array (""),
	"img" => array (""),
	"titolo" => array (""),
	"idMacro" => array (""),
	"macro" => array (""),
	"testo" => array (""),
    "totArticoli" => array ("")
    );

    $sql="SELECT articoli.idArt,dataReg,osc,img,titolo,articoli_dat.idMacro,macro,testo
    FROM articoli,articoli_dat,macro,articoli_txt
    WHERE articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro  
    AND idAttivita='".$idAttivita."' 
    ".$where." 
    ORDER BY idArt DESC, titolo ASC, dataReg DESC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $articoli['idArt'][]=$q['idArt'];
        $articoli['dataReg'][]=$q['dataReg'];
        $articoli['osc'][]=$q['osc'];
        $articoli['img'][]=$q['img'];
        $articoli['titolo'][]=$q['titolo'];
        $articoli['idMacro'][]=$q['idMacro'];
        $articoli['macro'][]=$q['macro'];
        $articoli['testo'][]=$q['testo'];    
        $articoli['totArticoli'][0]=$totArticoli;
        }
    return $articoli;
    }

// singola macro
function macro($conn,$idMacro){    
    $sql="SELECT idMacro,macro
    FROM macro
    WHERE idMacro='".$idMacro."' ";
    $query=mysqli_query($conn,$sql);			
    $q=mysqli_fetch_array($query,MYSQLI_ASSOC);
    return $q;
    }

// singolo articolo
function articolo($conn,$idArt){    
    $sql="SELECT articoli.idArt,dataReg,osc,img,titolo,articoli_dat.idMacro,macro,testo
    FROM articoli,articoli_dat,macro,articoli_txt
    WHERE articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro  
    AND articoli.idArt='".$idArt."' ";
    $query=mysqli_query($conn,$sql);			
    $q=mysqli_fetch_array($query,MYSQLI_ASSOC);
    return $q;
    }



// tutti gli articoli per macro
function articoli_per_macro($conn,$idMacro){    
    $totArticoli=0;
    $oggi=date("Ymd");

    $articoli=array(
	"idArt" => array (""),
	"img" => array (""),
	"titolo" => array (""),
	"idMacro" => array (""),
	"macro" => array (""),
	"idAttivita" => array (""),
	"attivita" => array (""),
	"cartella" => array ("")
    );

    $sql="SELECT articoli.idArt,img,titolo, articoli_dat.idMacro,macro, attivita.idAttivita,attivita,dataOsc,cartella 

    FROM articoli,articoli_dat,macro,articoli_txt, attivita,att_scad,vetrine

    WHERE articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro  

    AND articoli_dat.idAttivita=attivita.idAttivita  
    AND attivita.idAttivita=att_scad.idAttivita  
    AND attivita.idAttivita=vetrine.idAttivita  

    AND att_scad.osc='n' 
    AND articoli.osc='n' 
    AND macro.idMacro='".$idMacro."' 
    ORDER BY idArt DESC, titolo ASC, attivita ASC";
    $query=mysqli_query($conn,$sql);		
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if($oggi<=$q['dataOsc']){
            $articoli['idArt'][]=$q['idArt'];
            $articoli['img'][]=$q['img'];
            $articoli['titolo'][]=$q['titolo'];
            $articoli['idMacro'][]=$q['idMacro'];
            $articoli['macro'][]=$q['macro'];
            $articoli['idAttivita'][]=$q['idAttivita'];    
            $articoli['attivita'][]=$q['attivita'];    
            $articoli['cartella'][]=$q['cartella'];    
            }
        }
    return $articoli;
    }


// tutti gli articoli per macro+zona
function articoli_macrozona($conn,$tabZona,$where,$orderby){    
    $totArticoli=0;
    $oggi=date("Ymd");

    $articoli=array(
	"idArt" => array (""),
	"img" => array (""),
	"titolo" => array (""),
	"idMacro" => array (""),
	"macro" => array (""),
	"idAttivita" => array (""),
	"attivita" => array (""),
	"cartella" => array ("")
    );

    $sql="SELECT articoli.idArt,img,titolo, articoli_dat.idMacro,macro, attivita.idAttivita,attivita,dataOsc,cartella

    FROM articoli,articoli_dat,macro,articoli_txt, attivita,att_scad,vetrine ".$tabZona." 

    WHERE articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro  

    AND articoli_dat.idAttivita=attivita.idAttivita  
    AND attivita.idAttivita=att_scad.idAttivita  
    AND attivita.idAttivita=vetrine.idAttivita    

    AND att_scad.osc='n' 
    AND articoli.osc='n' 
    ".$where." ".$orderby;
        
    $query=mysqli_query($conn,$sql);		
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if(isset($q['idArt']) && $q['idArt']>0 && $oggi<=$q['dataOsc']){
            $articoli['idArt'][]=$q['idArt'];
            $articoli['img'][]=$q['img'];
            $articoli['titolo'][]=$q['titolo'];
            $articoli['idMacro'][]=$q['idMacro'];
            $articoli['macro'][]=$q['macro'];
            $articoli['idAttivita'][]=$q['idAttivita'];    
            $articoli['attivita'][]=$q['attivita'];    
            $articoli['cartella'][]=$q['cartella'];    
            }
        }
    return $articoli;
    }

// fine classe
}
?>
