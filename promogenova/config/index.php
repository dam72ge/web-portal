<?php
$url="../"; 
include "mydb.php";
session_start();

// struttura html
$title="Admin";
$metaDescription="";
$metaKeywords="";
$metaRobots="NO";

include "head.php";
include "header-nav.php";
?>

<div class="riga">
<div class="colonna-1" style="text-align:center">
<br/><br/><br/>

<?php
if (isset($_SESSION['admin']) ){
print "Sei gi&agrave; <i>loggato</i> nell'<b>Admin</b>.
<br /><br />Puoi <a href='adm/index.php'>continuare nella gestione del portale</a>  oppure puoi <a href='adm/logout.php'>cliccare QUI per chiudere</a> il Pannello di amministrazione.";
	} else {
?>


  <form id="logVetr" method="post" action="<?php print $url; ?>config/adm/login-controllo.php">
  <p>
  <label>LOGIN<label><br/>
  <input type="password" size="25" name="admin" value="" class="riqInput" style="width:200px" autofocus /><br/>
  </p>
  <br/>
  <input type="submit" name="trova" value=" ENTRA " class="bottSubmit" style="width:200px" />
  <form>

<?php
}
?>

  <br/><br/><br/>
  <br/><br/><br/>
  <br/><br/><br/>

</div>
</div>

<?php
include "footer.php";
?>
