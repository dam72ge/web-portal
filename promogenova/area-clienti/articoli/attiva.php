<?php
// idArt
if (!isset($_GET['idArt'])) {
header ("location: index.php");
}
$idArt=$_GET['idArt'];

$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// riconosci cliente
$cfrAtt=$mysql->cliente_articolo($conn,$idArt);
if ($idAttivita!=$cfrAtt) {
header ("location: index.php");
}

// attiva articolo
$sql="UPDATE articoli SET osc='n' WHERE idArt='".$idArt."'"; 
$query=mysqli_query($conn,$sql);
$_SESSION['art_osc']="n";

$redirUrl="articoliModif.php?idArt=".$idArt;
header ("location: $redirUrl");
?>
