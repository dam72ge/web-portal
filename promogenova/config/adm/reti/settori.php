<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../reti">Reti</a> | Modifica SETTORE</h3>

<?php
// modifica
if (isset($_POST['settore']) && isset($_POST['upd']) && $_POST['upd']=="mantieni") {
	  $sql="UPDATE reti_settori SET 
	  settore='".mysql_real_escape_string(stripslashes($_POST['settore']))."'
	  WHERE idSett='".$_POST['idSett']."'";
      $query=mysqli_query($conn,$sql);
}
// elimina
if (isset($_POST['upd']) && $_POST['upd']=="elimina") {
      $sql="DELETE FROM reti_settori WHERE idSett='".$_POST['idSett']."'";
    $query=mysqli_query($conn,$sql);
}
// nuovo
if (isset($_POST['upd']) && $_POST['upd']=="new") {
      $sql = 
    "
    INSERT INTO reti_settori
    (settore) 
    VALUES 
    ( 
    '".mysql_real_escape_string(stripslashes($_POST['settore']))."'
    )";

    $query=mysqli_query($conn,$sql);
	//$idSett=mysql_insert_id();
}
    


print "<h4>Modifica Settori</h4>";

	 $sql="SELECT idSett,settore
     FROM reti_settori ORDER BY settore ASC, idSett ASC";	 
	 $query=mysqli_query($conn,$sql);
	 while($settori=mysqli_fetch_array($query,MYSQLI_ASSOC)){     
?>
  <form id="modSett_<?php print $settori['idSett']; ?>" method="post" action="?"><p>
  <label>Sett.</label> <input type="text" size="5" name="id" value="<?php print $settori['idSett']; ?>" disabled="yes" />
  <input type="text" size="50" name="settore" value="<?php print $settori['settore']; ?>" />  
  <select name="upd" options="1">
  <option value="mantieni">Mantieni</option>
  <option value="elimina">ELIMINA</option>
  </select>
  <input type="hidden" name="idSett" value="<?php print $settori['idSett']; ?>" />
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
<?php
     }
?>

<br /><br />

<h4>Nuovi settori</h4>
  <form id="newSett" method="post" action="?"><p>
  <label>Settore</label> <input type="text" size="5" name="id" value="[nuovo]" disabled="yes" />
  <input type="text" size="50" name="settore" value="" />
  <input type="hidden" name="upd" value="new" />
  <input type="submit" name="salva" value="SALVA"  />
  </p></form>
