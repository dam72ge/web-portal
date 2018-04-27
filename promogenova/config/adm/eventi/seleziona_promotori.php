<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../eventi">Eventi</a> | Seleziona eventi</h3>

<h4>Seleziona Eventi pubblicizzati in homepage su PROMOGENOVA.IT</h4>
<?php

	 $sql="SELECT eventi.id,titolo,anno,dataInizio,oreInizio,dataFine,oreFine
     FROM eventi,eventi_dateore
     WHERE eventi.id=eventi_dateore.id
     AND home='s' 
     ORDER BY eventi.id DESC";
     	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 

     print "<strong>".$row['anno']."</strong> <a href='evento.php?id=".$row['id']."'>".$row['titolo']."</a> id:".$row['id']." - ";
     print "Dal: ".$row['dataInizio'].", ore ".$row['oreInizio']." - Al: ".$row['dataFine']." ore ".$row['oreFine'];     print "<br />";
	 }

?>
<br /><br />

<h4>Seleziona Eventi promossi da Attività clienti</h4>
<?php

	 $sql="SELECT eventi.id,titolo,anno,dataInizio,oreInizio,dataFine,oreFine,attivita.idAttivita,attivita.attivita 
     FROM eventi,eventi_promot,attivita,eventi_dateore
     WHERE eventi.id=eventi_promot.id 
     AND eventi.id=eventi_dateore.id
     AND eventi_promot.idAttivita=attivita.idAttivita   
     ORDER BY attivita.attivita ASC, eventi.id ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "Attività <strong>".$row['attivita']."</strong>, <a href='evento.php?id=".$row['id']."'>".$row['titolo']."</a> id:".$row['id']." - ";
     print "Dal: ".$row['dataInizio'].", ore ".$row['oreInizio']." - Al: ".$row['dataFine']." ore ".$row['oreFine'];     print "<br />";
	 }

?>
<br /><br />

<h4>Seleziona Eventi promossi da Reti</h4>
<?php

	 $sql="SELECT eventi.id,titolo,reti.idRete,reti.rete,anno,dataInizio,oreInizio,dataFine,oreFine 
     FROM eventi,eventi_promot,reti,eventi_dateore
     WHERE eventi.id=eventi_promot.id 
     AND eventi.id=eventi_dateore.id
     AND eventi_promot.idRete=reti.idRete   
     ORDER BY reti.rete ASC, eventi.id ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "Rete <strong>".$row['rete']."</strong>, <a href='evento.php?id=".$row['id']."'>".$row['titolo']."</a> id:".$row['id']." - ";
     print "Dal: ".$row['dataInizio'].", ore ".$row['oreInizio']." - Al: ".$row['dataFine']." ore ".$row['oreFine'];     print "<br />";
	 }

?>
<br /><br />
