<?php

// FUNZIONI DATABASE 

class mysql extends pagina{

// Dati Regione
  function regione($conn,$idR){    
    $sql_q="SELECT regione FROM regioni WHERE idR='".$idR."'";
    $query_q=mysqli_query($conn,$sql_q);
    $q=mysqli_fetch_array($query_q,MYSQLI_ASSOC);
    return $q['regione'];
  }
  function province_da_regione($conn,$idR){    
    $dati=array(
	"idP" => array (""),
	"provincia" => array (""),
    "sigla" => array ("")
	);
    $sql_q="SELECT idP,provincia,sigla FROM province WHERE idR='".$idR."' ORDER BY provincia ASC";
    $query_q=mysqli_query($conn,$sql_q);
    while ($q=mysqli_fetch_array($query_q,MYSQLI_ASSOC)) {
    $dati['idP'][]=$q['idP'];
    $dati['provincia'][]=$q['provincia'];
    $dati['sigla'][]=$q['sigla'];
    }
    return $dati;
  }

// Dati Provincia  
  function provincia($conn,$idP){    
    $dati=array(
	"provincia" => array (""),
	"sigla" => array (""),
	"idR" => array (""),
	"regione" => array ("")
	);
    $sql_q="SELECT provincia,sigla,province.idR,regione FROM province,regioni WHERE province.idR=regioni.idR AND idP='".$idP."'";
    $query_q=mysqli_query($conn,$sql_q);
    $q=mysqli_fetch_array($query_q);
    $dati['provincia'][0]=$q['provincia'];
    $dati['sigla'][0]=$q['sigla'];
    $dati['idR'][0]=$q['idR'];
    $dati['regione'][0]=$q['regione'];
    return $dati;
  }
  function comuni_da_provincia($conn,$idP){    
    $dati=array(
	"idC" => array (""),
	"comune" => array ("")
	);
    $sql_q="SELECT idC,comune FROM comuni WHERE idP='".$idP."' ORDER BY comune ASC";
    $query_q=mysqli_query($conn,$sql_q);
    while ($q=mysqli_fetch_array($query_q,MYSQLI_ASSOC)) {
    $dati['idC'][]=$q['idC'];
    $dati['comune'][]=$q['comune'];
    }
    return $dati;
  }

// Dati Comune
  function comune($conn,$idC){    
    $dati=array(
	"comune" => array (""),
	"provincia" => array (""),
	"sigla" => array (""),
	"idP" => array (""),
	"regione" => array (""),
	"idR" => array ("")
	);
    $sql_q="SELECT comune,comuni.idP,provincia,sigla,comuni.idR,regione FROM comuni,province,regioni WHERE comuni.idR=regioni.idR AND comuni.idP=province.idP AND idC='".$idC."'";
    $query_q=mysqli_query($conn,$sql_q);
    $q=mysqli_fetch_array($query_q,MYSQLI_ASSOC);
    $dati['comune'][0]=$q['comune'];
    $dati['idP'][0]=$q['idP'];
    $dati['provincia'][0]=$q['provincia'];
    $dati['sigla'][0]=$q['sigla'];
    $dati['idR'][0]=$q['idR'];
    $dati['regione'][0]=$q['regione'];
    return $dati;
  }
  function municipi_da_comune($conn,$idC){    
    $dati=array(
	"idM" => array (""),
	"municipio" => array ("")
	);
    $sql_q="SELECT idM,municipio FROM municipi WHERE idC='".$idC."' ORDER BY idM ASC, municipio ASC";
    $query_q=mysqli_query($conn,$sql_q);
    while ($q=mysqli_fetch_array($query_q,MYSQLI_ASSOC)) {
    $dati['idM'][]=$q['idM'];
    $dati['municipio'][]=$q['municipio'];
    }
    return $dati;
  }

// Dati Municipio
  function municipio($conn,$idM){    
    $dati=array(
	"municipio" => array (""),
	"comune" => array (""),
	"idC" => array (""),
	"provincia" => array (""),
	"sigla" => array (""),
	"idP" => array (""),
	"regione" => array (""),
	"idR" => array ("")
	);
    $sql_q="SELECT municipio,municipi.idC,comune,municipi.idP,provincia,sigla,municipi.idR,regione FROM municipi,comuni,province,regioni WHERE municipi.idC=comuni.idC AND municipi.idR=regioni.idR AND municipi.idP=province.idP AND idM='".$idM."'";
    $query_q=mysqli_query($conn,$sql_q);
    $q=mysqli_fetch_array($query_q,MYSQLI_ASSOC);
    $dati['municipio'][0]=$q['municipio'];
    $dati['idC'][0]=$q['idC'];
    $dati['comune'][0]=$q['comune'];
    $dati['idP'][0]=$q['idP'];
    $dati['provincia'][0]=$q['provincia'];
    $dati['sigla'][0]=$q['sigla'];
    $dati['idR'][0]=$q['idR'];
    $dati['regione'][0]=$q['regione'];
    return $dati;
  }
  function quartieri_da_municipio($conn,$idM){    
    $dati=array(
	"idQ" => array (""),
	"quartiere" => array (""),
	"rioni" => array ("")
	);
    $sql_q="SELECT idQ,quartiere,rioni FROM quartieri WHERE idM='".$idM."' ORDER BY quartiere ASC";
    $query_q=mysqli_query($conn,$sql_q);
    while ($q=mysqli_fetch_array($query_q,MYSQLI_ASSOC)) {
    $dati['idQ'][]=$q['idQ'];
    $dati['quartiere'][]=$q['quartiere'];
    $dati['rioni'][]=$q['rioni'];
    }
    return $dati;
  }

// Dati Quartiere
  function quartiere($conn,$idQ){    
    $dati=array(
	"quartiere" => array (""),
	"rioni" => array (""),
	"comune" => array (""),
	"idC" => array (""),
	"municipio" => array (""),
	"idM" => array (""),
	"comune" => array (""),
	"idC" => array (""),
	"provincia" => array (""),
	"sigla" => array (""),
	"idP" => array (""),
	"regione" => array (""),
	"idR" => array ("")
	);
    $sql_q="SELECT quartiere,rioni,quartieri.idM,municipio,quartieri.idC,comune,quartieri.idP,provincia,sigla,quartieri.idR,regione FROM quartieri,municipi,comuni,province,regioni WHERE quartieri.idM=municipi.idM AND quartieri.idC=comuni.idC AND quartieri.idR=regioni.idR AND quartieri.idP=province.idP AND idQ='".$idQ."'";
    $query_q=mysqli_query($conn,$sql_q);
    $q=mysqli_fetch_array($query_q,MYSQLI_ASSOC);
    $dati['quartiere'][0]=$q['quartiere'];
    $dati['rioni'][0]=$q['rioni'];
    $dati['idM'][0]=$q['idM'];
    $dati['municipio'][0]=$q['municipio'];
    $dati['idC'][0]=$q['idC'];
    $dati['comune'][0]=$q['comune'];
    $dati['idP'][0]=$q['idP'];
    $dati['provincia'][0]=$q['provincia'];
    $dati['sigla'][0]=$q['sigla'];
    $dati['idR'][0]=$q['idR'];
    $dati['regione'][0]=$q['regione'];
    return $dati;
  }


// Vetrine per Zona
  function vetrine_per_zona($conn,$where,$orderby,$url,$zona,$quanteVisualizzare){   
  $altreinzona=str_replace("'","",$where);
  
    $oggi= date('Ymd');
    $vetrine=array(
	"idAttivita" => array (""),
	"attivita" => array (""),
	"logo" => array (""),
	"cartella" => array (""),
	"ragsoc" => array ("")
	);
    $sql_q="SELECT attivita.idAttivita,attivita,logo,cartella,dataOsc,ragsoc  
    FROM attivita,att_scad,att_indirizzi,vetrine,att_ragsoc
    WHERE attivita.idAttivita=att_scad.idAttivita AND attivita.idAttivita=vetrine.idAttivita AND attivita.idAttivita=att_indirizzi.idAttivita AND attivita.idAttivita=att_ragsoc.idAttivita AND osc='n' AND  
    ".$where." 
    ORDER BY ".$orderby;
    $query_q=mysqli_query($conn,$sql_q);
    while ($q=mysqli_fetch_array($query_q,MYSQLI_ASSOC)) {
    if ($oggi<=$q['dataOsc']) {
    $vetrine['idAttivita'][]=$q['idAttivita'];
    $vetrine['attivita'][]=$q['attivita'];
    $vetrine['logo'][]=$q['logo'];
    $vetrine['cartella'][]=$q['cartella'];
    $vetrine['ragsoc'][]=$q['ragsoc'];
    }
    }

    // visualizza
    if (count($vetrine['idAttivita'])>1) {
        
        if ((count($vetrine['idAttivita'])-1)>$quanteVisualizzare) {
        print "<p>Vetrine pubblicate di recente<br /><br /><br /></p>";
        }
        else{
        print "<p>Tutte le Vetrine in zona, disposte in ordine alfabetico<br /><br /></p>";
        }

    $conta=0;
    for ($i=1;$i<count($vetrine['idAttivita']);$i++) {
    if ($conta<$quanteVisualizzare) {
    $conta++;

            print "<table><tr><td>";
            print "<p><a href='".$url.$vetrine['cartella'][$i]."'>";
            $immagine=$url.$vetrine['cartella'][$i]."/".$vetrine['logo'][$i];
            $thumb=$url.$vetrine['cartella'][$i]."/th_".$vetrine['logo'][$i];
            $spazi="";
                if ($vetrine['logo'][$i]!="" && file_exists($immagine)) {
	               print "<img src='".$thumb."' alt='logo_".$vetrine['idAttivita'][$i]."' class='sx thumb scala' />";
                   $spazi="<br /><br />";
                }
            $txtConv=$this->mb_convert_encoding($vetrine['attivita'][$i]);
            print "<span class='testo verde'>".ucfirst($txtConv)."</span>";
            print "</a><br />";
            $txtConv=$this->mb_convert_encoding($vetrine['ragsoc'][$i]);
            print "<span class='nero'>".ucfirst($txtConv)."</span>";
            print $spazi;
            print "<br /><br /></p>";    
            print "</td></tr></table>";
    }
    }
    print "<p>Totale:".$conta." su ".(count($vetrine['idAttivita'])-1)." vetrine web in ".$zona."<br />";
        if ($conta<(count($vetrine['idAttivita'])-1)) {
        print "<a href='".$url."territorio/vetrine-per-zona.php?".$altreinzona."'><img src='".$url."lay/continua.png' alt='->' /> Vedi tutte le vetrine in zona</a></p>";
        }
    }
    else{
    print "<p>Al momento non abbiamo Vetrine web da mostrarti in zona ".$zona.".</p><p class='nero'>Se hai un'attivit&agrave;, non perdere l'occasione di apparire qui per primo!<br /> <a href='".$url."info-e-prezzi' class='testo'><img src='".$url."lay/continua.png' alt='->'> Clicca qui</a> e scopri subito che cosa abbiamo da proporti!<br /><br /></p>";
    }

  }


// Categorie per Zona
  function articoli_macro_per_zona($conn,$ANDzona){    
    
    $oggi=date("Ymd");
    
    $dati=array(
	"idMacro" => array (""),
	"macro" => array (""),
	"riscontri" => array ("")
    );

    $sql_cat="
    SELECT idMacro, macro 
    FROM macro
    ORDER BY macro ASC";
    $query_cat=mysqli_query($conn,$sql_cat);			
    while($cat=mysqli_fetch_array($query_cat,MYSQLI_ASSOC)){
        $conta=0;

    // art_dat (idMacro,idArt,idAttivita) -> att_indirizzi (idR)
        $sql_art="
        SELECT articoli_dat.idArt,dataOsc,idR,idP,idC,idM,idQ
        FROM articoli_dat,att_scad,att_indirizzi,articoli
        WHERE articoli.idArt=articoli_dat.idArt  
        AND articoli_dat.idAttivita=att_indirizzi.idAttivita 
        AND att_scad.idAttivita=articoli_dat.idAttivita 
        AND articoli_dat.idMacro='".$cat['idMacro']."' 
        AND articoli.osc='n' 
        AND att_scad.osc='n' 
        ".$ANDzona;
        $query_art=mysqli_query($conn,$sql_art);			
        while($art=mysqli_fetch_array($query_art,MYSQLI_ASSOC)){
        if ($oggi<=$art['dataOsc']){
            $conta++;
        }
        }
            
    if ($conta>0){
    $dati['idMacro'][]=$cat['idMacro'];
    $dati['macro'][]=$cat['macro'];
    $dati['riscontri'][]=$conta;
    }
    }

    return $dati;
  }

// Eventi per Zona
  function eventi_per_zona($conn,$ANDzona,$url,$zona,$quanti){  
  $altreinzona=str_replace("'","",$ANDzona);
  $altreinzona=str_replace("AND ","",$altreinzona);
  
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
	"dataOsc" => array ("")   
    );

