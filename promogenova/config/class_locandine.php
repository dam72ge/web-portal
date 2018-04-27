<?php

// FUNZIONI DATABASE 

class mysql extends pagina{

// Elenco album
  function elenco_locandine($conn){
    
    $dati=array(
	"idMedia" => array (""),
	"img" => array ("")
    );

    $sql="
    SELECT media.idMedia,img 
    FROM media,media_link
    WHERE  media.idMedia=media_link.idMedia
    ORDER BY id DESC, idMedia DESC";
    $query=mysqli_query($conn,$sql);
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['idMedia'][]=$riga['idMedia'];
        $dati['img'][]=$riga['img'];
	 }	
    return $dati;
  }

// singola album
  function singola_locandina($conn,$idMedia){
    
    $dati=array(
	"img" => array (""),
	"id" => array (""),
	"titolo" => array (""),
	"idAlbum" => array (""),
	"album" => array (""),
	"url_album" => array (""),
	"idVideo" => array (""),
	"video" => array (""),
	"url_video" => array ("")
    );

    $sql="
    SELECT media.idMedia,img,id,idAlbum,idVideo 
    FROM media,media_link
    WHERE  media.idMedia=media_link.idMedia
    AND media.idMedia='".$idMedia."'";

    $query=mysqli_query($conn,$sql);
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['img'][0]=$riga['img'];
		$dati['id'][0]=$riga['id']; 
		$dati['idAlbum'][0]=$riga['idAlbum']; 
		$dati['idVideo'][0]=$riga['idVideo']; 

		// evento
        $dati['titolo'][0]="";
		$sql1="SELECT titolo FROM eventi WHERE id='".$riga['id']."'";
		$query1=mysqli_query($conn,$sql1);
		$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            if ($row['titolo']!="" ) { 
			$dati['titolo'][0]=$row['titolo'];
			}

		//album
		$sql1="SELECT album,url FROM album WHERE idAlbum='".$riga['idAlbum']."'";
		$query1=mysqli_query($conn,$sql1);
		$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            if ($row['album']!="" ) { 
			$dati['album'][0]=$row['album'];
			$dati['url_album'][0]=$row['url'];
			}

		//video
		$sql1="SELECT video,url FROM video WHERE idVideo='".$riga['idVideo']."'";
		$query1=mysqli_query($conn,$sql1);			
		$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
            if ($row['video']!="" ) { 
			$dati['video'][0]=$row['video'];
			$dati['url_video'][0]=$row['url'];
			}

	 }	
    return $dati;
  }

}
?>
