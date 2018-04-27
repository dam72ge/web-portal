<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";


// seleziona prima la provincia recuperando dati da url
$idP=1; // provincia default: Genova
if (isset($_GET['idP'])) {
$idP=$_GET['idP'];
}

// js onChange
echo "<script type=\"text/javascript\" language=\"JavaScript\">\n";
echo "function cambia(idP){location.href='?idP='+idP;}";
echo "</script>"; 


$tabella="comuni";
$salva="n";

// salvataggi
if (isset($_POST['newComune'])) {
$sql_c="SELECT idR FROM province WHERE idP='".$_POST['newIdP']."'";
$query_c=mysqli_query($conn,$sql_c);
$row=mysqli_fetch_array($query_c,MYSQLI_ASSOC);
$newIdR=$row['idR'];

    $q['sel'][]="idC"; $q['val'][]="";
    $q['sel'][]="comune"; $q['val'][]=$_POST['newComune'];
    $q['sel'][]="idP"; $q['val'][]=$_POST['newIdP'];
    $q['sel'][]="idR"; $q['val'][]=$newIdR;
    $db->tbl_insert($conn,$tabella,$q);

$salva="s";
}

if (isset($_POST['comune'])) {
$sql_c="SELECT idR FROM province WHERE idP='".$_POST['idP']."'";
$query_c=mysqli_query($conn,$sql_c);
$row=mysqli_fetch_array($query_c,MYSQLI_ASSOC);
$idR=$row['idR'];

    $q['sel'][]="comune"; $q['val'][]=$_POST['comune'];
    $q['sel'][]="idP"; $q['val'][]=$_POST['idP'];
    $q['sel'][]="idR"; $q['val'][]=$idR;
    $where="idC='".$_POST['idC']."'";
    $db->tbl_update($conn,$tabella,$q,$where);       

$salva="s";
}
if (isset($_POST['rimoz'])) {
if ($_POST['rimoz']=="s") {
   $sql="DELETE FROM comuni WHERE idC='".$_POST['idC']."'"; $query=mysqli_query($conn,$sql); 
$salva="s";
}
}

// ricarica pagina dopo salvataggi
if ($salva=="s") {
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='comuni.php?idP=".$idP."';\n"; 
    echo "</script>"; 
}
?>

<h3><a href="index.php">Gestione cartelle</a> | Comuni</h3> 
<br /><br />

<h4>Provincia</h4>
<form name="selProv" action="?" method="post">
Seleziona comuni per Regione+Provincia:<br />
<select name="idP" onchange="cambia(this.value);">
<?php
$nome=""; $provSelez="";
$sql="SELECT idP,provincia,regione FROM province,regioni WHERE regioni.idR=province.idR ORDER BY regione ASC, provincia ASC";
$query=mysqli_query($conn,$sql);
while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    print "<option value='".$q['idP']."'";
    $nome=$myobj->convTxt($q['provincia']);
    if ($q['idP']==$idP) { print " selected"; $provSelez=$nome;}
    $nomeReg=$myobj->convTitle($q['regione']);
    print ">".strtoupper($nomeReg).", ".ucwords($nome)."</option>";
}
?>
</select>
</form>
<br /><br />


<?php
// form

$sql="SELECT idC,comune,idP,idR 
FROM comuni
WHERE idP='".$idP."' 
ORDER BY comune ASC";
$query=mysqli_query($conn,$sql);
while($cart=mysqli_fetch_array($query,MYSQLI_ASSOC)){
print "<form id='formCart_".$cart['idC']."' method='post' action='?'><p>";
print "<label>id</label><input type='text' name='idC' value='".$cart['idC']."' size='5' /> "; //disabled='yes' 
print "<select options='1' name='rimoz'>";
print "<option value='n' selected>Mantieni</option>";
print "<option value='s' >RIMUOVI</option>";
print "</select>";

// se comune ha municipi -> link
$sql_m="SELECT idM FROM municipi WHERE idC='".$cart['idC']."' "; 
$query_m=mysqli_query($conn,$sql_m); $munic=mysqli_fetch_array($query_m,MYSQLI_ASSOC);
if (isset($munic) && $munic['idM']>0) {
    print "<a href='municipi.php?idC=".$cart['idC']."'>Vai ai Municipi</a>";
}

print "<br />";
print "<input type='text' name='comune' value='".ucfirst($cart['comune'])."' size='40' /> ";    

// seleziona provincia
print "<select name='idP' options='1'>";

$sql_c="SELECT idP,provincia,sigla,regione 
FROM province,regioni 
WHERE province.idR=regioni.idR
ORDER BY regione ASC, provincia ASC"; //AND province.idR='".$cart['idR']."' 

$query_c=mysqli_query($conn,$sql_c);
while($elenco=mysqli_fetch_array($query_c,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idP']."' ";
    if ($elenco['idP']==$cart['idP']) { print " selected";}
    print ">".strtoupper($elenco['regione']).", ".ucwords($elenco['provincia'])." </option>";
} 

print "</select>";
print "<br /><input type='submit' name='salva' value='SALVA' />";
print "</p></form><br /><br />";
}
?>
<br /><br />


<h4>Aggiungi Comune in Provincia di <?php print ucwords($provSelez); ?></h4>
<form id='newCart' method='post' action='?'><p>
<label>Comune</label> <input type='text' name='newComune' value='' size='50' /> 
<input type='hidden' name='newIdP' value='<?php print $idP; ?>' />
<input type='submit' name='salva' value='SALVA' /><br /><br />
</p></form>