    $sql="
    SELECT eventi.id,titolo,media.img,anno,dataInizio,oreInizio,dataFine,oreFine,dataAvv,dataOsc 
    FROM eventi,eventi_zone,eventi_dateore,media,media_link 
    WHERE eventi.id=eventi_zone.id 
    AND eventi.id=eventi_dateore.id 
    AND media.idMedia=media_link.idMedia
    AND media_link.id=eventi.id 
    ".$ANDzona." 
    ORDER BY dataOsc DESC, eventi.id DESC, titolo ASC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $eventi['id'][]=$riga['id'];
        $eventi['titolo'][]=$riga['titolo'];
        $eventi['img'][]=$riga['img'];
        $eventi['anno'][]=$riga['anno'];
        $eventi['dataInizio'][]=$riga['dataInizio'];        
        $eventi['oreInizio'][]=$riga['oreInizio'];        
        $eventi['dataFine'][]=$riga['dataFine'];        
        $eventi['oreFine'][]=$riga['oreFine'];        
        $eventi['dataAvv'][]=$riga['dataAvv'];        
        $eventi['dataOsc'][]=$riga['dataOsc'];        
    }

    // visualizza
    if (count($eventi['id'])>1) {
    print "<p>Ultimi inseriti in ordine cronologico<br /><br /><br /></p>";
    
    $conta=0;
    for ($i=1;$i<count($eventi['id']);$i++) {
    if ($conta<$quanti) {


        print "<p><a href='".$url."eventi/?id=".$eventi['id'][$i]."'>";
        $locandina=$url."locandine/ico_".$eventi['img'][$i];
            if ($eventi['img'][$i]!="" && file_exists($locandina)) {
            print "<img src='".$locandina."' alt='Evento".$eventi['id'][$i]."' class='thumb sx' />";
            }

        $titolo=$this->mb_convert_encoding($eventi['titolo'][$i]);
        print "<span class='testo'>".ucfirst($titolo)."</span></a><br />";
            if ($eventi['dataInizio'][$i]!="") {
            print "Quando: dalle ore ".$eventi['oreInizio'][$i];
                if ($eventi['dataInizio'][$i]==$eventi['dataFine'][$i]) {
                print " alle ore ".$eventi['oreFine'][$i]." del giorno <span class='viola'>".$this->visData($eventi['dataFine'][$i])."</span>"; 
                }
                else {
                print " del <span class='viola'>".$this->visData($eventi['dataInizio'][$i])."</span> alle ore ".$eventi['oreFine'][$i]." del <span class='viola'>".$this->visData($eventi['dataFine'][$i])."</span>";
                }	
             }
    

        print"<br /><br /></p>";
        $conta++;
    }
    }
    print "<p>Totale:".$conta." su ".(count($eventi['id'])-1)." eventi in ".$zona."<br />";
        if ($conta<(count($eventi['id'])-1)) {
        print "<a href='".$url."territorio/eventi-per-zona.php?".$altreinzona."'><img src='".$url."lay/continua.png' alt='->' /> Vedi tutti gli eventi in zona</a></p>";
        }

    }
    else{
    print "<p>Al momento non abbiamo notizia di eventi in zona ".$zona.".</p><p class='nero'>Se hai un'attivit&agrave; e vuoi far conoscere i tuoi corsi, le manifestazioni ecc., non perdere l'occasione di apparire per primo!<br /> <a href='".$url."info-e-prezzi' class='testo'><img src='".$url."lay/continua.png' alt='->'> Clicca qui</a> e scopri subito che cosa abbiamo da proporti!<br /><br /></p>";
    }


  }


