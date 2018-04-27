<?php
$url="../"; 

// struttura html
$title="Area clienti";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../config/head.php";
include "../config/header-nav.php";
$msg=$_GET['msg'];
?>

<div class="riga">
<div class="colonna-1" style="text-align:center">
  <br/><br/><br/>
<?php
print "<span style='font-size:28px; color: red; text-align:center'>".$msg."</span>";
?>
<br /><br />
Clicca <a href="../login-clienti.php"><b>QUI</b></a> se desideri riprovare.
  <br/><br/><br/>
  <br/><br/><br/>
  <br/><br/><br/>

</div>
</div>

<?php
include "../config/footer.php";
?>
