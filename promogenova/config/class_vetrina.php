<?php

// FUNZIONI DATABASE 

class mysql extends pagina{

// IDENTIFICA CLIENTE
  function identifica($conn,$urlCart,$conta){
    
    $arr=explode("/",$urlCart);
    $pen=count($arr)-$conta;
    $cartella=$arr[$pen];    
    
    $dati=array(
	"idAttivita" => array (""),
	"attivita" => array (""),
	"cartella" => array (""),    
	"logo" => array (""),
	"dataReg" => array (""),
	"dataScad" => array (""),
	"dataAvv" => array (""),
	"dataOsc" => array (""),

	"creaEventi" => array (""),
	"creaPromo" => array (""),
	"assistPeriod" => array (""),
	"vetrOmaggio" => array (""),

	"mappa" => array (""),
	"indirizzo" => array (""),
	"nciv" => array (""),
	"cap" => array (""),
	"idR" => array (""),
	"regione" => array (""),
	"idP" => array (""),
	"provincia" => array (""),
	"sigla" => array (""),
	"idC" => array (""),
	"comune" => array (""),
	"idM" => array (""),
	"municipio" => array (""),
	"idQ" => array (""),
	"quartiere" => array (""),
	"altraZona" => array (""),

	"ragsoc" => array (""),
	"partitaiva" => array (""),
	"codfisc" => array (""),
	"chisiamo" => array (""),
	"orari" => array (""),

	"msgID" => array ("")
	);
    $dati['msgID'][0]=""; // errori GRAVI da cartelle e/o database
    $oggi=date("Ymd"); // data oggi

    // dati identificativi
    $sql="SELECT attivita.idAttivita,osc,cartella,dataOsc 
    FROM vetrine,attivita,att_scad 
    WHERE vetrine.idAttivita=attivita.idAttivita
    AND att_scad.idAttivita=attivita.idAttivita 
    AND cartella ='".mysqli_real_escape_string($conn,stripslashes($cartella))."'";
    $query=mysqli_query($conn,$sql);			
    $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);

        // cartella
        $cartella="";
        $urlCart="../".$riga['cartella'];
        if(isset($riga['cartella']) && $riga['cartella']!="" && is_dir($urlCart)){
        $cartella=$riga['cartella']; 
        $dati['cartella'][0]=$riga['cartella']; 
        }else{ $dati['msgID'][0]="no-cartella"; }

        // oscuramento
        $osc="";
        if(isset($riga['osc']) && $riga['osc']!=""){
    	$osc=$riga['osc']; 
    	$dati['osc'][0]=$riga['osc']; 
        } else{ $dati['msgID'][0]="no-osc"; }        

        if($osc=="s"){ $dati['msgID'][0]="oscurato"; }       

        // id
        $idAttivita=0;
        if(isset($riga['idAttivita']) && $riga['idAttivita']!=""){
    	$idAttivita=$riga['idAttivita']; 
    	$dati['idAttivita'][0]=$riga['idAttivita']; 
        } else{ $dati['msgID'][0]="no-idAttivita"; }

        // data scadenza
        $dataOsc=""; 
        if(isset($riga['dataOsc']) && $riga['dataOsc']!=""){
    	$dataOsc=$riga['dataOsc']; 
    	$dati['dataOsc'][0]=$riga['dataOsc']; 
        } else{ $dati['msgID'][0]="no-dataOsc"; }
        
        if($oggi>$dataOsc){ $dati['msgID'][0]="scaduto"; }       
        
