<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../eventi">Eventi</a> | Seleziona eventi</h3>

<h4>Seleziona Evento</h4>

<?php

	 $sql="SELECT eventi.id,titolo,anno,dataInizio,oreInizio,dataFine,oreFine
     FROM eventi,eventi_dateore
     WHERE eventi.id=eventi_dateore.id 
     ORDER BY eventi.id DESC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
     print "<strong>".$row['anno']."</strong> <a href='evento.php?id=".$row['id']."'>".$row['titolo']."</a> id:".$row['id']."<br />";
     print "Dal: ".$row['dataInizio'].", ore ".$row['oreInizio']." - Al: ".$row['dataFine']." ore ".$row['oreFine'];     print "<br /><br />";
	 }

?>
<br /><br />
