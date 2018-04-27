<?php
// FUNZIONI STRUTTURA PAGINA

class pagina{

// codifica-utf8
   function mb_convert_encoding($t) {
	$t = mb_convert_encoding($t, 'UTF-8');	   
    $t = str_replace("&gt;", ">", $t);
    $t = str_replace("&lt;", "<",  $t);  
    $virg=chr(34); 
    $t = str_replace("''", $virg, $t); 
	return $t;
   }

// decodifica-utf8
function charset_decode_utf_8 ($string) {
    $string = stripslashes($string);
    $string=trim($string);

	/* Only do the slow convert if there are 8-bit characters */
    /* avoid using 0xA0 (\240) in ereg ranges. RH73 does not like that */
    if (!preg_match("/[\200-\237]/", $string)
     && !preg_match("/[\241-\377]/", $string)
    ) {
        return $string;
    }

    // decode three byte unicode characters
    $string = preg_replace("/([\340-\357])([\200-\277])([\200-\277])/e",
        "'&#'.((ord('\\1')-224)*4096 + (ord('\\2')-128)*64 + (ord('\\3')-128)).';'",
        $string
    );

    // decode two byte unicode characters
    $string = preg_replace("/([\300-\337])([\200-\277])/e",
        "'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'",
        $string
    );

	// keep html codes
    $string = str_replace(">", "&gt;", $string); 
    $string = str_replace("<", "&lt;", $string); 
    
    return $string;
    }






// date from numeric format (20090523) to day month year (23 maggio 2009)
   function visData($fd) {
   $mm['01']="Gennaio"; $mm['02']="Febbraio"; $mm['03']="Marzo";
   $mm['04']="Aprile"; $mm['05']="Maggio"; $mm['06']="Giugno";
   $mm['07']="Luglio"; $mm['08']="Agosto"; $mm['09']="Settembre";
   $mm['10']="Ottobre"; $mm['11']="Novembre"; $mm['12']="Dicembre";
   $mese=substr($fd,4,2);
   $fd=substr($fd,6,2)." ".$mm[$mese]." ".substr($fd,0,4);
   return $fd;
   }

// date - from day month year  (es. 2014 7 1) to numerico format (20140701)
   function visDataNum($aa,$mm,$gg) {
   $dataNum=$aa;
   if ($mm<10) { $dataNum.="0"; } $dataNum.=$mm;
   if ($gg<10) { $dataNum.="0"; } $dataNum.=$gg;
   return $dataNum;
   }
   
// funzione pubDate - da numerico a formato iso8601 ( "2013-09-03" corrisponde a 3 settembre 2013  )
function pubDateIso8601($x,$y){
   $d=substr($x,0,4)."-".substr($x,4,2)."-".substr($x,6,2);
   $d.="T".$y."-0100";
return $d;
}

// mesi e giorni
   function calendario($fd) {
   $mesePartenza=substr($fd,4,2); 
   $annoPartenza=substr($fd,0,4); $annoFine=$annoPartenza+5;
   
   $dati['mese'][1]="Gennaio";   $dati['gg'][1]=31; 
   $dati['mese'][2]="Febbraio";  $dati['gg'][2]=29;
   $dati['mese'][3]="Marzo";     $dati['gg'][3]=31;
   $dati['mese'][4]="Aprile";    $dati['gg'][4]=30;
   $dati['mese'][5]="Maggio";    $dati['gg'][5]=31;
   $dati['mese'][6]="Giugno";    $dati['gg'][6]=30;
   $dati['mese'][7]="Luglio";    $dati['gg'][7]=31;
   $dati['mese'][8]="Agosto";    $dati['gg'][8]=31;
   $dati['mese'][9]="Settembre"; $dati['gg'][9]=30;
   $dati['mese'][10]="Ottobre";  $dati['gg'][10]=31;
   $dati['mese'][11]="Novembre"; $dati['gg'][11]=30;
   $dati['mese'][12]="Dicembre"; $dati['gg'][12]=31;
   
   // crea mese+anno
   for ($anno=$annoPartenza; $anno<$annoFine; $anno++) {
   for ($mese=1; $mese<13; $mese++) {
   for ($giorno=1; $giorno<($dati['gg'][$mese]+1); $giorno++) {
        $row['giorno'][]=$giorno;
        $row['mm'][]=$mese;
        $row['mese'][]=$dati['mese'][$mese];
        $row['anno'][]=$anno;
   }
   }
   }
   return $row;
   }


// controllo caratteri alfanumerici e lunghezza
   function ctrlSegr($obj,$luMin,$luMax) {
   $lungh=strlen($obj);
   $msg="";
   if(!@preg_match("/^[A-Za-z0-9]{5,25}$/",$obj)){
   //$msg="Sono stati immessi caratteri non validi";
   }
   if ($lungh<$luMin){$msg="Il numero di caratteri immessi &egrave; inferiore al minimo consentito";}
   if ($lungh>$luMax){$msg="Il numero di caratteri immessi &egrave; superiore al massimo consentito";}
   return $msg;
   }

// controllo tag e codici
   function checkTag($a) {
	  $msg=""; $b=strip_tags($a);
      if ($a!=$b){ $msg="Non sono ammessi tag e codici html"; }
   return $msg;
   }
	  
// controllo codici html: ammessi tutti tranne quelli che incidono su struttura pagina
   function checkHtml($a) {
	  $msg=""; $t=$a;
	  $t=str_replace("<?php", "", $t); $t=str_replace("?>", "", $t); 
	  $t=str_replace("<div", "", $t); $t=str_replace("</div>", "", $t); 
	  $t=str_replace("<form", "", $t); $t=str_replace("</form>", "", $t); 
	  $t=str_replace("<html>", "", $t); $t=str_replace("</html>", "", $t); 
	  $t=str_replace("<head>", "", $t); $t=str_replace("</head>", "", $t); 
	  $t=str_replace("<body", "", $t); $t=str_replace("</body>", "", $t);
	  $t=str_replace("<title", "", $t); $t=str_replace("</title>", "", $t);
	  $t=str_replace("<script", "", $t); $t=str_replace("</script>", "", $t);
	  $t=str_replace("<style", "", $t); $t=str_replace("</style>", "", $t);   
      if ($t!=$a){ $msg="Non sono ammessi codici php e html che possono modificare il layout del portale"; }
   return $msg;
   }

// antispam - controllo sito nel testo del messaggio // strstr(dove_cercare, cosa_cercare)
   function checkSito($a) {
   $msg="";
   $a=strtolower($a);
        if(strstr($a,"http://")){
        $msg="Indirizzi di siti e pagine internet non sono ammessi!"; 
        }
        if(strstr($a,"www")){
        $msg="Indirizzi di siti e pagine internet non sono ammessi!"; 
        }
        if(strstr($a,".com")){
        $msg="Indirizzi di siti e pagine internet non sono ammessi!"; 
        }
   return $msg;
   }
// controllo testo maiuscolo
   function checkMaiu($a) {
    $msg=""; $maiusc=strtoupper($a);
      if ($maiusc==$a){ $msg="Non &egrave; ammesso un testo tutto in maiuscolo"; }       
   return $msg;
   }

// formatta testo
   function formatta($t) {
   
    $t = stripslashes($t); // no barre #1
    $virg=chr(34); 
    $t = str_replace($virg, "", $t); // no virgolette
    
    $eurosimb=chr(8364); 
    $t = str_replace($eurosimb,"Euro ",$t); //no euro &#8364
   
    $t = str_replace("\'", "&#39", $t); // mantieni apostrofo
    $barre=chr(92); // no barre #2
    $t = str_replace($barre, "", $t);
    $t=trim($t); // togli spazi ai lati
    

    return $t;
   }


// controllo email valida 
   function ctrlEmail($obj) {
   $msg="";
        if(!@eregi("^[a-z0-9][_\.a-z0-9-]+@([a-z0-9][0-9a-z-]+\.)+([a-z]{2,4})", $obj)){
        $msg="Indirizzo E-mail non valido!"; 
        }
   return $msg;
   }

// controllo sito valido 
   function ctrlSito($obj) {
   $msg="";
        if(!@eregi("([[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/])", $obj)){
        $msg="Indirizzo di pagina internet (URL) non valido!"; 
        }
   return $msg;
   }

// controllo formato unico file (jpg|gif|png|...)
   function ctrlExtFile($ext,$formatoUnico) {
   $msg="";
        if ($ext!=$formatoUnico){
        $msg="Il file caricato NON &egrave; ".strtoupper($formatoUnico);
        }
   return $msg;
   }

// controllo peso file (mb)
   function ctrlPesoFile($peso,$mbMax) {
   $msg="";
   $peso=$peso/1048576;
        if ($peso>$mbMax){
        $msg="Il file caricato supera il limite massimo dei ".$mbMax." MB di consentiti.";
        }
   return $msg;
   }

// crea thumb
function creathumb($cartella,$nome,$newWidth,$newHeight,$dest,$pref){
$nomeimage=$cartella.$nome;

	// dimensioni immagine originale
	list($width,$height,,) = @getimagesize($nomeimage);
    while ($width>$newWidth or $height>$newHeight)
    	   {
    	   $width=ceil(9*$width/10); 
    	   $height=ceil(9*$height/10);
		   }

	// tipo immagine
    $estensione=strtolower(pathinfo($nomeimage,PATHINFO_EXTENSION));

    //$destimg=@ImageCreate($width,$height);
    $destimg=ImageCreatetruecolor($width,$height);

	switch($estensione){
	case "jpg": $srcimg=@ImageCreateFromJPEG($nomeimage); break;
	case "gif": $srcimg=@ImageCreateFromGIF($nomeimage); break;
	case "png": $srcimg=@ImageCreateFromPNG($nomeimage); break;
	}	

    ImageCopyResized($destimg,$srcimg,0,0,0,0,$width,$height,ImageSX($srcimg),ImageSY($srcimg));	  

    //@ImageJPEG($destimg,$dest.$pref.$nome,100);
	switch($estensione){
	case "jpg": $srcimg=@ImageJPEG($destimg,$dest.$pref.$nome,100); break;
	case "gif": $srcimg=@ImageGIF($destimg,$dest.$pref.$nome,100); break;
	case "png": $srcimg=@ImagePNG($destimg,$dest.$pref.$nome,100); break;
	}	
}

// controllo caratteri 
   function contaCaratteri($obj,$luMin,$luMax) {
   $lungh=strlen($obj);
   $msg="";
   if ($lungh<$luMin){$msg="Il numero di caratteri immessi &egrave; inferiore al minimo consentito";}
   if ($lungh>$luMax){$msg="Il numero di caratteri immessi &egrave; superiore al massimo consentito";}
   return $msg;
   }

// minimo parole in un testo (testo, minimo)
   function minimoParole($testo,$minimo) {
   $tot=str_word_count($testo);
   $msg="";
        if ($tot<$minimo){
        $msg="Il testo deve essere composto da almeno ".$minimo." parole.";
        }
   return $msg;
   }

// minimo parole in un testo (testo, minimo)
   function massimoParole($testo,$massimo) {
   $tot=str_word_count($testo);
   $msg="";
        if ($tot>$massimo){
        $msg="Il testo &egrave; troppo lungo. Il limite massimo consentito &egrave; di ".$massimo." parole.";
        }
   return $msg;
   }


// visualizza video (codice)
   function video($yt) {
        $yt=str_replace("http://www.youtube.com/watch?v=","//www.youtube.com/embed/",$yt);
        $yt=str_replace("https://www.youtube.com/watch?v=","//www.youtube.com/embed/",$yt);
        $yt=str_replace("http://youtu.be/","//www.youtube.com/embed/",$yt);
        print "<iframe src='";
        print $yt;
        print "' allowfullscreen></iframe>";
   }

// Elenco zone

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

