<?php

// FUNZIONI DATABASE 

class mysql extends pagina{

// Elenco video
  function elenco_video($conn){
    
    $dati=array(
	"idVideo" => array (""),
	"video" => array (""),
	"url" => array (""),
	"anno" => array (""),
	"dataUp" => array (""),
	"giorno" => array (""),    
	"idR" => array (""),
	"idP" => array (""),
	"idC" => array (""),
	"idM" => array (""),
	"idQ" => array (""),
 	"zona" => array (""),
 	"id" => array (""),
 	"album" => array ("")
    );


    $sql="
    SELECT video.idVideo,video,anno,dataUp,giorno,url,idR,idP,idC,idM,idQ 
    FROM video,video_zone 
    WHERE 
    video.idVideo=video_zone.idVideo 
    ORDER BY dataUp DESC,video ASC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idVideo'][]=$riga['idVideo'];
        $dati['video'][]=$riga['video'];
        $dati['url'][]=$riga['url'];
        $dati['anno'][]=$riga['anno'];
        $dati['dataUp'][]=$riga['dataUp'];        
        $dati['giorno'][]=$riga['giorno'];

		//link media: eventi
		$linkEv=0;
		$sql1="
		SELECT id 
		FROM media_link
		WHERE media_link.idVideo='".$riga['idVideo']."'
		";
		$query1=mysqli_query($conn,$sql1);			
		$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            if ($row['id']>0 ) { $linkEv=$row['id']; }
        $dati['id'][]=$linkEv;

		//link media: album
		$linkAlb="";
		$sql1="
		SELECT album.idAlbum,album.url 
		FROM media_link,album
		WHERE media_link.idAlbum=album.idAlbum
		AND media_link.idVideo='".$riga['idVideo']."'
		";
		$query1=mysqli_query($conn,$sql1);			
		$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            if ($row['idAlbum']>0 ) { $linkAlb=$row['url']; }
        $dati['album'][]=$linkAlb;

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
	 }	
    return $dati;
  }

// singola video
  function singola_video($conn,$id){
    
    $dati=array(
	"idVideo" => array (""),
	"video" => array (""),
	"url" => array (""),
	"anno" => array (""),
	"dataUp" => array (""),
	"giorno" => array (""),    
	"idR" => array (""),
	"idP" => array (""),
	"idC" => array (""),
	"idM" => array (""),
	"idQ" => array (""),
 	"zona" => array ("")
    );


    $sql="
    SELECT video.idVideo,video,anno,dataUp,giorno,url,idR,idP,idC,idM,idQ 
    FROM video,video_zone 
    WHERE  
    video.idVideo=video_zone.idVideo 
    AND video.idVideo='".$id."'";
    $query=mysqli_query($conn,$sql);			
    $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);
    
        $dati['idVideo'][0]=$riga['idVideo'];
        $dati['video'][0]=$riga['video'];
        $dati['url'][0]=$riga['url'];
        $dati['anno'][0]=$riga['anno'];
        $dati['dataUp'][0]=$riga['dataUp'];        
        $dati['giorno'][0]=$riga['giorno'];

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

        $dati['idR'][0]=$riga['idR'];        
        $dati['idP'][0]=$riga['idP'];        
        $dati['idC'][0]=$riga['idC'];        
        $dati['idM'][0]=$riga['idM'];        
        $dati['idQ'][0]=$riga['idQ'];        
        $dati['zona'][0]=$zona;        
    return $dati;
  }

}
?>
