<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../statistiche">Statistiche</a> | Attivita clienti</h3>

<?php
$sql="SELECT idAttivita,attivita FROM attivita ORDER BY attivita ASC";
$query=mysqli_query($conn,$sql);			
while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
$visite_old=0; 
$visite_vetrina=0;
$visite_eventi=0;
$visite_foto=0;
$visite_articoli=0;
$visite_tot=0;

print $q['idAttivita'].") <strong>".$q['attivita']."</strong><br />";

    // leggi statistiche vetrina+articoli+foto
	$sql1="SELECT visite,tipo FROM stat_vetrine WHERE idAttivita='".$q['idAttivita']."'";
    $query1=mysqli_query($conn,$sql1);			
    while($riga=mysqli_fetch_array($query1,MYSQLI_ASSOC)){
    	$visite_tot=$visite_tot+$riga['visite'];
        switch ($riga['tipo']){ 
        	case "vetrina + promozioni vecchio portale": 
            $visite_old=$visite_old+$riga['visite']; 
            break;
        	case "vetrina": 
            $visite_vetrina=$visite_vetrina+$riga['visite']; 
            break;
        	case "foto": 
            $visite_foto=$visite_foto+$riga['visite']; 
            break;
        	case "articolo": 
            $visite_articoli=$visite_articoli+$riga['visite']; 
            break;
        }        
	}

    // leggi statistiche eventi
	$sql1="SELECT visite FROM stat_eventi WHERE idAttivita='".$q['idAttivita']."'";
    $query1=mysqli_query($conn,$sql1);			
    while($riga=mysqli_fetch_array($query1,MYSQLI_ASSOC)){
    	$visite_tot=$visite_tot+$riga['visite'];
        $visite_eventi=$visite_eventi+$riga['visite']; 
	}

print "vecchia vetrina: ".$visite_old.", ";
print "vetrina: ".$visite_vetrina.", ";
print "foto: ".$visite_foto.", ";
print "articoli: ".$visite_articoli.", ";
print "eventi: ".$visite_eventi.", ";
print "TOTALE= <strong>".$visite_tot."</strong><br /><br />";
}

?>
