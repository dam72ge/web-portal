<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../video">Video</a> | Seleziona per data</h3>

<h4>Seleziona Video per data</h4>
<?php

	 $sql="SELECT idVideo,video,url,dataUp,anno,giorno 
     FROM video
     ORDER BY dataUp DESC, video ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<strong>".$row['dataUp']."</strong> <a href='video.php?idVideo=".$row['idVideo']."'>".$row['video']."</a> id:".$row['idVideo'].", giorno: ".$row['giorno']."<br />";
	 }

?>
<br /><br />

