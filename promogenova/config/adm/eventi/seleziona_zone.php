<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../eventi">Eventi</a> | Seleziona eventi</h3>

<h4>Seleziona Evento per zona / Quartieri Genova</h4>
<?php

	 $sql="SELECT eventi.id,titolo,quartiere,anno,dataInizio,oreInizio,dataFine,oreFine 
     FROM eventi,eventi_zone,quartieri,eventi_dateore 
     WHERE eventi.id=eventi_zone.id 
     AND eventi.id=eventi_dateore.id
     AND eventi_zone.idQ=quartieri.idQ 
     AND eventi_zone.idC='25' AND eventi_zone.idM!='0' AND eventi_zone.idQ!='0'   
     ORDER BY eventi_zone.idQ ASC, eventi.id ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<strong>GE ".$row['quartiere']."</strong> <a href='evento.php?id=".$row['id']."'>".$row['titolo']."</a> id:".$row['id']."  - anno: ".$row['anno']." - ";
     print "Dal: ".$row['dataInizio'].", ore ".$row['oreInizio']." - Al: ".$row['dataFine']." ore ".$row['oreFine'];     print "<br />";
     }

?>
<br /><br />

<h4>Seleziona Evento per zona / Municipi Genova</h4>
<?php

	 $sql="SELECT eventi.id,titolo,municipio,anno,dataInizio,oreInizio,dataFine,oreFine  
     FROM eventi,eventi_zone,municipi,eventi_dateore 
     WHERE eventi.id=eventi_zone.id 
     AND eventi.id=eventi_dateore.id
     AND eventi_zone.idM=municipi.idM 
     AND eventi_zone.idC='25' AND eventi_zone.idM!='0'  
     ORDER BY eventi_zone.idM ASC, eventi.id ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<strong>GE ".$row['municipio']."</strong> <a href='evento.php?id=".$row['id']."'>".$row['titolo']."</a> id:".$row['id']."  - anno: ".$row['anno']." - ";
     print "Dal: ".$row['dataInizio'].", ore ".$row['oreInizio']." - Al: ".$row['dataFine']." ore ".$row['oreFine'];     print "<br />";
	 }

?>
<br /><br />

<h4>Seleziona Evento per zona / Genova e provincia</h4>
<?php

	 $sql="SELECT eventi.id,titolo,comune,anno,dataInizio,oreInizio,dataFine,oreFine   
     FROM eventi,eventi_zone,comuni,eventi_dateore 
     WHERE eventi.id=eventi_zone.id 
     AND eventi.id=eventi_dateore.id
     AND eventi_zone.idC=comuni.idC 
     AND eventi_zone.idP='1' AND eventi_zone.idC!='0'  
     ORDER BY eventi_zone.idC ASC, eventi.id DESC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<strong>".$row['comune']."(GE) </strong> <a href='evento.php?id=".$row['id']."'>".$row['titolo']."</a> id:".$row['id']." - anno: ".$row['anno']." - ";
     print "Dal: ".$row['dataInizio'].", ore ".$row['oreInizio']." - Al: ".$row['dataFine']." ore ".$row['oreFine'];     print "<br />";
	 }

?>
<br /><br />

<h4>Seleziona Evento per zona / Fuori Genova</h4>
<?php

	 $sql="SELECT eventi.id,titolo,anno,dataInizio,oreInizio,dataFine,oreFine    
     FROM eventi,eventi_zone,eventi_dateore
     WHERE eventi.id=eventi_zone.id 
     AND eventi.id=eventi_dateore.id
     AND eventi_zone.idC!='25'  
     ORDER BY eventi.id DESC, eventi_zone.idC ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<a href='evento.php?id=".$row['id']."'>".$row['titolo']."</a> id:".$row['id']." - anno: ".$row['anno']." - ";
     print "Dal: ".$row['dataInizio'].", ore ".$row['oreInizio']." - Al: ".$row['dataFine']." ore ".$row['oreFine'];     print "<br />";
	 }

?>
<br /><br />
