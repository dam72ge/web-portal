<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="index.php">Gestione cartelle</a> | Quartieri</h3> 
<br /><br />

<?php
// seleziona prima il Municipio recuperando dati da url
$idM=1; // municipio default: Genova Centro Est
if (isset($_GET['idM'])) {
$idM=$_GET['idM'];
}

$sql_c="SELECT municipio,comune,municipi.idC,municipi.idP,municipi.idR FROM municipi,comuni WHERE municipi.idC=comuni.idC AND municipi.idM='".$idM."'";
$query_c=mysqli_query($conn,$sql_c);
$c=mysqli_fetch_array($query_c,MYSQLI_ASSOC);
$municSelez=$c['municipio'];
$idC=$c['idC'];
$comuneSelez=$c['comune'];
$idP=$c['idP'];
$idR=$c['idR'];

// js onChange
echo "<script type=\"text/javascript\" language=\"JavaScript\">\n";
echo "function cambia(idM){location.href='?idM='+idM;}";
echo "</script>"; 

$tabella="quartieri";
$salva="n";

if (isset($_POST['newQuartiere'])) {
    $q['sel'][]="idQ"; $q['val'][]="";
    $q['sel'][]="quartiere"; $q['val'][]=$_POST['newQuartiere'];
    $q['sel'][]="idM"; $q['val'][]=$idM;
    $q['sel'][]="idC"; $q['val'][]=$idC;
    $q['sel'][]="idP"; $q['val'][]=$idP;
    $q['sel'][]="idR"; $q['val'][]=$idR;
    $q['sel'][]="rioni"; $q['val'][]=$_POST['newRioni'];
    $db->tbl_insert($conn,$tabella,$q);
$salva="s";
}
if (isset($_POST['idQ'])) {
    $q['sel'][]="quartiere"; $q['val'][]=$_POST['quartiere'];
    $q['sel'][]="idM"; $q['val'][]=$_POST['newIdM'];
    $q['sel'][]="idC"; $q['val'][]=$idC;
    $q['sel'][]="idP"; $q['val'][]=$idP;
    $q['sel'][]="idR"; $q['val'][]=$idR;
    $q['sel'][]="rioni"; $q['val'][]=$_POST['rioni'];
    $where="idQ='".$_POST['idQ']."'";
    $db->tbl_update($conn,$tabella,$q,$where);       
$salva="s";
}
if (isset($_POST['rimoz'])) {
if ($_POST['rimoz']=="s") {
   $sql="DELETE FROM quartieri WHERE idQ='".$_POST['idQ']."'"; $query=mysqli_query($conn,$sql); 
$salva="s";
}
}

// ricarica pagina dopo salvataggi
if ($salva=="s") {
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='quartieri.php?idM=".$idM."';\n"; 
    echo "</script>"; 
}

?>
<h4>Comune</h4>
<form name="selMunic" action="?" method="post">
Seleziona Municipi<br />
<select name="idM" onchange="cambia(this.value);">
<?php
$nome=""; $municSelez="";
$sql="SELECT idM,municipio,comune FROM municipi,comuni WHERE municipi.idC=comuni.idC ORDER BY comune ASC, municipio ASC";
$query=mysqli_query($conn,$sql);
while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        print "<option value='".$q['idM']."'";
        $nomeCom=$myobj->mb_convert_encoding($q['comune']);
        $nome=$myobj->mb_convert_encoding($q['municipio']);
        if ($q['idM']==$idM) { print " selected"; $municSelez=$nome;}
        print ">".ucwords($nomeCom)." ".ucwords($nome)."</option>";
}
?>
</select>
</form>
<br /><br />

<h4>Modifica Quartieri</h4>

<?php
$sql="SELECT idQ,quartiere,rioni
FROM quartieri
WHERE idM='".$idM."'  
ORDER BY quartiere ASC";
$query=mysqli_query($conn,$sql);
while($cart=mysqli_fetch_array($query,MYSQLI_ASSOC)){
print "<form id='formCart_".$cart['idQ']."' method='post' action='?idM=".$idM."'><p>";
print "<label>id</label><input type='text' name='idQ' value='".$cart['idQ']."' size='5'  /> ";
print "<select options='1' name='rimoz'>";
print "<option value='n' selected>Mantieni</option>";
print "<option value='s' >RIMUOVI</option>";
print "</select>";
//print "<br />";

print "<input type='text' name='quartiere' value='".ucfirst($cart['quartiere'])."' size='40' /> <br />";   
print "<label>Rioni compresi</label>: ";
print "<textarea name='rioni' rows='1' cols='60'>";
print $cart['rioni'];
print "</textarea><br />";

print "<label>Municipio appartenenza</label>: ";

    print "<select name='newIdM' options='1'>";
    $sql_m="SELECT idM,municipio FROM municipi WHERE idC='".$idC."' ORDER BY municipio ASC";
    $query_m=mysqli_query($conn,$sql_m);
    while($municip=mysqli_fetch_array($query_m,MYSQLI_ASSOC)){
        print "<option value='".$municip['idM']."' "; 
        if ($idM==$municip['idM']) { print "selected"; }
        print ">".$comuneSelez." ".$municip['municipio']."</option>";
    }
    print "</select>";
    print "<br />";

print " <input type='submit' name='salva' value='SALVA' />";
print "</p></form><br /><br />";
}
?>
<br /><br />
<h4>Aggiungi Quartiere al Municipio di <?php print $comuneSelez." ".$municSelez; ?></h4>
<form id='newCart' method='post' action='?idM=<?php print $idM; ?>'><p>
<label>Quartiere</label> <input type='text' name='newQuartiere' value='' size='40' /> <br /><br />
<label>Rioni compresi</label><br />
<textarea name='newRioni' rows='2' cols='60'></textarea><br />
<br /><input type='submit' name='salva' value='SALVA' />
</p></form>