    if($dati['msgID'][0]==""){

    // dati attivita
    $sql="SELECT attivita FROM attivita WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $dati['attivita'][0]=$row['attivita'];
    
    $sql="SELECT dataScad,dataAvv FROM att_scad WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $dati['dataScad'][0]=$row['dataScad'];
    $dati['dataAvv'][0]=$row['dataAvv'];

    $sql="SELECT dataReg,vetrOmaggio,creaEventi,assistPeriod,creaPromo FROM att_clienti WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $dati['dataReg'][0]=$row['dataReg'];
    $dati['vetrOmaggio'][0]=$row['vetrOmaggio'];
    $dati['creaEventi'][0]=$row['creaEventi'];
    $dati['assistPeriod'][0]=$row['assistPeriod'];
    $dati['creaPromo'][0]=$row['creaPromo'];

    $sql="SELECT ragsoc,partitaiva,codfisc FROM att_ragsoc WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);	  		
    $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $dati['ragsoc'][0]=$row['ragsoc'];
    $dati['partitaiva'][0]=$row['partitaiva'];
    $dati['codfisc'][0]=$row['codfisc'];
    
    $sql="SELECT mappa FROM att_map WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $dati['mappa'][0]=$row['mappa'];

    $sql="SELECT indirizzo,nciv,cap,idR,idP,idC,idM,idQ,altro FROM att_indirizzi WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $dati['indirizzo'][0]=$row['indirizzo'];
    $dati['nciv'][0]=$row['nciv'];
    $dati['cap'][0]=$row['cap'];
    $dati['idR'][0]=$row['idR'];
    $dati['idP'][0]=$row['idP'];
    $dati['idC'][0]=$row['idC'];
    $dati['idM'][0]=$row['idM'];
    $dati['idQ'][0]=$row['idQ'];
    $dati['altraZona'][0]=$row['altro'];

    if ($dati['idR'][0]>0) {
        $sql1="SELECT regione FROM regioni WHERE idR='".$dati['idR'][0]."'";
        $query1=mysqli_query($conn,$sql1);	  
        $q=mysqli_fetch_array($query1,MYSQLI_ASSOC);    		
        $dati['regione'][0]=$q['regione'];
        }

    if ($dati['idP'][0]>0) {
        $sql1="SELECT provincia,sigla FROM province WHERE idP='".$dati['idP'][0]."'";
        $query1=mysqli_query($conn,$sql1);	  
        $q=mysqli_fetch_array($query1,MYSQLI_ASSOC);    		
        $dati['provincia'][0]=$q['provincia'];
        $dati['sigla'][0]=$q['sigla'];
        }

    if ($dati['idC'][0]>0) {
        $sql1="SELECT comune FROM comuni WHERE idC='".$dati['idC'][0]."'";
        $query1=mysqli_query($conn,$sql1);	  
        $q=mysqli_fetch_array($query1,MYSQLI_ASSOC);    		
        $dati['comune'][0]=$q['comune'];
        }

    if ($dati['idM'][0]>0) {
        $sql1="SELECT municipio FROM municipi WHERE idM='".$dati['idM'][0]."'";
        $query1=mysqli_query($conn,$sql1);	  
        $q=mysqli_fetch_array($query1,MYSQLI_ASSOC);    		
        $dati['municipio'][0]=$q['municipio'];
        }

    if ($dati['idQ'][0]>0) {
        $sql1="SELECT quartiere FROM quartieri WHERE idQ='".$dati['idQ'][0]."'";
        $query1=mysqli_query($conn,$sql1);	  
        $q=mysqli_fetch_array($query1,MYSQLI_ASSOC);    		
        $dati['quartiere'][0]=$q['quartiere'];
        }

    $sql="SELECT logo FROM vetrine WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);	  		
    $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $dati['logo'][0]=$row['logo'];
    
    $sql="SELECT chisiamo FROM vetrine_chisiamo WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);	  		
    $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $dati['chisiamo'][0]=$row['chisiamo'];

    $sql="SELECT orari FROM vetrine_orari WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);	  		
    $row=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $dati['orari'][0]=$row['orari'];
    }

return $dati;
}

// MODULI DINAMICI OUTPUT

// contatti-telefonici
  function telef($conn,$url,$idAttivita){    
    $sql="SELECT tipo,numero FROM vetrine_telefoni WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $icona="";
        switch ($q['tipo']){ 
        	case "Tel.": $icona="tel.png"; break;
        	case "Cell.": $icona="cell.png"; break;
        	case "Fax": $icona="fax.png"; break;
        }
    print "<img src='".$url."/ico/".$icona."' alt='".$q['tipo']."' title='".$q['tipo']."' /> ";
    print "<span itemprop='telephone'>".$q['numero']."</span><br />";
    }    
  }