  function province($conn,$where,$orderby){    
    $dati=array(
	"idP" => array (""),
	"provincia" => array (""),
	"sigla" => array (""),
	"idR" => array (""),
	"regione" => array ("")
    );
    $sql="
    SELECT province.idP,provincia,sigla,province.idR,regione 
    FROM province,regioni 
    WHERE province.idR=regioni.idR 
    ".$where." ".$orderby;
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idP'][]=$riga['idP'];
        $dati['provincia'][]=$riga['provincia'];
        $dati['sigla'][]=$riga['sigla'];
        $dati['idR'][]=$riga['idR'];
        $dati['regione'][]=$riga['regione'];
    }
    return $dati;
  }

  function comuni($conn,$where,$orderby){    
    $dati=array(
	"idC" => array (""),
	"comune" => array (""),
	"idP" => array (""),
	"provincia" => array (""),
	"sigla" => array (""),
	"idR" => array (""),
	"regione" => array ("")
    );
    $sql="
    SELECT comuni.idC,comune,comuni.idP,provincia,sigla,comuni.idR,regione 
    FROM comuni,province,regioni 
    WHERE comuni.idP=province.idP   
    AND comuni.idR=regioni.idR 
    ".$where." ".$orderby;
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idC'][]=$riga['idC'];
        $dati['comune'][]=$riga['comune'];
        $dati['idP'][]=$riga['idP'];
        $dati['provincia'][]=$riga['provincia'];
        $dati['sigla'][]=$riga['sigla'];
        $dati['idR'][]=$riga['idR'];
        $dati['regione'][]=$riga['regione'];
    }
    return $dati;
  }

  function municipi($conn,$where,$orderby){    
    $dati=array(
	"idM" => array (""),
	"municipio" => array (""),
	"idC" => array (""),
	"comune" => array (""),
	"idP" => array (""),
	"provincia" => array (""),
	"sigla" => array (""),
	"idR" => array (""),
	"regione" => array ("")
    );
    $sql="
    SELECT municipi.idM,municipio,municipi.idC,comune,municipi.idP,provincia,sigla,municipi.idR,regione 
    FROM municipi,comuni,province,regioni 
    WHERE municipi.idC=comuni.idC  
    AND municipi.idP=province.idP  
    AND municipi.idR=regioni.idR
    ".$where." ".$orderby;
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idM'][]=$riga['idM'];
        $dati['municipio'][]=$riga['municipio'];
        $dati['idC'][]=$riga['idC'];
        $dati['comune'][]=$riga['comune'];
        $dati['idP'][]=$riga['idP'];
        $dati['provincia'][]=$riga['provincia'];
        $dati['sigla'][]=$riga['sigla'];
        $dati['idR'][]=$riga['idR'];
        $dati['regione'][]=$riga['regione'];
    }
    return $dati;
  }

  function quartieri($conn,$where,$orderby){    
    $dati=array(
	"idQ" => array (""),
	"quartiere" => array (""),
	"rioni" => array (""),
	"idM" => array (""),
	"municipio" => array (""),
	"idC" => array (""),
	"comune" => array (""),
	"idP" => array (""),
	"provincia" => array (""),
	"sigla" => array (""),
	"idR" => array (""),
	"regione" => array ("")
    );
    $sql="
    SELECT quartieri.idQ,quartiere,rioni,quartieri.idM,municipio,quartieri.idC,comune,quartieri.idP,provincia,sigla,quartieri.idR,regione 
    FROM quartieri,municipi,comuni,province,regioni 
    WHERE quartieri.idM=municipi.idM 
    AND quartieri.idC=comuni.idC  
    AND quartieri.idP=province.idP  
    AND quartieri.idR=regioni.idR 
    ".$where." ".$orderby;
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idQ'][]=$riga['idQ'];
        $dati['quartiere'][]=$riga['quartiere'];
        $dati['rioni'][]=$riga['rioni'];
        $dati['idM'][]=$riga['idM'];
        $dati['municipio'][]=$riga['municipio'];
        $dati['idC'][]=$riga['idC'];
        $dati['comune'][]=$riga['comune'];
        $dati['idP'][]=$riga['idP'];
        $dati['provincia'][]=$riga['provincia'];
        $dati['sigla'][]=$riga['sigla'];
        $dati['idR'][]=$riga['idR'];
        $dati['regione'][]=$riga['regione'];
    }
    return $dati;
  }


// div a comparsa/scomparsa 
   function sezione_apri($url,$idSez,$nomSez,$default) {
?>
	   <a href="#" onclick="mostra_nascondi('<?php print $idSez; ?>');return false" title="mostra/nascondi questa sezione">
	   <img src="<?php print $url; ?>lay/arrow.gif" alt="+/-" /> 
	   <span class="grigio">Mostra/nascondi <?php print $nomSez; ?></span></a>
	   <br/><br/><br/>
	   <div id="<?php print $idSez; ?>" style="display:<?php print $default; ?>">
<?php   

   }

   function sezione_chiudi() {
?>
		<br/><br/><br/>
		</div>
<?php   
   }


// funzione
   function nomefunzione() {
   }
}   
?>
