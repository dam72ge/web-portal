<?php
$url="../"; 
include "../config/mydb.php";
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_vetrina.php"; $mysql=new mysql; 
require_once "../config/class_db.php"; $db=new db; 

// riconosci vetrina
$vetrina=$mysql->identifica($conn,$_SERVER['PHP_SELF'],2);

// controllo
if ($vetrina['msgID'][0]!=""){
$pagOscurata=$url."modelli/vetrina-oscurata.php?msgID=".$vetrina['msgID'][0];
header("location: $pagOscurata");
}

// id
if (!isset($_GET['id']) | $_GET['id']=="" | $_GET['id']<1) {
$redirUrl=$url.$vetrina['cartella'][0];
header("location: $redirUrl");
}
$id=$_GET['id'];

// struttura html
$attivita=$myobj->mb_convert_encoding($vetrina['attivita'][0]);
$title="Foto #".$id." - Fotogallery ".$attivita;
$metaDescription="Fotogallery della vetrina web di ".ucwords(strtolower($attivita))." - Foto n.ro ".$id;
$metaKeywords="fotogallery, foto, ".strtolower($attivita);
$metaRobots="ALL";


// carica foto
    $where="AND id='".$id."'";
    $foto=$mysql->foto($conn,$url,$vetrina['cartella'][0],$vetrina['idAttivita'][0],$where);


//opengraph
$opengraph="s";
$og_title=$title; 
$og_url="http://www.promogenova.it/".$_SERVER['PHP_SELF']."?id=".$id;
$og_image=$vetrina['cartella'][0]."/foto/".$foto['foto'][0];


include "../config/head.php";
include "../config/header-nav.php";



    print "<div class='riga'>";

    print "<div class='colonna-2-3'>";    
    print "<p class='testo' style='text-align:center'>";
    $didascalia=$myobj->mb_convert_encoding($foto['didasc'][0]);
    print "<b>Foto #".$foto['id'][0]."</b> - ".$didascalia."<br />";
    $urlFotoSel=$url.$vetrina['cartella'][0]."/foto/".$foto['foto'][0];
    print "<a href='".$urlFotoSel."'><img src='".$urlFotoSel."' alt='foto".$foto['id'][0]."' title='Clicca per visualizzare nelle dimensioni originali in una nuova finestra' class='scala' /></a>";
    
    print "</p>";    
    print "</div>";
    
    print "<div class='colonna-1-3'>";
    print "<h3 class='rosso'>Fotogallery</h3>";
    print "<p>";
    $foto=$mysql->foto($conn,$url,$vetrina['cartella'][0],$vetrina['idAttivita'][0],"");
        for ($i=0;$i<count($foto['id']);$i++) {
            print "<a href='".$url.$vetrina['cartella'][0]."/foto.php?id=".$foto['id'][$i]."'>";
            print "<img src='".$url.$vetrina['cartella'][0]."/foto/ico_".$foto['foto'][$i]."' alt='foto".$foto['id'][$i]."' class='thumb' />";
            print "</a> ";
	
        }
    print "<br /><br /></p>";    
    print "<h4><a href='".$url.$vetrina['cartella'][0]."'>Clicca <span class='arancio'>qui</span> per tornare alla vetrina di ".$attivita."</a></h4>";
    print "</div>";

    print "</div>";

$tipoPag="foto";
include "../config/stat_vetrine.php";
include "../config/footer.php";
?>