// Video per Zona
  function video_per_zona($conn,$ANDzona,$url,$zona,$quanti){    
    $dati=array(
	"idVideo" => array (""),
	"video" => array (""),
	"url" => array (""),
	"anno" => array (""),
	"dataUp" => array (""),
	"giorno" => array (""),    
    );
    $conta=0;
    $sql="
    SELECT video.idVideo,video,anno,dataUp,giorno,url 
    FROM video,video_zone 
    WHERE 
    video.idVideo=video_zone.idVideo 
    ".$ANDzona." 
    ORDER BY dataUp DESC,video ASC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if($conta<$quanti){
        $dati['idVideo'][]=$riga['idVideo'];
        $dati['video'][]=$riga['video'];
        $dati['url'][]=$riga['url'];
        $dati['anno'][]=$riga['anno'];
        $dati['dataUp'][]=$riga['dataUp'];        
        $dati['giorno'][]=$riga['giorno'];
        }
    $conta++;
    }

    // visualizza
    if (count($dati['idVideo'])>1) {
    print "<p>Ultimi ".$quanti." video pubblicati<br /><br /><br /></p>";
    for ($i=1;$i<count($dati['idVideo']);$i++) {
    $this->video($dati['url'][$i]);
    print "<br /><br />";
    }
    }
    else{
    print "<p>Al momento non abbiamo video che riguardino la zona ".$zona.".</p><p class='nero'>Se hai un'attivit&agrave; e vuoi diffondere i tuoi video, non perdere l'occasione di apparire per primo!<br /> <a href='".$url."info-e-prezzi' class='testo'><img src='".$url."lay/continua.png' alt='->'> Clicca qui</a> e scopri subito che cosa abbiamo da proporti!<br /><br /></p>";
    }

  }

