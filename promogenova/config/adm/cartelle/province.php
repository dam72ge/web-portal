<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
$idR=1;
if (isset($_GET['idR'])) {
$idR=$_GET['idR'];
}
?>
<h3><a href="index.php">Gestione cartelle</a> | Province</h3> 
<br /><br />

<?php
// js onChange
echo "<script type=\"text/javascript\" language=\"JavaScript\">\n";
echo "function cambia(idR){location.href='?idR='+idR;}";
echo "</script>"; 

$tabella="province";
$salva="n";

if (isset($_POST['newCapoluogo'])) {
$sql_c="SELECT idR,comune FROM comuni WHERE idC='".$_POST['newCapoluogo']."'";
$query_c=mysqli_query($conn,$sql_c);
$row=mysqli_fetch_array($query_c,MYSQLI_ASSOC);
$newProv=$row['comune'];

    $q['sel'][]="idP"; $q['val'][]="";
    $q['sel'][]="provincia"; $q['val'][]=$newProv;
    $q['sel'][]="sigla"; $q['val'][]=strtoupper($_POST['newSigla']);
    $q['sel'][]="capoluogo"; $q['val'][]=$_POST['newCapoluogo'];
    $q['sel'][]="idR"; $q['val'][]=$idR;
    $db->tbl_insert($conn,$tabella,$q);

    // id nuovo
   	$idNuovo=mysqli_insert_id($conn);

    // cambio idP del comune origine in id nuova provincia
    $q1['sel'][]="idP"; $q1['val'][]=$idNuovo;
    $where="idC='".$_POST['newCapoluogo']."'";
    $db->tbl_update($conn,"comuni",$q1,$where);       

$salva="s";
}
if (isset($_POST['provincia']) && $_POST['rimoz']!="s" ){
    $q['sel'][]="provincia"; $q['val'][]=$_POST['provincia'];
    $q['sel'][]="sigla"; $q['val'][]=strtoupper($_POST['sigla']);
    $q['sel'][]="capoluogo"; $q['val'][]=$capol;
    $q['sel'][]="idR"; $q['val'][]=$idR;
    $where="idP='".$_POST['idP']."'";
    $db->tbl_update($conn,$tabella,$q,$where);       
$salva="s";
}
if (isset($_POST['rimoz'])) {
if ($_POST['rimoz']=="s") {
   $sql="DELETE FROM province WHERE idP='".$_POST['idP']."'"; $query=mysqli_query($conn,$sql); 
$salva="s";
}
}

// ricarica pagina dopo salvataggi
if ($salva=="s") {
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='province.php?idR=".$idR."';\n"; 
    echo "</script>"; 
}
?>

<h4>Regione</h4>
<form name="selReg" action="?" method="post">
Seleziona regione:<br />
<select name="idR" onchange="cambia(this.value);">
<?php
$nome=""; $regioneSelez="";
$sql="SELECT idR,regione FROM regioni ORDER BY regione ASC";
$query=mysqli_query($conn,$sql);
while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    print "<option value='".$q['idR']."'";
    $nome=$myobj->mb_convert_encoding($q['regione']);
    if ($q['idR']==$idR) { print " selected"; $regioneSelez=$nome;}
    print ">".ucwords($nome)."</option>";
}
?>
</select>
</form>
<br /><br />

<h4>Modifica province</h4>

<?php
$sql="SELECT idP,provincia,sigla,capoluogo 
FROM province
WHERE idR='".$idR."' 
ORDER BY provincia ASC";
$query=mysqli_query($conn,$sql);
while($cart=mysqli_fetch_array($query,MYSQLI_ASSOC)){
print "<form id='formCart_".$cart['idP']."' method='post' action='?idR=".$idR."'><p>";
print "<label>id</label><input type='text' name='idP' value='".$cart['idP']."' size='5' /> "; //disabled='yes' 
print "<select options='1' name='rimoz'>";
print "<option value='n' selected>Mantieni</option>";
print "<option value='s' >RIMUOVI</option>";
print "</select> ";
print "<a href='comuni.php?idP=".$cart['idP']."'>Vai ai Comuni</a><br />";
print "<input type='text' name='provincia' value='".ucfirst($cart['provincia'])."' size='40' /> ";  
print "Sigla <input type='text' name='sigla' value='".$cart['sigla']."' size='3' /><br />";  

if ($cart['capoluogo']>0) {
    print "Capoluogo <select name='capoluogo' options='1'>";
    $sql_c="SELECT idC,comune FROM comuni WHERE idP='".$cart['idP']."' ORDER BY comune ASC";
    $query_c=mysqli_query($conn,$sql_c);
    while($elenco=mysqli_fetch_array($query_c,MYSQLI_ASSOC)){
        print "<option value='".$elenco['idC']."' ";
        if ($elenco['idC']==$cart['capoluogo']) { print " selected";}
        print ">".$elenco['comune']."</option>";
    }
    print "</select>";
}else{
    print "<input type='hidden' name='capoluogo' value='0'/>";
}
print "<br /><input type='submit' name='salva' value='SALVA' />";
print "</p></form><br /><br />";
}
?>
<br /><br />
<h4>Aggiungi provincia nella Regione <?php print $regioneSelez; ?></a></h4>
<form id='newCart' method='post' action='?idR=<?php print $idR; ?>'><p>
<label>Comune capoluogo</label> <select name='newCapoluogo' options='1'>
<?php
$sql_c="SELECT idC,comune,sigla FROM comuni,province WHERE comuni.idP=province.idP AND comuni.idR='".$idR."' AND comuni.idC!=capoluogo ORDER BY comune ASC";
$query_c=mysqli_query($conn,$sql_c);
while($elenco=mysqli_fetch_array($query_c,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idC']."'>".$elenco['comune']." (".$elenco['sigla'].") </option>";
}
?>
</select>
<label>Sigla</label> <input type='text' name='newSigla' value='' size='3' /> <br />
<br /><input type='submit' name='salva' value='SALVA' />
</p></form>

