<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | Area download</h3>
<br /><br />

Operazioni gestione su file caricati sul server:<br />
<a href="nuovo.php">PUBBLICA NUOVO FILE</a><br /><br/><br/>


<h4>Seleziona file registrati nel database</h4>
<?php
//print "<span class='rosso'>Data di oggi: ".substr($oggi,6,2)."/".substr($oggi,4,2)."/".substr($oggi,0,4)."</span><br/><br/>";

	 $sql="SELECT idFile,nome 
     FROM download
     ORDER BY idFile ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
  print "<a href='file.php?id=".$row['idFile']."'>".$row['nome']." (id:".$row['idFile'].")</a><br />";
	 }

?>
<br /><br />
