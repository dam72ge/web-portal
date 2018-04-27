<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../attivita">Attivita'</a> | <a href="../attivita/seleziona.php">Seleziona attività </a> | Modifica parole chiave</h3>

<?php
// recupera dati da url
$id=$_GET['id'];

// modifiche
if (isset($_POST['parola'])) {
	  $sql="UPDATE vetrine_tag SET 
	  parola='".mysqli_real_escape_string($conn,stripslashes($_POST['parola']))."'
	  WHERE id='".$_POST['idTag']."'";
      $query=mysqli_query($conn,$sql);
}
// eliminare?
if (isset($_POST['rimozParola'])) {
if ($_POST['rimozParola']=="s") {
   $sql="DELETE FROM vetrine_tag WHERE id='".$_POST['idTag']."'"; 
   $query=mysqli_query($conn,$sql); 
}
}
// nuovo
if(isset($_POST['newParola'])){
    $sql = 
    "
    INSERT INTO vetrine_tag
    (id,idAttivita,parola) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($id))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newParola']))."'
    )";
	 $query=mysqli_query($conn,$sql);
}


	 $sql="SELECT attivita.idAttivita,attivita
     FROM attivita
     WHERE attivita.idAttivita='".$id."'";
	 
	 $query=mysqli_query($conn,$sql);
	 $cliente=mysqli_fetch_array($query,MYSQLI_ASSOC);

print "<h4>Modifica parole chiave per Attivita' ID:".$id." - <em>".$cliente['attivita']."</em> - ";
$succ=$id+1; print "<a href='sel_parole.php?id=".$succ."'>Successivo</a> | ";
$prec=$id-1; print "<a href='sel_parole.php?id=".$prec."'>Precedente</a></h4>";
    
$conta=0;
$sql_d="SELECT id,parola FROM vetrine_tag WHERE idAttivita='".$id."' ORDER BY id ASC";
	 $query_d=mysqli_query($conn,$sql_d);
	 while ($tag=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){	 
$conta++;
    print "<form id='addtag_".$tag['id']."' method='post' action='?id=".$id."'>";
    print "<input type='hidden' name='idTag' value='".$tag['id']."'>";
    print "<input type='text' name='num' size='4' value='".$conta."' disabled='yes'>";
    print "<input type='text' size='30' name='parola' value='".$tag['parola']."'>";
    print "<select name='rimozParola' option='1'>";
    print "<option value='n' selected>mantieni</option>";
    print "<option value='s' >RIMUOVI</option>";
    print "</select>";
    print " <input type='submit' name='salva' value='SALVA' />";
    print "</form>";

}
?>
<br /><br />

    <h4>Aggiungi parole</h4>
  <form id="addParole" method="post" action="?id=<?php print $id; ?>"><p>
  <input type="text" size="30" name="newParola" value="" />
  <input type="submit" name="salva" value="AGGIUNGI"  />
  </p></form>
  <br /><br />
  

<br /><br />
