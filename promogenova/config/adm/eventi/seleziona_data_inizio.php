<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../eventi">Eventi</a> | Seleziona per data inizio eventi</h3>

<h4>Seleziona Evento</h4>

<?php

	 $sql="SELECT eventi.id,titolo,anno,dataInizio,oreInizio,dataFine,oreFine
     FROM eventi,eventi_dateore
     WHERE eventi.id=eventi_dateore.id 
     ORDER BY eventi_dateore.dataInizio DESC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
     print $row['anno']." <a href='evento.php?id=".$row['id']."'>".$row['titolo']."</a> id:".$row['id']."<br />";
     print "Dal: <strong>".$row['dataInizio']."</strong>, ore ".$row['oreInizio']." - Al: ".$row['dataFine']." ore ".$row['oreFine'];     print "<br /><br />";
	 }

?>
<br /><br />
