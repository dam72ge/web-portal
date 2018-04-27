<?php
print "versione php: ".phpversion()."<br><br>";
include "config/mydb.php";
$sql="SELECT idR, regione FROM regioni ORDER BY idR ASC";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
print $row['idR'].") ".$row['regione']."<br>";
}
?>
