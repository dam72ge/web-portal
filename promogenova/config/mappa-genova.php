<?php
    $dati=array("idM" => array (""),"municipio" => array (""));
    $sql="SELECT idM,municipio FROM municipi WHERE idC='25' ORDER BY idM ASC";
    $query=mysqli_query($conn,$sql);			
    while($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $dati['idM'][]=$riga['idM'];
    $dati['municipio'][]=$riga['municipio'];
    $dati['municipio'][0].=$riga['municipio'].", ";
    }

?>
    <img src="<?php print $url;?>lay/cartina-genova.gif" usemap="#cartina-genova" alt="cartina-genova" class="scala"/><br/>
	<map name="cartina-genova" id="cartina-genova">
<?php
	   $sql="SELECT idM,municipio,coord FROM municipi WHERE idC='25' ORDER BY idM ASC";
       $query=mysqli_query($conn,$sql);
       while ($dati=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	   $a="";
	   $sql1="SELECT quartiere FROM quartieri WHERE idC='25' && idM='".$dati['idM']."' ORDER BY quartiere ASC";
       $query1=mysqli_query($conn,$sql1);
       while ($row=mysqli_fetch_array($query1,MYSQLI_ASSOC)) {
	   $a.=str_replace("'","",$row['quartiere'])." ";
	   }
	   print "<area shape='poly' alt='".$dati['municipio']."' title='".$a."' href='".$url."territorio/municipi.php?idM=".$dati['idM']."' coords='".$dati['coord']."' />";
	   }
?>
	</map>