// Album per Zona
  function album_per_zona($conn,$ANDzona,$url,$zona,$quanti){  
    $dati=array(
	"idAlbum" => array (""),
	"album" => array (""),
	"img" => array (""),
	"url" => array ("")
    );

    $sql="
    SELECT album.idAlbum,album,anno,dataUp,giorno,url,idR,idP,idC,idM,idQ 
    FROM album,album_zone 
    WHERE album.idAlbum=album_zone.idAlbum 
    ".$ANDzona." 
    ORDER BY dataUp DESC,album ASC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idAlbum'][]=$riga['idAlbum'];
        $dati['album'][]=$riga['album'];
        $dati['url'][]=$riga['url'];

		$locandina=""; 
		$sql1="
		SELECT img 
		FROM media,media_link,album 
		WHERE media_link.idMedia=media.idMedia
		AND media_link.idAlbum=album.idAlbum
		AND media_link.idAlbum='".$riga['idAlbum']."'
		";
		$query1=mysqli_query($conn,$sql1);			
		$row=mysqli_fetch_array($query1);
            if ($row['img']!="" ) { 
				$locandina=$row['img']; 
				}
        $dati['img'][]=$locandina;
    }

    // visualizza
    if (count($dati['idAlbum'])>1) {
    print "<p>Ultimi ".$quanti." album pubblicati<br /><br /><br /></p>";
    
    $conta=0;
    for ($i=1;$i<count($dati['idAlbum']);$i++) {
    if ($conta<$quanti) {


        print "<p><a href='".$dati['url'][$i]."'>";
        $locandina=$url."locandine/".$dati['img'][$i];
        $thumb=$url."locandine/ico_".$dati['img'][$i];
            if ($dati['img'][$i]!="" && file_exists($locandina)) {
            print "<img src='".$thumb."' alt='Album".$dati['idAlbum'][$i]."' class='thumb scala' /><br />";
            }

        $titolo=$this->mb_convert_encoding($dati['album'][$i]);
        print ucfirst($titolo)."</a><br /><br />";
        print"</p>";
        $conta++;
    }
    }
    }
    else{
    print "<p>Al momento non abbiamo raccolte di immagini che riguardino la zona ".$zona.".</p><p class='nero'>Se hai un'attivit&agrave; e desideri veder pubblicate qui le tue foto, non perdere l'occasione di apparire per primo!<br /> <a href='".$url."info-e-prezzi' class='testo'><img src='".$url."lay/continua.png' alt='->'> Clicca qui</a> e scopri subito che cosa abbiamo da proporti!<br /><br /></p>";
    }

  }


