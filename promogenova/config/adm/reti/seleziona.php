<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../reti">Reti</a> | Seleziona rete</h3>

<h4>Seleziona Rete</h4>

<?php

	 $sql="SELECT idRete,rete 
     FROM reti 
     ORDER BY rete ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<a href='rete.php?idRete=".$row['idRete']."'>".$row['rete']." (id:".$row['idRete'].")</a><br />";
	 }

?>
<br /><br />
