<?php
// admin clienti
class mysql extends pagina{
    
// formatta testo per salvataggio con caratteri utf8
    function formattaTxt($t) {

    $t = stripslashes($t); // no barre #1
    $t=trim($t); // togli spazi ai lati
    $virg=chr(34); 
    $t = str_replace($virg, "''", $t); // sostituisci virgolette    
    $barre=chr(92); // no barre #2
    $t = str_replace($barre, "", $t);

        $t=str_replace("&agrave;", "�", $t); $t=str_replace("&Agrave;", "�", $t);
        $t=str_replace("&egrave;", "�", $t); $t=str_replace("&Egrave;", "�", $t);
        $t=str_replace("&eacute;", "�", $t); $t=str_replace("&Eacute;", "�", $t);
        $t=str_replace("&igrave;", "�", $t); $t=str_replace("&Igrave;", "�", $t);
        $t=str_replace("&ograve;", "�", $t); $t=str_replace("&Ograve;", "�", $t);
        $t=str_replace("&ugrave;", "�", $t); $t=str_replace("&Ugrave;", "�", $t);

        $t=str_replace("� ", "a' ", $t); $t=str_replace("�.", "a'.", $t); $t=str_replace("�", "a", $t);
        $t=str_replace("� ", "e' ", $t); $t=str_replace("�.", "e'.", $t); $t=str_replace("�", "e", $t);
        $t=str_replace("� ", "e' ", $t); $t=str_replace("�.", "e'.", $t); $t=str_replace("�", "e", $t);
        $t=str_replace("� ", "i' ", $t); $t=str_replace("�.", "i'.", $t); $t=str_replace("�", "i", $t);
        $t=str_replace("� ", "o' ", $t); $t=str_replace("�.", "o'.", $t); $t=str_replace("�", "o", $t);
        $t=str_replace("� ", "u' ", $t); $t=str_replace("�.", "u'.", $t); $t=str_replace("�", "u", $t);

        $t=str_replace("� ", "A' ", $t); $t=str_replace("�.", "A'.", $t); $t=str_replace("�", "A", $t);
        $t=str_replace("� ", "E' ", $t); $t=str_replace("�.", "E'.", $t); $t=str_replace("�", "E", $t);
        $t=str_replace("� ", "E' ", $t); $t=str_replace("�.", "E'.", $t); $t=str_replace("�", "E", $t);
        $t=str_replace("� ", "I' ", $t); $t=str_replace("�.", "I'.", $t); $t=str_replace("�", "I", $t);
        $t=str_replace("� ", "O' ", $t); $t=str_replace("�.", "O'.", $t); $t=str_replace("�", "O", $t);
        $t=str_replace("� ", "U' ", $t); $t=str_replace("�.", "U'.", $t); $t=str_replace("�", "U", $t);

        $t=str_replace("&","e", $t);
        $t=str_replace("#"," ", $t);
        $t=str_replace("|", "", $t); $t=str_replace("`","'", $t); 
		$t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t);
        $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t);
        $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t);
        $t=str_replace("�"," ", $t); 
        $t=str_replace("�"," ", $t); $t=str_replace("�","-", $t); $t=str_replace("�"," ", $t);
        $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t);
        $t=str_replace("�","2", $t); $t=str_replace("�","3", $t); $t=str_replace("�","'", $t);
        $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t);
        $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t);
        $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t);
        $t=str_replace("�"," ", $t); $t=str_replace("�"," ", $t);
       return $t;
   }



// riconosci articolo cliente
function cliente_articolo($idArt){
    $sql="SELECT idAttivita
    FROM articoli_dat
    WHERE 
    idArt='".$idArt."'";
    $query=mysql_query($sql);			
    $q=mysql_fetch_array($query);
    return $q['idAttivita'];
}

// tutti gli articoli del cliente
function elenco_articoli($idAttivita,$url,$cartella){    
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
    ORDER BY idArt DESC, titolo ASC, dataReg DESC";
    $query=mysql_query($sql);			
    while($q=mysql_fetch_array($query)){
    $articoli['idArt'][]=$q['idArt'];
    $articoli['dataReg'][]=$q['dataReg'];
    $articoli['osc'][]=$q['osc'];
    $articoli['img'][]=$q['img'];
    $articoli['titolo'][]=$q['titolo'];
    $articoli['idMacro'][]=$q['idMacro'];
    $articoli['macro'][]=$q['macro'];
    $articoli['testo'][]=$q['testo'];
    
       $dirFile=$url.$cartella."/articoli/";
       $imgFile=$dirFile."/".$q['img'];
       $thumb=$url.$cartella."/articoli/th_".$q['img'];
       $icoarticoli=$url.$cartella."/articoli/ico_".$q['img'];
       if (file_exists($imgFile)) { 
       $totArticoli++;
            if (!file_exists($thumb)) { 
            $this->creathumb($dirFile,$q['img'],200,200,$dirFile,"th_");
            }
            if (!file_exists($icoarticoli)) {   
            $this->creathumb($dirFile,$q['img'],48,48,$dirFile,"ico_");
            }
       }
  }

  $articoli['totArticoli'][0]=$totArticoli;
  return $articoli;
}

// riconosci evento cliente
function cliente_eventi($id,$idAttivita){
    $sql="SELECT idAttivita
    FROM eventi_promot
    WHERE 
    id='".$id."' AND idAttivita='".$idAttivita."'";
    $query=mysql_query($sql);			
    $q=mysql_fetch_array($query);
    return $q['idAttivita'];
}

// tutti gli eventi del cliente
function elenco_eventi($idAttivita,$url){    
$totEventi=0;

    $eventi=array(
	"id" => array (""),
	"titolo" => array (""),
	"img" => array (""),
	"anno" => array (""),
	"dataInizio" => array (""),
	"oreInizio" => array (""),
	"dataFine" => array (""),
	"oreFine" => array (""),
	"dataAvv" => array (""),
	"dataOsc" => array (""),
    "totEventi" => array ("")
    );

    $sql="SELECT eventi.id,titolo,anno,dataInizio,oreInizio,dataFine,oreFine,dataAvv,dataOsc
    FROM eventi,eventi_promot,eventi_dateore 
    WHERE eventi.id=eventi_promot.id
    AND eventi.id=eventi_dateore.id
    AND idAttivita='".$idAttivita."' 
    ORDER BY eventi.id DESC, titolo ASC";
    $query=mysql_query($sql);			
    while($q=mysql_fetch_array($query)){
    $eventi['id'][]=$q['id'];
    $eventi['titolo'][]=$q['titolo'];
    $eventi['anno'][]=$q['anno'];
    $eventi['dataInizio'][]=$q['dataInizio'];
    $eventi['oreInizio'][]=$q['oreInizio'];
    $eventi['dataFine'][]=$q['dataFine'];
    $eventi['oreFine'][]=$q['oreFine'];
    $eventi['dataAvv'][]=$q['dataAvv'];
    $eventi['dataOsc'][]=$q['dataOsc'];

	$locandina="";
		$sql1="
		SELECT img 
		FROM media,media_link 
		WHERE media_link.idMedia=media.idMedia
		AND media_link.id='".$q['id']."'
		";
		$query1=mysql_query($sql1);			
		$row=mysql_fetch_array($query1);
            if ($row['img']!="" ) { 
				$locandina=$row['img']; 
				}
	$eventi['img'][]=$locandina;
    $totEventi++;
  }

  $eventi['totEventi'][0]=$totEventi;
  return $eventi;
}

// fine
}
?>
