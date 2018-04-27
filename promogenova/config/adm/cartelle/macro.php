<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="index.php">Gestione cartelle</a> | Categorie commerciali</h3> 
<br /><br />

<?php
$tabella="macro";

if (isset($_POST['newMacro'])) {
    $q['sel'][]="idMacro"; $q['val'][]="";
    $q['sel'][]="macro"; $q['val'][]=$_POST['newMacro'];
    $q['sel'][]="descriz"; $q['val'][]=$_POST['newDescriz'];
    $db->tbl_insert($conn,$tabella,$q);
}
if (isset($_POST['macro'])) {
    $q['sel'][]="macro"; $q['val'][]=$_POST['macro'];
    $q['sel'][]="descriz"; $q['val'][]=$_POST['descriz'];
    $where="idMacro='".$_POST['idMacro']."'";
    $db->tbl_update($conn,$tabella,$q,$where);       
}
if (isset($_POST['rimoz'])) {
if ($_POST['rimoz']=="s") {
   $sql="DELETE FROM macro WHERE idMacro='".$_POST['idMacro']."'"; $query=mysqli_query($conn,$sql); 
}
}
?>

<h4>Modifica categorie</h4>

<?php
$sql="SELECT idMacro,macro,descriz
FROM macro  
ORDER BY macro ASC, idMacro ASC";

$query=mysqli_query($conn,$sql);
while($macro=mysqli_fetch_array($query,MYSQLI_ASSOC)){
print "<form id='formMacro_".$macro['idMacro']."' method='post' action='?'><p>";
print "<label>id</label><input type='text' name='idMacro' value='".$macro['idMacro']."' size='5' /> "; //disabled='yes' 
print "<select options='1' name='rimoz'>";
print "<option value='n' selected>Mantieni</option>";
print "<option value='s' >RIMUOVI</option>";
print "</select><br />";
print "<textarea name='macro' rows='1' cols='40'>".$macro['macro']."</textarea><br />";
print "<textarea name='descriz' rows='2' cols='40'>".$macro['descriz']."</textarea>";
print "<br /><input type='submit' name='salva' value='SALVA' />";
print "</p></form><br /><br />";
}
?>
<br /><br />
<h4>Aggiungi categoria</h4>
<form id='newMacro' method='post' action='?'><p>
<label>Categoria</label><br /></label><textarea name='newMacro' rows='1' cols='40'></textarea><br />
<label>Descrizione</label><br /><textarea name='newDescriz' rows='2' cols='40'></textarea>
<br /><input type='submit' name='salva' value='SALVA' />
</p></form>

