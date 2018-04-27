<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";

$idAttivita=$_GET['idAttivita'];

$sql="SELECT attivita FROM attivita WHERE idAttivita='".$idAttivita."'";
$query=mysqli_query($conn,$sql);
$q=mysqli_fetch_array($query,MYSQLI_ASSOC);
$attivita=$q['attivita'];

?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../reti-clienti">Collegamenti Reti-Clienti</a> | <a href="clienti-reti.php">Seleziona cliente</a> | Modifica collegamenti singola Attività cliente</h3>

<?php
// rimuovi
if (isset($_POST['upd']) && $_POST['upd']=="rimuovi") {
	  $sql="DELETE FROM vetrine_reti WHERE idRete='".$_POST['idRete']."' AND idAttivita='".$idAttivita."'";
      $query=mysqli_query($conn,$sql);
}

// aggiungi
if (isset($_POST['upd']) && $_POST['upd']=="aggiungi") {
    $sql = 
    "
    INSERT INTO vetrine_reti
    (id,idAttivita,idRete) 
    VALUES 
    ( 
    default,
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['idRete']))."'
    )";
    $query=mysqli_query($conn,$sql);
}


print "<h4>Gestisci i collegamenti di <em>".$attivita."</em> - Id: ".$idAttivita."</h4>";


print "Reti attualmente collegate<br />";

$sql_d="SELECT id,reti.idRete,rete FROM vetrine_reti,reti WHERE vetrine_reti.idRete=reti.idRete AND idAttivita='".$idAttivita."' ORDER BY rete ASC";
$query_d=mysqli_query($conn,$sql_d);       
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<form id='rim_".$elenco['idRete']."' method='post' action='?idAttivita=".$idAttivita."'>";
    print "<input type='text' size='40' name='rete' value='".$elenco['idRete'].") ".$elenco['rete']."' disabled />";
    print "<input type='hidden' name='idRete' value='".$elenco['idRete']."' />";
    print "<input type='hidden' name='upd' value='rimuovi' />";
    print "<input type='submit' name='salva' value='RIMOVI' />";
    print "</form>";
}

print "<br /><br />";
print "Aggiungi una rete<br />";
print "<form id='addRete' method='post' action='?idAttivita=".$idAttivita."'>";
print "<select name='idRete' options='1'>";
    $sql="SELECT idRete,rete FROM reti ORDER BY rete ASC";
    $query=mysqli_query($conn,$sql);
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    print "<option value='".$q['idRete']."'>".$q['rete']."<br />";
    }
print "</select>";
print "<input type='hidden' name='upd' value='aggiungi' />";
print "<input type='submit' name='salva' value='AGGIUNGI' />";
print "</form>";
?>

