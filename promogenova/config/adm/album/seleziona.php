<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../album">Album</a> | Seleziona per data</h3>

<h4>Seleziona Album per data</h4>
<?php

	 $sql="SELECT idAlbum,album,copertina,url,dataUp,anno,giorno 
     FROM album
     ORDER BY dataUp DESC, album ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<strong>".$row['dataUp']."</strong> <a href='album.php?idAlbum=".$row['idAlbum']."'>".$row['album']."</a> id:".$row['idAlbum'].", giorno: ".$row['giorno']."<br />";
	 }

?>
<br /><br />

