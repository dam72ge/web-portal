<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";
$msgSalv="";

// NUOVO NUMERO
if (isset($_POST['upd']) && $_POST['upd']=="s") {
    
    // completa codice
    $_POST['newVideo']=str_replace('src="//www','src="http://www',$_POST['newVideo']);
    //$_POST['newVideo']=str_replace("http://youtu.be/","http://www.youtube.com/watch?v=",$_POST['newVideo']);

    if ($_POST['newVideo']==""){
    $msgErr="Devi inserire un video.";
    }

    // SALVATAGGIO
    if ($msgErr==""){

    $sql = 
    "
    INSERT INTO vetrine_video 
    (id,idAttivita,video) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newVideo']))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovoINS=mysqli_insert_id($conn);
      
    $_POST['upd']="n";
    $msgSalv="Il video &egrave; stato aggiunto.";
    }
}

// ELIMINA 
if (isset($_POST['rimoz']) && $_POST['rimoz']=="s") {
   $sql="DELETE FROM vetrine_video WHERE id='".$_POST['id']."'"; 
   $query=mysqli_query($conn,$sql);
   
   $_POST['id']=0;
   $msgSalv="Il video &egrave; stato rimosso.";
}


// MODIFICA 
if (isset($_POST['id']) && $_POST['id']>0) {
    
    // controllo
    if ($_POST['newVideo']==""){
    $msgErr="Devi inserire il video.";
    }

    // completa codice
    $_POST['newVideo']=str_replace('src="//www','src="http://www',$_POST['newVideo']);
    //$_POST['newVideo']=str_replace("http://youtu.be/","http://www.youtube.com/watch?v=",$_POST['newVideo']);

    // SALVATAGGIO
    if ($msgErr==""){

      $sql="UPDATE vetrine_video SET 
	  video='".mysqli_real_escape_string($conn,stripslashes($_POST['newVideo']))."'
	  WHERE id='".$_POST['id']."'";
      $query=mysqli_query($conn,$sql);
      
      $_POST['id']=0;
      $msgSalv="Le modifiche sono state salvate.";
    }
}

// leggi db
    $totVideo=0;
    $video=array(
	"id" => array (""),
	"video" => array ("")
    );

    $sql="SELECT id,video FROM vetrine_video WHERE idAttivita='".$idAttivita."' ORDER BY id DESC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $video['id'][]=$q['id'];
    $video['video'][]=$q['video'];
    $totVideo++;
    }


// struttura html
$title="Admin ".$attivita." - Video";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Video</h4><br />
<?php
if ($totVideo>0) {
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {

    for ($i=1;$i<count($video['id']);$i++) {
        print "<h5>Video: ".$i." di ".$totVideo."</h5>";
        print "<form id='modifVideo_".$video['id'][$i]."' method='post' action='?' class='riquadro'>";
        
       if ($video['video'][$i]!="") {
        print "<p>".$video['video'][$i]."</p>";			
        //print "<p>"; $myobj->video($video['video'][$i]); print "</p>";
        print "<br/><br/>";
        }
        print "<p><label><strong>Url</strong> del video (come da <a href='#esempio'>esempio</a>)</label><br /> ";    
        print "<textarea name='newVideo' rows='3' cols='30' />".$video['video'][$i]."</textarea></p>";

        print "<p><label>Rimuovere questo video?</label><br />";
        print "<select name='rimoz' option='1'>";
        print "<option value='n' selected>No, confermala</option>";
        print "<option value='s'>S&igrave;, rimuovila dal database</option>";
        print "</select></p><br />";

        print "<input type='hidden' name='id' value='".$video['id'][$i]."'/>";
        print "<p><input type='submit' name='salva' value='SALVA' class='bottSubmit' /></p>";
        print "</form><br /><br /><br />";
	}
}
else{
print "<h2 class='verde'>".$msgSalv."</h2>";
print "<a href='../'>Torna al Men&ugrave; principale</a> oppure <a href='?'>Visualizza e modifica di nuovo.</a><br /><br />";	
}
}
?>
<h5 class="verde">Aggiungi un Video</h5>
<form id="nuovaVideo" method="post" action="?">

  <p><label><strong>Codice</strong> del video come da (<a href="#esempio">esempio</a>)<label><br />
  <textarea name="newVideo" rows="3" cols="30" required /></textarea></p>
  
  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<p>Passa alla <a href="foto.php">Fotogallery</a> | Torna all'<a href="../">Inizio</a></p>
<br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Per essere accettati, i <b>Video</b> devono essere attinenti alla tua Attivit&agrave;, <span class="verde">non protetti da <em>copyright</em></span> e rispettosi delle normative (attenzione: video non conformi saranno rimossi all'istante e <span class="rosso">la vetrina verr&agrave; temporaneamente oscurata senza preavviso</span>).
</p>
<p>Campi obbligatori: <strong>Codice</strong>.
<br /><br />
<?php include "../inc/es-video.php"; ?></p>
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
