<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="index.php">Gestione cartelle</a> | Regioni</h3> 
<br /><br />

<?php
$tabella="regioni";
$salva="n";

if (isset($_POST['newRegione'])) {        
    $q['sel'][0]="idR"; $q['val'][0]="";
    $q['sel'][1]="regione"; $q['val'][1]=$_POST['newRegione'];
    $db->tbl_insert($conn,$tabella,$q);
$salva="s";
}
if (isset($_POST['regione'])) {
    $q['sel'][0]="regione"; $q['val'][0]=$_POST['regione']; 
    $where="idR='".$_POST['idR']."'";
    $db->tbl_update($conn,$tabella,$q,$where);       
$salva="s";
}
if (isset($_POST['rimoz'])) {
if ($_POST['rimoz']=="s") {
    $where="idR='".$_POST['idR']."'";
    $db->tbl_delete($conn,$tabella,$where);
$salva="s";
}
}

// ricarica pagina dopo salvataggi
if ($salva=="s") {
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='regioni.php';\n"; 
    echo "</script>"; 
}
?>

<h4>Modifica regioni</h4>

<?php
$sql="SELECT idR,regione
FROM regioni 
ORDER BY regione ASC";

$query=mysqli_query($conn,$sql);
while($cart=mysqli_fetch_array($query,MYSQLI_ASSOC)){
print "<form id='formCart_".$cart['idR']."' method='post' action='?'><p>";
print "<label>id</label><input type='text' name='idR' value='".$cart['idR']."' size='5' /> "; //disabled='yes' 
print "<select options='1' name='rimoz'>";
print "<option value='n' selected>Mantieni</option>";
print "<option value='s' >RIMUOVI</option>";
print "</select><br />";
$nome=$myobj->mb_convert_encoding($cart['regione']);
print "<input type='text' name='regione' value='".$nome."' size='40' /> ";
print "<a href='province.php?idR=".$cart['idR']."'>Vai alle province</a>";
print "<br /><input type='submit' name='salva' value='SALVA' />";
print "</p></form><br /><br />";
}
?>
<br /><br />
<h4>Aggiungi regione</h4>
<form id='newCart' method='post' action='?'><p>
<label>Regione</label> <input type='text' name='newRegione' value='' size='40' /> 
<br /><input type='submit' name='salva' value='SALVA' />
</p></form>