// Reti per Zona
  function reti_per_zona($conn,$ANDzona,$url,$zona,$quanti){    
    $dati=array(
	"idRete" => array (""),
	"rete" => array (""),
	"settore" => array (""),
	"logo" => array ("")    
    );
    $conta=0;
    $sql="
    SELECT reti.idRete,rete,settore,logo 
    FROM reti,reti_zone,reti_settori
    WHERE reti.osc='n' 
    AND reti.idRete=reti_zone.idRete 
    AND reti.idSett=reti_settori.idSett 
    ".$ANDzona." 
    ORDER BY idRete DESC,rete ASC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if($conta<$quanti){
        $dati['idRete'][]=$riga['idRete'];
        $dati['rete'][]=$riga['rete'];
        $dati['settore'][]=$riga['settore'];
        $dati['logo'][]=$riga['logo'];
        }
    $conta++;
    }

    // visualizza
    if (count($dati['idRete'])>1) {
    print "<p>Ultime ".$quanti." reti pubblicate<br /><br /><br /></p>";
    $conta=0;
    for ($i=1;$i<count($dati['idRete']);$i++) {
    if ($conta<$quanti) {


        print "<p><a href='".$url."reti/scheda.php?idRete=".$dati['idRete'][$i]."'>";
        $locandina=$url."reti/loghi/ico_".$dati['logo'][$i];
            if ($dati['logo'][$i]!="" && file_exists($locandina)) {
            print "<img src='".$locandina."' alt='Rete".$dati['idRete'][$i]."' class='thumb sx' />";
            }

        $titolo=$this->mb_convert_encoding($dati['rete'][$i]);
        print "<span class='testo'>".ucfirst($titolo)."</span></a><br />";
        $txtConv=$this->mb_convert_encoding($dati['settore'][$i]);
        print "Settore: <span class='verde'>".ucfirst($txtConv)."</span><br /><br />";
       print"</p>";
        $conta++;
    }
    }
    }
    else{
    print "<p>Al momento non sosteniamo Reti e progetti in zona ".$zona.".<br /><br /></p>";
    }

  }


