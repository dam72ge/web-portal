<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../media">Media</a> | Crea NUOVA locandina</h3>

<?php
if(isset($_POST['id']) && $_POST['id']==""){ $_POST['id']=0;}
if(isset($_POST['idAlbum']) && $_POST['idAlbum']==""){ $_POST['idAlbum']=0;}
if(isset($_POST['idVideo']) && $_POST['idVideo']==""){ $_POST['idVideo']=0;}


if(isset($_FILES['newImg']['name'])){

	// crea tabelle id
    $sql = 
    "
    INSERT INTO media
    (idMedia,img) 
    VALUES 
    ( 
    default,
    ''
    )
    ";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovo=mysqli_insert_id($conn);

    $sql = 
    "
    INSERT INTO media_link
    (idML,idMedia,id,idAlbum,idVideo) 
    VALUES 
    ( 
    default,
    '".$idNuovo."',
    '".$_POST['id']."',
    '".$_POST['idAlbum']."',
    '".$_POST['idVideo']."'
    )";
    $query=mysqli_query($conn,$sql);


   // carica file immagine
   $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
   $urlCompleto=$url."locandine/".$idNuovo.".".$ext;
   move_uploaded_file($_FILES['newImg']['tmp_name'], $urlCompleto); // rename
   $locandina=$idNuovo.".".$ext;   
   $sql="UPDATE media SET
   img='".mysqli_real_escape_string($conn,stripslashes($locandina))."'
   WHERE idMedia='".$idNuovo."'";
   $query=mysqli_query($conn,$sql);

	  // crea thumb
	  $dirFile=$url."locandine/"; //cartella
	  $myobj->creathumb($dirFile,$locandina,250,250,$dirFile,"th_");
	  $myobj->creathumb($dirFile,$locandina,48,48,$dirFile,"ico_");


    // vai a modifica
    echo "<script language=\"JavaScript\">\n";
    echo "location.href='locandina.php?idMedia=".$idNuovo."';\n"; 
    echo "</script>"; 

}

print "<h4>Crea nuova locandina</h4>";
?>

<form id="nuovoMedia" method="post" enctype="multipart/form-data" action="?"><p>
<label>Locandina</label><br />
<input type="file" name="newImg" value="" /><br /><br />

<?php
print "<label>Evento collegato</label><br/>";
print "<select options='1' name='id'>";
print "<option value='0' selected>NESSUNO</option>";
$sql_d="SELECT id,titolo FROM eventi ORDER BY id DESC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['id']."'";
    print ">".$elenco['id']." - ".substr($elenco['titolo'],0,50)."</option>";
}
print "</select><br /><br/>";

print "<label>Album collegato</label><br/>";
print "<select options='1' name='idAlbum'>";
print "<option value='0' selected>NESSUNO</option>";
$sql_d="SELECT idAlbum,album FROM album ORDER BY idAlbum DESC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idAlbum']."'";
    print ">".$elenco['idAlbum']." - ".substr($elenco['album'],0,50)."</option>";
}
print "</select><br /><br/>";

print "<label>Video collegato</label><br/>";
print "<select options='1' name='idVideo'>";
print "<option value='0' selected>NESSUNO</option>";
$sql_d="SELECT idVideo,video FROM video ORDER BY idVideo DESC";
$query_d=mysqli_query($conn,$sql_d); 
while($elenco=mysqli_fetch_array($query_d,MYSQLI_ASSOC)){
    print "<option value='".$elenco['idVideo']."'";
    print ">".$elenco['idVideo']." - ".substr($elenco['video'],0,50)."</option>";
}
print "</select><br /><br/>";
?>


<input type="submit" name="salva" value="SALVA"  />
</p></form>
<br /><br />


