<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../album">Album</a> | Seleziona per zona</h3>

<h4>Seleziona Album per zona / Quartieri Genova</h4>
<?php

	 $sql="SELECT album.idAlbum,album,copertina,url,dataUp,anno,giorno,quartiere 
     FROM album,album_zone,quartieri 
     WHERE album.idAlbum=album_zone.idAlbum 
     AND album_zone.idQ=quartieri.idQ 
     AND album_zone.idC='25' AND album_zone.idM!='0' AND album_zone.idQ!='0'   
     ORDER BY album_zone.idQ ASC, dataUp DESC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<strong>GE ".$row['quartiere']."</strong> <a href='album.php?idAlbum=".$row['idAlbum']."'>".$row['album']."</a> id:".$row['idAlbum'].", giorno: ".$row['giorno'].", anno: ".$row['anno']."<br />";
	 }

?>
<br /><br />

<h4>Seleziona Album per zona / Municipi Genova</h4>
<?php

	 $sql="SELECT album.idAlbum,album,copertina,url,dataUp,anno,giorno,municipio 
     FROM album,album_zone,municipi 
     WHERE album.idAlbum=album_zone.idAlbum 
     AND album_zone.idM=municipi.idM 
     AND album_zone.idC='25' AND album_zone.idM!='0'  
     ORDER BY album_zone.idM ASC, dataUp DESC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<strong>GE ".$row['municipio']."</strong> <a href='album.php?idAlbum=".$row['idAlbum']."'>".$row['album']."</a> id:".$row['idAlbum'].", giorno: ".$row['giorno'].", anno: ".$row['anno']."<br />";
	 }

?>
<br /><br />

<h4>Seleziona Album per zona / Genova e provincia</h4>
<?php

	 $sql="SELECT album.idAlbum,album,copertina,url,dataUp,anno,giorno,comune 
     FROM album,album_zone,comuni 
     WHERE album.idAlbum=album_zone.idAlbum 
     AND album_zone.idC=comuni.idC 
     AND album_zone.idP='1' AND album_zone.idC!='0'  
     ORDER BY album_zone.idC ASC, dataUp DESC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<strong>".$row['comune']."(GE) </strong> <a href='album.php?idAlbum=".$row['idAlbum']."'>".$row['album']."</a> id:".$row['idAlbum'].", giorno: ".$row['giorno'].", anno: ".$row['anno']."<br />";
	 }

?>
<br /><br />

<h4>Seleziona Album per zona / Fuori</h4>
<?php

	 $sql="SELECT album.idAlbum,album,copertina,url,dataUp,anno,giorno,comune,sigla,regione 
     FROM album,album_zone,comuni,province,regioni
     WHERE album.idAlbum=album_zone.idAlbum 
     AND album_zone.idC=comuni.idC 
     AND album_zone.idP=province.idP 
     AND album_zone.idR=regioni.idR 
     AND album_zone.idP!='1' AND album_zone.idC!='0'  
     ORDER BY album_zone.idC ASC, dataUp DESC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<strong>".$row['comune']."</strong> (Prov. ".$row['sigla'].", Reg. ".$row['regione'].") <a href='album.php?idAlbum=".$row['idAlbum']."'>".$row['album']."</a> id:".$row['idAlbum'].", giorno: ".$row['giorno'].", anno: ".$row['anno']."<br />";
	 }

?>
<br /><br />
