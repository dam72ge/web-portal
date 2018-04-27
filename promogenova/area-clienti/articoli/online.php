<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";
// pubblica subito l'articolo
$art_osc="n"; $_SESSION['art_osc']="n";
//header("location: salva.php");
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='salva.php';\n"; 
  echo "</script>"; 
?>