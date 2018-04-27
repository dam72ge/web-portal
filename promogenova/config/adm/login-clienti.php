<?php
session_start();
//print "Session admin: ".$_SESSION['admin']."<br /><br />";
if (!isset($_SESSION['admin'])){
$msg="Accesso negato."; 
$redirpag="login-errore.php?msg=".$msg;
header("location: $redirpag");
}

$url="../"; 
include "../mydb.php";
?>

<a href="index.php"><h1>Admin portale</h1></a>
<h3>Loggati anche come cliente</h3>
<br /><br />

  <form id="selVetr" method="post" action="login-cliente-redirect.php">
  <p>
  <label>Seleziona cliente<label><br/>
  <select name="idAttivita" options=1>
  <?php
    $sql="
    SELECT attivita.idAttivita,attivita 
    FROM attivita,att_clienti 
    WHERE attivita.idAttivita=att_clienti.idAttivita
    ORDER BY attivita ASC
    ";
    $query=mysqli_query($conn,$sql);			
    while($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        print "<option value='".$riga['idAttivita']."'>".$riga['attivita']." [id:".$riga['idAttivita']."]</option>";
    }
  ?>
  </select>
  </p>
  <br/>
  <input type="submit" name="trova" value=" ENTRA " class="bottSubmit" />
  <form>


