<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../media">Media</a> | Seleziona locandina</h3>

<h4>Seleziona locandina</h4>

<?php

	 $sql="SELECT media.idMedia,img
     FROM media
     ORDER BY idMedia DESC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
	 $thumb=$url."locandine/ico_".$row['img'];
	 print "<a href='locandina.php?idMedia=".$row['idMedia']."'>";
		if ($row['img']!="" && file_exists($thumb)){
		print "<img src='".$thumb."'>";
		}
	 print "&nbsp;".$row['idMedia']." </a><br/>";
	 
	 // evento collegato
	 $sql1="SELECT titolo FROM eventi,media_link WHERE media_link.id=eventi.id AND media_link.idMedia='".$row['idMedia']."'";	 
	 $query1=mysqli_query($conn,$sql1);
	 $row1=mysqli_fetch_array($query1,MYSQLI_ASSOC);	 
		if ($row1['titolo']!=""){ print "EVENTO: ".$row1['titolo']."<br/>"; }
	 
	 // album collegato
	 $sql1="SELECT album FROM album,media_link WHERE media_link.idAlbum=album.idAlbum AND media_link.idMedia='".$row['idMedia']."'";	 
	 $query1=mysqli_query($conn,$sql1);
	 $row1=mysqli_fetch_array($query1,MYSQLI_ASSOC);	 
		if ($row1['album']!=""){ print "ALBUM: ".$row1['album']."<br/>"; }

	 // video collegato
	 $sql1="SELECT video FROM video,media_link WHERE media_link.idVideo=video.idVideo AND media_link.idMedia='".$row['idMedia']."'";	 
	 $query1=mysqli_query($conn,$sql1);
	 $row1=mysqli_fetch_array($query1,MYSQLI_ASSOC);	 
		if ($row1['video']!=""){ print "VIDEO: ".$row1['video']."<br/>"; }
		
	 print "<br/>";
	 }

?>
<br /><br />
