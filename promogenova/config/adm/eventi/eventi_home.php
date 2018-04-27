<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../eventi">Eventi</a> | Fissa eventi in HOMEPAGE</h3>

<h4>Seleziona TRE eventi da fissare in Homepage</h4><br/>

<?php
// cambia evento per campo
if (isset($_POST['nuovoEv'])) {
      $campo=$_GET['campo'];
	  $sql="UPDATE eventi_home SET 
	  id='".mysqli_real_escape_string($conn,stripslashes($_POST['nuovoEv']))."'
	  WHERE idEv='".$campo."'";
      $query=mysqli_query($conn,$sql);
}

	 $sql="SELECT idEv,id
     FROM eventi_home
     ORDER BY idEv ASC
     ";
    
    $query=mysqli_query($conn,$sql);
    while($eventi=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $n=$eventi['idEv']+1;
    print "Evento #".$n.": <strong>".$eventi['id']."</strong><br />";
    
            print "<form id='modifEv' method='post' action='?campo=".$eventi['idEv']."'><p>";
            print "<select options='1' name='nuovoEv'>";
            print "<option value='0'>== CAMPO VUOTO / NESSUN EVENTO ==</option>";
            $sql_d="SELECT id,titolo FROM eventi ORDER BY id DESC";
            $query_d=mysqli_query($conn,$sql_d);       
            while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
                    print "<option value='".$elenco['id']."'";
                    if ($elenco['id']==$eventi['id']) { print " selected"; }
                    print ">".$elenco['id']." - ".$elenco['titolo']."</option>";
           }
            print "</select>";
            print "<input type='submit' name='salva' value='SALVA' />";
            print "</p></form>";
           print "<br />";
    }

?><br /><br />
