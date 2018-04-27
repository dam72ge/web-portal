<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../statistiche">Statistiche</a> | Eventi</h3>

<?php
$sql="SELECT id,titolo,home FROM eventi ORDER BY id DESC";
$query=mysqli_query($conn,$sql);			
while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
$visite_home=0;
$visite_nohome=0;
$visite_cliente=0;
$visite_rete=0;
$visite_tot=0;

print $q['id'].") <strong>".$q['titolo']."</strong><br />";

    // leggi statistiche eventi
	$sql1="SELECT idStat,visite,idAttivita,idRete FROM stat_eventi WHERE title LIKE '".mysqli_real_escape_string($conn,stripslashes($q['titolo']))."'";
    $query1=mysqli_query($conn,$sql1);			
    while($riga=mysqli_fetch_array($query1,MYSQLI_ASSOC)){
        
        if ($riga['idAttivita']>0 && $riga['idRete']==0) { 
            $visite_cliente=$visite_cliente+$riga['visite']; print "Visite eventi di/con clienti: ".$visite_cliente.", ";
}
        if ($riga['idRete']>0 && $riga['idAttivita']==0) { 
            $visite_rete=$visite_rete+$riga['visite']; print "Visite eventi di/con reti: ".$visite_rete.", ";
}
        if ($q['home']=="s" && $riga['idAttivita']==0 && $riga['idRete']==0) { 
            $visite_home=$visite_home+$riga['visite']; print "Visite eventi in homepage: ".$visite_home.", ";} 
        if ($q['home']=="n" && $riga['idAttivita']==0 && $riga['idRete']==0) { $visite_nohome=$visite_nohome+$riga['visite']; print "Visite eventi non in homepage: ".$visite_nohome.", ";}

    	$visite_tot=$visite_tot+$riga['visite'];
	}

        print "TOTALE= <strong>".$visite_tot."</strong><br /><br />";
}

?>