// Articoli in promozione in zona
  function promozioni_zona($conn,$ANDzona,$ANDtutte,$url,$zona,$quanti){  

    $oggi=date("Ymd");

    // controlla articoli_promo e se attività valida
    $promozioni_zona=0;
    $sql="
    SELECT articoli.idArt, att_scad.idAttivita,dataOsc
    FROM articoli,articoli_promo,att_scad
    WHERE articoli.idArt=articoli_promo.idArt
    AND att_scad.idAttivita=articoli_promo.idAttivita 
    AND att_scad.osc='n' 
    AND articoli.osc='n' 
    ".$ANDzona;
    $query=mysqli_query($conn,$sql);			
    while ($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if( isset($q['dataOsc']) && $q['dataOsc']>0 && $oggi<=$q['dataOsc'] ){ 
            $promozioni_zona++;
        }
    }
    
    $promozioni_tutte=0;
    $sql="
    SELECT articoli.idArt, att_scad.idAttivita,dataOsc
    FROM articoli,articoli_promo,att_scad
    WHERE articoli.idArt=articoli_promo.idArt
    AND att_scad.idAttivita=articoli_promo.idAttivita 
    AND att_scad.osc='n' 
    AND articoli.osc='n' 
    ".$ANDtutte;
    $query=mysqli_query($conn,$sql);			
    while ($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        if( isset($q['dataOsc']) && $q['dataOsc']>0 && $oggi<=$q['dataOsc'] ){ 
            $promozioni_tutte++;
        }
    }

    // visualizza
    if ($promozioni_zona>0 | $promozioni_tutte>0) {

    $dati=array(
	"idArt" => array (""),
	"titolo" => array (""),
	"img" => array (""),
	"idMacro" => array (""),
	"macro" => array (""),
	"idAttivita" => array (""),
	"attivita" => array (""),
	"cartella" => array ("")
    );

    if ($promozioni_zona>0) {
    $sql="
    SELECT articoli.idArt,img,titolo, articoli_dat.idMacro,macro, attivita.idAttivita,attivita,cartella 
    FROM articoli,articoli_dat,macro,articoli_txt, attivita,att_scad,vetrine, articoli_promo
    WHERE articoli.idArt=articoli_promo.idArt  
    AND articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro  
    AND articoli_dat.idAttivita=attivita.idAttivita  
    AND attivita.idAttivita=att_scad.idAttivita  
    AND attivita.idAttivita=vetrine.idAttivita  
    AND att_scad.osc='n' 
    AND articoli.osc='n' 
    ".$ANDzona." 
    ORDER BY idArt DESC, titolo ASC, attivita ASC";
    $query=mysqli_query($conn,$sql);			
    while ($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
            $dati['idArt'][]=$q['idArt'];
            $dati['img'][]=$q['img'];
            $dati['titolo'][]=$q['titolo'];
            $dati['idMacro'][]=$q['idMacro'];
            $dati['macro'][]=$q['macro'];
            $dati['idAttivita'][]=$q['idAttivita'];    
            $dati['attivita'][]=$q['attivita'];    
            $dati['cartella'][]=$q['cartella'];    
    }
    }

    if ($promozioni_tutte>0) {
    $sql="
    SELECT articoli.idArt,img,titolo, articoli_dat.idMacro,macro, attivita.idAttivita,attivita,cartella 
    FROM articoli,articoli_dat,macro,articoli_txt, attivita,att_scad,vetrine, articoli_promo
    WHERE articoli.idArt=articoli_promo.idArt  
    AND articoli.idArt=articoli_dat.idArt
    AND articoli.idArt=articoli_txt.idArt  
    AND articoli_dat.idMacro=macro.idMacro  
    AND articoli_dat.idAttivita=attivita.idAttivita  
    AND attivita.idAttivita=att_scad.idAttivita  
    AND attivita.idAttivita=vetrine.idAttivita  
    AND att_scad.osc='n' 
    AND articoli.osc='n' 
    ".$ANDtutte." 
    ORDER BY idArt DESC, titolo ASC, attivita ASC";
    $query=mysqli_query($conn,$sql);			
    while ($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
            $dati['idArt'][]=$q['idArt'];
            $dati['img'][]=$q['img'];
            $dati['titolo'][]=$q['titolo'];
            $dati['idMacro'][]=$q['idMacro'];
            $dati['macro'][]=$q['macro'];
            $dati['idAttivita'][]=$q['idAttivita'];    
            $dati['attivita'][]=$q['attivita'];    
            $dati['cartella'][]=$q['cartella'];    
    }
    }


    print "<div class='riga'>";
    print "<div class='colonna-1'>";
    print "<a name='promozioni'></a>";
    print "<h2 class='bianco sfTondo sfGrigio'>Articoli in promozione - ".$zona."</h2>";

    print "<p>Ci sono ".(count($dati['idArt'])-1)." promozioni in ".$zona."<br /><br /><br /></p>";
    
    $conta=0;
    for ($i=1;$i<count($dati['idArt']);$i++) {
    if ($conta<$quanti) {


        print "<p><a href='".$url.$dati['cartella'][$i]."/articoli.php?idArt=".$dati['idArt'][$i]."'>";
        $locandina=$url.$dati['cartella'][$i]."/articoli/ico_".$dati['img'][$i];
            if ($dati['idArt'][$i]!="" && file_exists($locandina)) {
            print "<img src='".$locandina."' alt='Art".$dati['idArt'][$i]."' class='thumb sx' />";
            }

        $titolo=$this->mb_convert_encoding($dati['titolo'][$i]);
        print "<span class='testo'>".ucfirst($titolo)."</span></a><br />";
        $txtConv=$this->mb_convert_encoding($dati['attivita'][$i]);
        print "Pubblicato da <a href='".$url.$dati['cartella'][$i]."'><span class='verde'>".ucfirst($txtConv)."</span></a><br />";
        $txtConv=$this->mb_convert_encoding($dati['macro'][$i]);
        print "Categoria: <a href='".$url."ricerche/macro.php?idMacro=".$dati['idMacro'][$i]."'><span class='viola'>".$txtConv."</span></a><br />";
        print"<br /></p>";
        $conta++;
    }
    }
    
    print "</div></div>";

  }
  }




}// fine classe
?>
