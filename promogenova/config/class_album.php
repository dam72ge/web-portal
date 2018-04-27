<?php

// FUNZIONI DATABASE 

class mysql extends pagina{

// Elenco album
  function elenco_album($conn){
    
    $dati=array(
	"idAlbum" => array (""),
	"album" => array (""),
	"img" => array (""),
	"ico" => array (""),
	"th" => array (""),
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
 	"video" => array ("")
    );


    $sql="
    SELECT album.idAlbum,album,copertina,anno,dataUp,giorno,url,idR,idP,idC,idM,idQ 
    FROM album,album_zone
    WHERE  album.idAlbum=album_zone.idAlbum 
    ORDER BY dataUp DESC,album ASC";
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idAlbum'][]=$riga['idAlbum'];
        $dati['album'][]=$riga['album'];

		// link media: locandina
		$locandina="album/copertine/".$riga['copertina'];
		$locandina_th="album/copertine/th_".$riga['copertina'];
		$locandina_ico="album/copertine/ico_".$riga['copertina'];

		$sql1="
		SELECT img 
		FROM media,media_link,album 
		WHERE media_link.idMedia=media.idMedia
		AND media_link.idAlbum=album.idAlbum
		AND media_link.idAlbum='".$riga['idAlbum']."'
		";
		$query1=mysqli_query($conn,$sql1);			
		$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            if ($row['img']!="" ) { 
				$locandina="locandine/".$row['img']; 
				$locandina_th="locandine/th_".$row['img']; 
				$locandina_ico="locandine/ico_".$row['img']; 
				}
        $dati['img'][]=$locandina;
        $dati['th'][]=$locandina_th;
        $dati['ico'][]=$locandina_ico;

		//link media: eventi
		$linkEv=0;
		$sql1="
		SELECT id 
		FROM media_link
		WHERE media_link.idAlbum='".$riga['idAlbum']."'
		";
		$query1=mysqli_query($conn,$sql1);			
		$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            if ($row['id']>0 ) { $linkEv=$row['id']; }
        $dati['id'][]=$linkEv;

		//link media: video
		$linkVid="";
		$sql1="
		SELECT video.idVideo,video.url 
		FROM media_link,video
		WHERE media_link.idVideo=video.idVideo  
		AND media_link.idAlbum='".$riga['idAlbum']."'
		";
		$query1=mysqli_query($conn,$sql1);			
		$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            if ($row['idVideo']>0 ) { $linkVid=$row['url']; }
        $dati['video'][]=$linkVid;


        $dati['url'][]=$riga['url'];
        $dati['anno'][]=$riga['anno'];
        $dati['dataUp'][]=$riga['dataUp'];        
        $dati['giorno'][]=$riga['giorno'];

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

// singola album
  function singola_album($conn,$id){
    
    $dati=array(
	"idAlbum" => array (""),
	"album" => array (""),
	"copertina" => array (""),
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
    SELECT album.idAlbum,album,copertina,anno,dataUp,giorno,url,idR,idP,idC,idM,idQ 
    FROM album,album_zone 
    WHERE  
    album.idAlbum=album_zone.idAlbum 
    AND album.idAlbum='".$id."'";
    $query=mysqli_query($conn,$sql);			
    $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);
    
        $dati['idAlbum'][0]=$riga['idAlbum'];
        $dati['album'][0]=$riga['album'];
        $dati['copertina'][0]=$riga['copertina'];
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