// email
  function email($conn,$url,$idAttivita){
    $sql="SELECT email FROM vetrine_email WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    print "<a href='mailto:".$q['email']."'><img src='".$url."/ico/email.png' alt='email' /> e-mail</a><br />";
    }    
  }
// social
  function social($conn,$url,$idAttivita){
    $sql="SELECT social,account,url FROM vetrine_social WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    print "<a href='".$q['url']."'>";
        $icona="";
        switch ($q['social']){ 
        	case "Facebook": $icona="facebook.png"; break;
        	case "Twitter": $icona="twitter.png"; break;
        	case "You Tube": $icona="youtube.png"; break;
        	case "Google Plus": $icona="googleplus.png"; break;
        	case "Pinterest": $icona="pinterest.png"; break;
        	case "Linkedin": $icona="linkedin.png"; break;
        	case "Foursquare": $icona="foursquare.png"; break;
        	case "Flickr": $icona="flickr.png"; break;
        	case "Instagram": $icona="instagram.png"; break;
        	case "Messenger": $icona="windows-messenger.png"; break;
        	case "Skype": $icona="skype.png"; break;
        }
    print " <img src='".$url."/ico/".$icona."' alt='".$q['social']."' title='".$q['social']."' /> ";
    print $q['account']."</a><br />";
    }    
  }

// siti e pagine
  function conta_siti($conn,$idAttivita){
    $tot=0;
    $sql="SELECT url FROM vetrine_siti WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ $tot++; }    
    return $tot;
  }

  function siti($conn,$url,$idAttivita){
    $sql="SELECT tipo,url FROM vetrine_siti WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    print "<a href='".$q['url']."'>";
        $icona="";
        switch ($q['tipo']){ 
        	case "Sito": $icona="sito.png"; break;
        	case "Sito e-commerce": $icona="ecommerce.png"; break;
        	case "Pagina facebook": $icona="facebook.png"; break;
        	case "Gruppo facebook": $icona="facebook.png"; break;
        	case "Blog": $icona="blogger.png"; break;
        }
    print " <img src='".$url."/ico/".$icona."' alt='".$q['tipo']."' title='".$q['tipo']."' /> ";
    print "<span itemprop='url'>".$q['tipo']."</span></a><br />";
    }    
  }

  function banner($conn,$url,$idAttivita,$cartella){
    $tot=0;
    $sql="SELECT tipo,descriz,url,banner FROM vetrine_siti WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $imgsito=$url.$cartella."/".$q['banner'];
        if (file_exists($imgsito) && $q['banner']!=""){
        $banner['tipo'][]=$q['tipo'];
        $banner['descriz'][]=$q['descriz'];
        $banner['url'][]=$q['url'];
        $banner['banner'][]=$q['banner'];
        $tot++;
        }
    }  
    $banner['totBanner'][0]=$tot;
    return $banner;  
  }


// reti collegate
  function conta_reti($conn,$idAttivita){
    $tot=0;
    $sql="SELECT idRete FROM vetrine_reti WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ $tot++; }    
    return $tot;
  }

  function reti($conn,$url,$idAttivita){
    $sql="SELECT reti.idRete,rete FROM vetrine_reti,reti WHERE vetrine_reti.idRete=reti.idRete AND idAttivita='".$idAttivita."' ORDER BY rete ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    print "<a href='".$url."reti/scheda.php?idRete=".$q['idRete']."'>";
    $nome=$this->mb_convert_encoding($q['rete']);
    print $nome."</a><br />";
    }    
  }

