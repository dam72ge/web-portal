<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../reti-clienti">Collegamenti Reti-Clienti</a> | Modifica collegamenti singola Attività cliente</h3>

<?php
print "<h4>Gestisci collegamenti Attività</h4>";

print "Seleziona<br />";
	 $sql="SELECT idAttivita,attivita
     FROM attivita
     ORDER BY attivita ASC
     ";
	 
	$query=mysqli_query($conn,$sql);
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        print "<a href='cliente.php?idAttivita=".$q['idAttivita']."'>".$q['attivita']."</a><br />";
     }
    
?>

