<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="index.php">Gestione cartelle</a> | Municipi</h3> 
<br /><br />

<?php
// seleziona prima il comune recuperando dati da url
$idC=25; // comune default: Genova
if (isset($_GET['idC'])) {
$idC=$_GET['idC'];
}

$sql_c="SELECT comune,idP,idR FROM comuni WHERE idC='".$idC."'";
$query_c=mysqli_query($conn,$sql_c);
$c=mysqli_fetch_array($query_c,MYSQLI_ASSOC);
$comuneSelez=$c['comune'];
$idP=$c['idP'];
$idR=$c['idR'];

// js onChange
echo "<script type=\"text/javascript\" language=\"JavaScript\">\n";
echo "function cambia(idC){location.href='?idC='+idC;}";
echo "</script>"; 

$tabella="municipi";
$salva="n";

if (isset($_POST['newMunicipio'])) {
$sql_c="SELECT idR,idP FROM comuni WHERE idC='".$idC."'";
$query_c=mysqli_query($conn,$sql_c);
$row=mysqli_fetch_array($query_c,MYSQLI_ASSOC);

    $q['sel'][]="idM"; $q['val'][]="";
    $q['sel'][]="municipio"; $q['val'][]=$_POST['newMunicipio'];
    $q['sel'][]="idC"; $q['val'][]=$idC;
    $q['sel'][]="idP"; $q['val'][]=$idP;
    $q['sel'][]="idR"; $q['val'][]=$idR;
    $q['sel'][]="coord"; $q['val'][]="";
    $db->tbl_insert($conn,$tabella,$q);

$salva="s";
}
if (isset($_POST['idM'])) {
$sql_c="SELECT idR,idP FROM comuni WHERE idC='".$idC."'";
$query_c=mysqli_query($conn,$sql_c);
$row=mysqli_fetch_array($query_c,MYSQLI_ASSOC);

    $q['sel'][]="municipio"; $q['val'][]=$_POST['municipio'];
    $q['sel'][]="idC"; $q['val'][]=$idC;
    $q['sel'][]="idP"; $q['val'][]=$idP;
    $q['sel'][]="idR"; $q['val'][]=$idR;
    $where="idM='".$_POST['idM']."'";
    $db->tbl_update($conn,$tabella,$q,$where);       

$salva="s";
}
if (isset($_POST['rimoz'])) {
if ($_POST['rimoz']=="s") {
   $sql="DELETE FROM municipi WHERE idM='".$_POST['idM']."'"; $query=mysqli_query($conn,$sql); 
$salva="s";
}
}

// ricarica pagina dopo salvataggi
if ($salva=="s") {
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='municipi.php?idC=".$idC."';\n"; 
    echo "</script>"; 
}
?>
<h4>Comune</h4>
<form name="selProv" action="?" method="post">
Seleziona Comuni con municipi<br />
<select name="idC" onchange="cambia(this.value);">
<?php
$nome=""; $provSelez="";
$sql="SELECT idC,comune,sigla FROM comuni,province WHERE province.idP=comuni.idP ORDER BY comune ASC, provincia ASC";
$query=mysqli_query($conn,$sql);
while($q=mysql_fetch_array($query)){
    $sql_m="SELECT idM FROM municipi WHERE idC='".$q['idC']."'";
    $query_m=mysqli_query($conn,$sql_m);
    $munic=mysqli_fetch_array($query_m,MYSQLI_ASSOC);
    if (isset($munic) && $munic['idM']>0) {
        print "<option value='".$q['idC']."'";
        $nome=$myobj->mb_convert_encoding($q['comune']);
        if ($q['idC']==$idC) { print " selected"; $comuneSelez=$nome;}
        print ">".ucwords($nome)." (".$q['sigla'].")</option>";
    }
}
?>
</select>
</form>
<br /><br />

<h4>Modifica Municipi</h4>

<?php
$sql="SELECT idM, municipio
FROM municipi
WHERE idC='".$idC."'  
ORDER BY municipio ASC";
$query=mysqli_query($conn,$sql);
while($cart=mysql_fetch_array($query)){
print "<form id='formCart_".$cart['idM']."' method='post' action='?idC=".$idC."'><p>";
print "<label>id</label><input type='text' name='idM' value='".$cart['idM']."' size='5'  /> ";
print "<select options='1' name='rimoz'>";
print "<option value='n' selected>Mantieni</option>";
print "<option value='s' >RIMUOVI</option>";
print "</select>";
print "<br />";
print "<input type='text' name='municipio' value='".ucfirst($cart['municipio'])."' size='40' /><br /> ";   
print "<br />";
print "<label>Quartieri compresi</label>: ";

$sql_c="SELECT idQ,quartiere FROM quartieri WHERE idM='".$cart['idM']."' ORDER BY quartiere ASC";
$query_c=mysqli_query($conn,$sql_c);
while($elenco=mysqli_fetch_array($query_c,MYSQLI_ASSOC)){
    print "<a href='quartieri.php?idM=".$cart['idM']."'>".$elenco['quartiere']."</a> ";
}
print "<br /><br />";
print " <input type='submit' name='salva' value='SALVA' />";
print "</p></form><br /><br /><br />";
}
?>
<br /><br />
<h4>Aggiungi Municipio nel Comune di <?php print $comuneSelez; ?></h4>
<form id='newCart' method='post' action='?idC=<?php print $idC; ?>'><p>
<label>Municipio</label> <input type='text' name='newMunicipio' value='' size='40' />
<input type='submit' name='salva' value='SALVA' />
</p></form>

