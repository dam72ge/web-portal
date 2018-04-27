<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../attivita">Attivita'</a> | Seleziona attività che possono promuovere fuori zona</h3>

<h4>Seleziona Attivita' che possono promuovere articoli fuori zona</h4>

<?php
//print "<span class='rosso'>Data di oggi: ".substr($oggi,6,2)."/".substr($oggi,4,2)."/".substr($oggi,0,4)."</span><br/><br/>";

	 $sql="SELECT attivita.idAttivita,attivita 
     FROM attivita,att_clienti
     WHERE attivita.idAttivita=att_clienti.idAttivita
     AND creaPromo='s' 
     ORDER BY attivita ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<a href='cliente.php?id=".$row['idAttivita']."'>".$row['attivita']." (id:".$row['idAttivita'].")</a><br />";
	 }

?>
<br /><br />