// foto
  function conta_foto($conn,$url,$cartella,$idAttivita){
    $tot=0;
    $sql="SELECT foto FROM vetrine_foto WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ 
       $foto=$url.$cartella."/foto/".$q['foto'];
       if ($q['foto']!="" && file_exists($foto)) { $tot++; }
       }    
    return $tot;
  }

  function foto($conn,$url,$cartella,$idAttivita,$where){
    $sql="SELECT id,foto,didasc FROM vetrine_foto WHERE idAttivita='".$idAttivita."' ".$where;
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ 
       $urlFoto=$url.$cartella."/foto/".$q['foto'];
       if ($q['foto']!="" && file_exists($urlFoto)) { 
            $foto['id'][]=$q['id'];
            $foto['foto'][]=$q['foto']; 
            $foto['didasc'][]=$q['didasc']; 
            }
       }    
    return $foto;
  }

// conta eventi
  function conta_eventi($conn,$idAttivita){
    $tot=0;
    $sql="SELECT id FROM eventi_promot WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ $tot++; }    
    return $tot;
  }

  function eventi($conn,$idAttivita){
    $sql="SELECT eventi.id,titolo,img, anno,dataInizio,oreInizio,dataFine,oreFine,dataAvv,dataOsc
    FROM eventi,eventi_promot,eventi_dateore 
    WHERE eventi.id=eventi_promot.id
    AND eventi.id=eventi_dateore.id
    AND idAttivita='".$idAttivita."' 
    ORDER BY dataFine DESC, oreFine DESC, anno DESC, eventi.id DESC, titolo ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $eventi['id'][]=$q['id'];
    $eventi['titolo'][]=$q['titolo'];
    $eventi['img'][]=$q['img'];
    $eventi['anno'][]=$q['anno'];
    $eventi['dataInizio'][]=$q['dataInizio'];
    $eventi['oreInizio'][]=$q['oreInizio'];
    $eventi['dataFine'][]=$q['dataFine'];
    $eventi['oreFine'][]=$q['oreFine'];
    $eventi['dataAvv'][]=$q['dataAvv'];
    $eventi['dataOsc'][]=$q['dataOsc'];
    }
    return $eventi;
  }

// conta articoli
  function conta_articoli($conn,$idAttivita){
    $tot=0;
    $sql="SELECT articoli.idArt FROM articoli,articoli_dat WHERE articoli.idArt=articoli_dat.idArt AND osc='n' AND idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ $tot++; }    
    return $tot;
  }

  function articoli($conn,$idAttivita){
    $sql="SELECT articoli.idArt,dataReg,osc,img,titolo,articoli_dat.idMacro,macro,testo
    FROM articoli,articoli_dat,macro,articoli_txt
    WHERE osc='n'  
    AND articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro  
    AND idAttivita='".$idAttivita."' 
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
    }    
    return $articoli;
  }

// conta video
  function conta_video($conn,$idAttivita){
    $tot=0;
    $sql="SELECT id FROM vetrine_video WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ $tot++; }    
    return $tot;
  }

  function video_vetrina($conn,$idAttivita){
    $sql="SELECT id,video FROM vetrine_video WHERE idAttivita='".$idAttivita."' ORDER BY id DESC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ 
       $video['id'][]=$q['id'];
       $video['video'][]=$q['video'];
       }    
    return $video;
  }

// conta marchi
  function conta_marchi($conn,$idAttivita){
    $tot=0;
    $sql="SELECT id FROM vetrine_marchi WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ $tot++; }    
    return $tot;
  }

  function marchi($conn,$idAttivita){
    $sql="SELECT marchio FROM vetrine_marchi WHERE idAttivita='".$idAttivita."' ORDER BY marchio ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ 
       $marchi['marchio'][]=$q['marchio'];
       }    
    return $marchi;
  }

// conta parole
  function conta_parole($conn,$idAttivita){
    $tot=0;
    $sql="SELECT id FROM vetrine_tag WHERE idAttivita='".$idAttivita."'";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ $tot++; }    
    return $tot;
  }

  function parole($conn,$idAttivita){
    $sql="SELECT parola FROM vetrine_tag WHERE idAttivita='".$idAttivita."' ORDER BY parola ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){ 
       $parole['parola'][]=$q['parola'];
       }    
    return $parole;
  }


} //chiude classe
?>
