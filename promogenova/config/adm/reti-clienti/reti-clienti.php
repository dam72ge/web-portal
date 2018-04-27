<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../reti-clienti">Collegamenti Reti-Clienti</a> | Modifica collegamenti singola Rete</h3>

<?php
// rimuovi
if (isset($_POST['modifica']) && $_POST['modifica']=="rimuovi") {
    $id=$_GET['id'];
    $sql="DELETE FROM vetrine_reti WHERE id='".$id."'";
    $query=mysqli_query($conn,$sql);
}


print "<h4>Reti e Attività collegate</h4>";

	 $sql="SELECT idRete,rete
     FROM reti
     ORDER BY rete ASC
     ";
	 
	$query=mysqli_query($conn,$sql);
    while($rete=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    print "Rete: <strong>".$rete['rete']."</strong> - ID: <strong>".$rete['idRete']."</strong><br />";
    print "<em>Attività collegate</em><br />";

        $sql_d="SELECT id,attivita FROM vetrine_reti,attivita WHERE vetrine_reti.idAttivita=attivita.idAttivita AND idRete='".$rete['idRete']."' ORDER BY attivita ASC";
        $query_d=mysqli_query($conn,$sql_d);       
        while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
            print "<form id='modifCollegRete_".$elenco['id']."' method='post' action='?id=".$elenco['id']."'><p>";
            print "<input type='text' size='5' name='id' value='".$elenco['id']."' disabled='yes'>";
            print "<input type='text' size='40' name='attivita' value='".$elenco['attivita']."' disabled='yes'>";
            print "<select options='1' name='modifica'>";
            print "<option value='no' selected>Mantieni</option>";
            print "<option value='rimuovi'>RIMUOVI</option>";
            print "</select>";
            print "<input type='submit' name='salva' value='SALVA' />";
            print "</p></form>";
        }
    print "<br /><hr/>";
    }

?>

