<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../attivita">Attivita'</a> | Scadenze</h3>

<h4>Elenco Attivita' per scadenza contratto</h4>

<?php
//print "<span class='rosso'>Data di oggi: ".substr($oggi,6,2)."/".substr($oggi,4,2)."/".substr($oggi,0,4)."</span><br/><br/>";


	 $sql="SELECT attivita.idAttivita,osc,attivita,dataScad,dataAvv,dataOsc 
     FROM attivita,att_scad 
     WHERE attivita.idAttivita=att_scad.idAttivita 
     ORDER BY dataScad ASC,attivita ASC,attivita.idAttivita ASC";
	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
	 if($row['idAttivita']>0){

	 $dati['osc'][]=$row['osc'];
	 $dati['cod'][]=$row['idAttivita'];
	 $dati['dataScad'][]=$row['dataScad'];
	 $dati['dataAvv'][]=$row['dataAvv'];
	 $dati['dataOsc'][]=$row['dataOsc'];
	 $dati['attivita'][]=$row['attivita'];
	 
	 // STATO CONTRATTO-ATTIVITA': attivo-oscurato, avviso rinnovo, scaduto, disattivato (non rinnovato) 
	 $tipo="attivo";
	 $rimovib=$oggi-$row['dataOsc'];
	 if($row['dataOsc']<$oggi && $rimovib>=10000){ $tipo="rimovibile"; }
	 if($row['dataOsc']<$oggi && $rimovib<10000) { $tipo="disattivato"; }
	 if($row['dataScad']<$oggi && $oggi<=$row['dataOsc']){ $tipo="scaduto"; }
	 if($row['dataAvv']<$oggi && $oggi<=$row['dataScad']){ $tipo="avviso"; }
	 $dati['tipo'][]=$tipo;	 
	 }
	 }

print "<b>In scadenza entro 2 settimane</b><br />";
$tot=0;
for ($i=0;$i<count($dati['cod']);$i++){ if ($dati['tipo'][$i]=="avviso"){ 
    $tot++; print substr($dati['dataScad'][$i],6,2)."/".substr($dati['dataScad'][$i],4,2)."/".substr($dati['dataScad'][$i],0,4)." <a href='cliente.php?id=".$dati['cod'][$i]."'>".$dati['attivita'][$i]."</a><br/>"; } 
    }
print "<br/>totale=".$tot."<hr/><br />"; 

print "<b>Scaduti, rinnovo entro 1 mese</b><br />";
$tot=0;
for ($i=0;$i<count($dati['cod']);$i++){ if ($dati['tipo'][$i]=="scaduto"){ $tot++; print  substr($dati['dataScad'][$i],6,2)."/".substr($dati['dataScad'][$i],4,2)."/".substr($dati['dataScad'][$i],0,4)." <a href='cliente.php?id=".$dati['cod'][$i]."'>".$dati['attivita'][$i]."</a><br/>"; } } 
print "<br/>totale=".$tot."<hr /><br />"; 


print "<b>In regola</b><br />";
$tot=0; 
for ($i=0;$i<count($dati['cod']);$i++){ if ($dati['tipo'][$i]=="attivo" && $dati['osc'][$i]=="n"){ $tot++; print substr($dati['dataScad'][$i],6,2)."/".substr($dati['dataScad'][$i],4,2)."/".substr($dati['dataScad'][$i],0,4)." <a href='cliente.php?id=".$dati['cod'][$i]."'>".$dati['attivita'][$i]."</a><br/>"; } } 
print "<br/>totale=".$tot."<hr /><br />"; 

print "<b>Oscurati</b><br />";
$tot=0;
for ($i=0;$i<count($dati['cod']);$i++){ if ($dati['osc'][$i]=="s"){ $tot++; print substr($dati['dataScad'][$i],6,2)."/".substr($dati['dataScad'][$i],4,2)."/".substr($dati['dataScad'][$i],0,4)." <a href='cliente.php?id=".$dati['cod'][$i]."'>".$dati['attivita'][$i]."</a><br/>"; } } 
print "<br/>totale=".$tot."<hr /><br />"; 

print "<b>Ex clienti da meno di 1 anno</b><br />";
for ($i=0;$i<count($dati['cod']);$i++){ if ($dati['tipo'][$i]=="disattivato"){ $tot++; print  substr($dati['dataScad'][$i],6,2)."/".substr($dati['dataScad'][$i],4,2)."/".substr($dati['dataScad'][$i],0,4)." <a href='cliente.php?id=".$dati['cod'][$i]."'>".$dati['attivita'][$i]."</a><br/>"; } } 
print "<br/>totale=".$tot."<hr /><br />"; 

print "<b>Disattivati da oltre 1 anno (Eliminabili)</b><br />";
$tot=0; 
for ($i=0;$i<count($dati['cod']);$i++){ if ($dati['tipo'][$i]=="rimovibile"){ $tot++; print substr($dati['dataScad'][$i],6,2)."/".substr($dati['dataScad'][$i],4,2)."/".substr($dati['dataScad'][$i],0,4)." <a href='?voceAtt=attivita&mod=modif&cod=".$dati['cod'][$i]."'>".$dati['attivita'][$i]."</a><br/>"; } } 
print "<br/>totale=".$tot."<hr /><br />"; 
?>
