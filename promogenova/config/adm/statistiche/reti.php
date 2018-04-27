<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../statistiche">Statistiche</a> | Reti</h3>

<?php
$sql="SELECT idRete,rete FROM reti ORDER BY rete ASC";
$query=mysqli_query($conn,$sql);			
while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
$visite_scheda=0;
$visite_eventi=0;
$visite_tot=0;

print $q['idRete'].") <strong>".$q['rete']."</strong><br />";

    // leggi statistiche vetrina+articoli+foto
	$sql1="SELECT visite FROM stat_reti WHERE idRete='".$q['idRete']."'";
    $query1=mysqli_query($conn,$sql1);			
    while($riga=mysqli_fetch_array($query1,MYSQLI_ASSOC)){
    	$visite_tot=$visite_tot+$riga['visite'];
        $visite_scheda=$visite_scheda+$riga['visite']; 
	}

    // leggi statistiche eventi
	$sql1="SELECT visite FROM stat_eventi WHERE idRete='".$q['idRete']."'";
    $query1=mysqli_query($conn,$sql1);			
    while($riga=mysqli_fetch_array($query1,MYSQLI_ASSOC)){
    	$visite_tot=$visite_tot+$riga['visite'];
        $visite_eventi=$visite_eventi+$riga['visite']; 
	}

print "scheda: ".$visite_scheda.", ";
print "eventi: ".$visite_eventi.", ";
print "TOTALE= <strong>".$visite_tot."</strong><br /><br />";
}

?>
