<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_attivita.php"; $mysql=new mysql;

$attivita=$mysql->elenco_attivita($conn,$url,"idAttivita DESC, attivita ASC");
$totAttivita=count($attivita['idAttivita'])-1;

// struttura html
$title="Attivit&agrave;";
$metaDescription="Tutti i negozi e le attivit&agrave; commerciali presenti sul portale.";
$metaKeywords="rimanenze genova, usato genova, siti genova, servizi genova, prodotti genova, delegazioni genova, quartieri genova";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1 class="rosso">Attivit&agrave;</h1>
<p class="testo">Le Attivit&agrave; approdate di recente su <strong>Promogenova</strong> e le ultimissime novit&agrave; da loro inserite sul portale: Articoli, Fotogallery, Marchi, Video, Pagine e Siti internet, Eventi</p>
</div>
<div class="colonna-1-4">
<p><img src="../lay/fantasia-acquisto.jpg" alt="fantasia" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="nero">Hai un'attivit&agrave;?</h4>
<p>Hai un'attivit&agrave;, una professione, un negozio o un'azienda? Scegli Promogenova!<br/><br/>
- Ottimi riscontri<br/>
- Prezzi contenutissimi<br/>
- No bollettini, no call center<br/><br/>
<a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Clicca QUI e scopri le nostre proposte!</a><br /><br />
</p>
</div>
</div>

<?php
// ULTIME 12 ATTIVITA' 'INSERITE
$maxAttivita=12; if ($totAttivita<12) {$maxAttivita=$totAttivita+1;}
if ($maxAttivita>0) {
print "<div class='riga'>";
    print "<div class='colonna-1-4'>";
    print "<a name='vetrine'></a>";
    print "<h2 class='bianco sfTondo sfVerde'>Vetrine web</h2>";
    print "<p>Le ultime 12 inserite</p>";
    print "<a href='".$url."vetrine-web/' rel='index'><img src='".$url."/lay/continua.png' alt='->' /> Elenco completo delle Attivit&agrave;</a>";
    print "</div>";

    print "<div class='colonna-1-4'>";
    for ($i=1;$i<$maxAttivita;$i=$i+3) {
        print "<p style='text-align:center'><a href='".$url.$attivita['cartella'][$i]."'>";
        $logo=$url.$attivita['cartella'][$i]."/th_".$attivita['logo'][$i];
            if ($attivita['logo'][$i]!="" && file_exists($logo)) {
            print "<img src='".$logo."' alt='logo".$attivita['idAttivita'][$i]."' class='scala' /><br /><br />";
            }    
        $txtConv=$mysql->mb_convert_encoding($attivita['attivita'][$i]);
        print $txtConv."</a><br />";
        $txtConv=$mysql->mb_convert_encoding($attivita['ragsoc'][$i]);
        print "<i>".$txtConv."</i><br />";
        print "<span class='verde'>".$attivita['zona'][$i]."</span>";
        print "<br /><br /></p>";
    }
    print "</div>";
    print "<div class='colonna-1-4'>";
    for ($i=2;$i<$maxAttivita;$i=$i+3) {
        print "<p style='text-align:center'><a href='".$url.$attivita['cartella'][$i]."'>";
        $logo=$url.$attivita['cartella'][$i]."/th_".$attivita['logo'][$i];
            if ($attivita['logo'][$i]!="" && file_exists($logo)) {
            print "<img src='".$logo."' alt='logo".$attivita['idAttivita'][$i]."' class='scala' /><br /><br />";
            }    
        $txtConv=$mysql->mb_convert_encoding($attivita['attivita'][$i]);
        print $txtConv."</a><br />";
        $txtConv=$mysql->mb_convert_encoding($attivita['ragsoc'][$i]);
        print "<i>".$txtConv."</i><br />";
        print "<span class='verde'>".$attivita['zona'][$i]."</span>";
        print "<br /><br /></p>";
    }
    print "</div>";
    print "<div class='colonna-1-4'>";
    for ($i=3;$i<$maxAttivita;$i=$i+3) {
        print "<p style='text-align:center'><a href='".$url.$attivita['cartella'][$i]."'>";
        $logo=$url.$attivita['cartella'][$i]."/th_".$attivita['logo'][$i];
            if ($attivita['logo'][$i]!="" && file_exists($logo)) {
            print "<img src='".$logo."' alt='logo".$attivita['idAttivita'][$i]."' class='scala' /><br /><br />";
            }    
        $txtConv=$mysql->mb_convert_encoding($attivita['attivita'][$i]);
        print $txtConv."</a><br />";
        $txtConv=$mysql->mb_convert_encoding($attivita['ragsoc'][$i]);
        print "<i>".$txtConv."</i><br />";
        print "<span class='verde'>".$attivita['zona'][$i]."</span>";
        print "<br /><br /></p>";
    }
    print "</div>";

print "</div>";
}
?>

<div class="riga">
<div class="colonna-1-2">
<a name="articoli"></a>
<h3 class="bianco sfTondo sfViola">Articoli per Categorie commerciali</h3>
<p><br />
<?php
$oggi=date("Ymd");

    $dati=array(
	"idMacro" => array (""),
	"macro" => array (""),
	"riscontri" => array ("")
    );

    $sql_cat="
    SELECT idMacro, macro, descriz 
    FROM macro 
    ORDER BY macro ASC";
    $query_cat=mysqli_query($conn,$sql_cat);			
    while($cat=mysqli_fetch_array($query_cat,MYSQLI_ASSOC)){
        $conta=0;

        $sql_art="
        SELECT idArt,dataOsc 
        FROM articoli_dat,att_scad,macro
        WHERE macro.idMacro=articoli_dat.idMacro
        AND att_scad.idAttivita=articoli_dat.idAttivita 
        AND macro.idMacro='".$cat['idMacro']."' 
        AND osc='n' 
        ORDER BY idArt ASC";
        $query_art=mysqli_query($conn,$sql_art);			
        while($art=mysqli_fetch_array($query_art,MYSQLI_ASSOC)){
        if ($oggi<=$art['dataOsc']){
            $conta++;
        }
        }
            
    if ($conta>0){
    $dati['idMacro'][]=$cat['idMacro'];
    $dati['macro'][]=$cat['macro'];
    $dati['riscontri'][]=$conta;
    }
    }
    
    for($i=1;$i<count($dati['idMacro']);$i++){
    $titolo=$myobj->mb_convert_encoding($dati['macro'][$i]);
    print "<a href='../ricerche/macro.php?idMacro=".$dati['idMacro'][$i]."'><span class='testo verde'>".ucwords($titolo)."</span>:  ".$dati['riscontri'][$i]." articoli </a><br />";
    }
?>
</p>
</div>

<div class="colonna-1-2">
<a name="marchi"></a>
<h3 class="bianco sfTondo sfBlu">Ultimi 15 Marchi inseriti</h3>
<p><br />
<?php
$oggi=date("Ymd");
$conta=0;
    $sql_m="
    SELECT marchio,dataOsc,cartella,attivita
    FROM vetrine_marchi,vetrine,att_scad,attivita 
    WHERE att_scad.idAttivita=vetrine_marchi.idAttivita
    AND att_scad.idAttivita=vetrine.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND osc='n' 
    ORDER BY id DESC";
    $query_m=mysqli_query($conn,$sql_m);			
    while($marchi=mysqli_fetch_array($query_m,MYSQLI_ASSOC)){
        if ($oggi<=$marchi['dataOsc'] && $conta<15){

        $txtConv=$myobj->mb_convert_encoding($marchi['marchio']);
        print "<a href='".$url."ricerche/tutti-i-marchi.php#".strtolower($txtConv)."'><span class='testo'>".$txtConv."</span></a> aggiunto da ";
        $txtConv=$myobj->mb_convert_encoding($marchi['attivita']);
        print "<a href='".$url.$marchi['cartella']."'><span class='arancio'>".$txtConv."</span></a><br />";
    
        $conta++;
        }
    }
?>
</p>
</div>
</div>


<div class="riga">
<div class="colonna-1-3">
<a name="video"></a>
<h3 class="bianco sfTondo sfArancio">Video di Attivit&agrave;</h3>
<p>Ultimi 2 video pubblicati<br /><br /></p>
<p>Desideri pubblicizzare i tuoi video su Promogenova?<br /> <a href="../info-e-prezzi/" rel="index"><img src="../lay/continua.png" alt="->"/> Diventa nostro cliente!</a><br /><br /></p>

</div>
<?php
$oggi=date("Ymd");
$conta=0;
    $sql_m="
    SELECT video,dataOsc,cartella,attivita
    FROM vetrine_video,vetrine,att_scad,attivita 
    WHERE att_scad.idAttivita=vetrine_video.idAttivita
    AND att_scad.idAttivita=vetrine.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND osc='n' 
    ORDER BY id DESC";
    $query_m=mysqli_query($conn,$sql_m);			
    while($elenco=mysqli_fetch_array($query_m,MYSQLI_ASSOC)){
    if ($oggi<=$elenco['dataOsc'] && $conta<3){
        $video['video'][]=$elenco['video'];
        $video['cartella'][]=$elenco['cartella'];
        $txtConv=$myobj->mb_convert_encoding($elenco['attivita']);        
        $video['attivita'][]=$txtConv;
        $conta++;
    }
    }
    print "<div class='colonna-1-3'>";
        if ($conta>0 && $video['video'][0]!=""){
            print "<p style='text-align:center'>";
            print $video['video'][0];
           //$myobj->video($video['video'][0]);        
            print "Pubblicato da: <a href='".$url.$video['cartella'][0]."'><span class='arancio'>".$video['attivita'][0]."</span></a><br />";
            print "<br /><br /></p>";
        }    
    print "</div>";
    print "<div class='colonna-1-3'>";
        if ($conta>1 && $video['video'][1]!=""){
            print "<p style='text-align:center'>";
            print $video['video'][1];
            //$myobj->video($video['video'][1]);        
            print "Pubblicato da: <a href='".$url.$video['cartella'][1]."'><span class='arancio'>".$video['attivita'][1]."</span></a><br />";
            print "<br /><br /></p>";
        }    
    print "</div>";
?>
</div>


<div class="riga">
<div class="colonna-1-4">
<a name="eventi"></a>
<h3 class="bianco sfTondo sfGiallo">Eventi di Attivit&agrave;</h3>
<p>Ultimi 3 eventi lanciati<br /><br /></p>
<p>Desideri pubblicizzare i tuoi eventi su Promogenova?<br /> <a href="../info-e-prezzi/" rel="index"><img src="../lay/continua.png" alt="->"/> Diventa nostro cliente!</a><br /><br /></p>

</div>
<?php
$oggi=date("Ymd");
$conta=0;
    $sql_m="
    SELECT eventi.id,titolo,img,dataOsc,cartella,attivita
    FROM eventi,eventi_promot,vetrine,att_scad,attivita 
    WHERE att_scad.idAttivita=eventi_promot.idAttivita
    AND eventi.id=eventi_promot.id
    AND att_scad.idAttivita=vetrine.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND att_scad.osc='n' 
    ORDER BY eventi.id DESC";
    $query_m=mysqli_query($conn,$sql_m);			
    while($elenco=mysqli_fetch_array($query_m,MYSQLI_ASSOC)){
        if ($oggi<=$elenco['dataOsc'] && $conta<4){
        $eventi['id'][]=$elenco['id'];
        $txtConv=$myobj->mb_convert_encoding($elenco['titolo']);         
        $eventi['titolo'][]=$txtConv;
            $locandina=""; $urlImg=$url."locandine/th_".$elenco['img'];
            if ($elenco['img']!="" && file_exists($urlImg)) { $locandina=$urlImg;}    
        $eventi['img'][]=$locandina;
        $txtConv=$myobj->mb_convert_encoding($elenco['attivita']);         
        $eventi['attivita'][]=$txtConv;
        $eventi['cartella'][]=$elenco['cartella'];
        $conta++;
    }
    }
    print "<div class='colonna-1-4'>";
        if ($conta>0 && $eventi['titolo'][0]!=""){
            print "<p style='text-align:center'>";
            print "<a href='".$url."eventi/index.php?id=".$eventi['id'][0]."'>";
            if ($eventi['img'][0]!="") {
            print "<img src='".$eventi['img'][0]."' alt='locandina_".$eventi['id'][0]."' class='scala' /><br /><br />";
            }    
            print $eventi['titolo'][0]."</a><br /><br />";
            print "Pubblicato da: <a href='".$url.$eventi['cartella'][0]."'><span class='arancio'>".$eventi['attivita'][0]."</span></a><br />";
            print "<br /><br /></p>";
        }    
    print "</div>";

    print "<div class='colonna-1-4'>";
        if ($conta>1 && $eventi['titolo'][1]!=""){
            print "<p style='text-align:center'>";
            print "<a href='".$url."eventi/index.php?id=".$eventi['id'][1]."'>";
            if ($eventi['img'][1]!="") {
            print "<img src='".$eventi['img'][1]."' alt='locandina_".$eventi['id'][1]."' class='scala' /><br /><br />";
            }    
            print $eventi['titolo'][1]."</a><br /><br />";
            print "Pubblicato da: <a href='".$url.$eventi['cartella'][1]."'><span class='arancio'>".$eventi['attivita'][1]."</span></a><br />";
            print "<br /><br /></p>";
        }    
    print "</div>";

    print "<div class='colonna-1-4'>";
        if ($conta>2 && $eventi['titolo'][2]!=""){
            print "<p style='text-align:center'>";
            print "<a href='".$url."eventi/index.php?id=".$eventi['id'][2]."'>";
            if ($eventi['img'][2]!="") {
            print "<img src='".$eventi['img'][2]."' alt='locandina_".$eventi['id'][2]."' class='scala' /><br /><br />";
            }    
            print $eventi['titolo'][2]."</a><br /><br />";
            print "Pubblicato da: <a href='".$url.$eventi['cartella'][2]."'><span class='arancio'>".$eventi['attivita'][2]."</span></a><br />";
            print "<br /><br /></p>";
        }    
    print "</div>";
?>
</div>


<div class="riga">
<div class="colonna-1-4">
<a name="foto"></a>
<h3 class="bianco sfTondo sfCeleste">Foto di Attivit&agrave;</h3>
<p>Ultime 12 immagini aggiunte<br /><br /></p>
<p>Desideri pubblicizzarti con le tue foto su Promogenova?<br /> <a href="../info-e-prezzi/" rel="index"><img src="../lay/continua.png" alt="->"/> Diventa nostro cliente!</a><br /><br /></p>
</div>
<?php
$oggi=date("Ymd");
$conta=0;
    $sql_m="
    SELECT vetrine_foto.id,foto,dataOsc,cartella,attivita
    FROM vetrine_foto,vetrine,att_scad,attivita 
    WHERE att_scad.idAttivita=vetrine.idAttivita
    AND attivita.idAttivita=vetrine_foto.idAttivita
    AND attivita.idAttivita=vetrine.idAttivita
    AND att_scad.osc='n' 
    ORDER BY vetrine_foto.id DESC";
    $query_m=mysqli_query($conn,$sql_m);			
    while($elenco=mysqli_fetch_array($query_m,MYSQLI_ASSOC)){
        if ($oggi<=$elenco['dataOsc'] && $conta<13){
        $foto['id'][]=$elenco['id'];
            $imgFoto=""; $urlImg=$url.$elenco['cartella']."/foto/th_".$elenco['foto'];
            if ($elenco['foto']!="" && file_exists($urlImg)) { $imgFoto=$urlImg;}     
        $foto['foto'][]=$imgFoto;
        $txtConv=$myobj->mb_convert_encoding($elenco['attivita']);         
        $foto['attivita'][]=$txtConv;
        $foto['cartella'][]=$elenco['cartella'];
        $conta++;
    }
    }

    print "<div class='colonna-1-4'>";
    for ($i=0;$i<9;$i=$i+3) {	
            if ($foto['foto'][$i]!="") {
            print "<p style='text-align:center'>";
            print "<a href='".$url.$foto['cartella'][$i]."/foto.php?id=".$foto['id'][$i]."'>";
            print "<img src='".$foto['foto'][$i]."' alt='foto_".$foto['id'][$i]."' class='scala' /><br /><br />";
            print "Pubblicata da: <a href='".$url.$foto['cartella'][$i]."'><span class='arancio'>".$foto['attivita'][$i]."</span></a><br />";
            print "<br /><br /></p>";
            }    
        }    
    print "</div>";
 
    print "<div class='colonna-1-4'>";
    for ($i=1;$i<9;$i=$i+3) {	
            if ($foto['foto'][$i]!="") {
            print "<p style='text-align:center'>";
            print "<a href='".$url.$foto['cartella'][$i]."/foto.php?id=".$foto['id'][$i]."'>";
            print "<img src='".$foto['foto'][$i]."' alt='foto_".$foto['id'][$i]."' class='scala' /><br /><br />";
            print "Pubblicata da: <a href='".$url.$foto['cartella'][$i]."'><span class='arancio'>".$foto['attivita'][$i]."</span></a><br />";
            print "<br /><br /></p>";
            }    
        }    
    print "</div>";

    print "<div class='colonna-1-4'>";
    for ($i=2;$i<9;$i=$i+3) {	
            if ($foto['foto'][$i]!="") {
            print "<p style='text-align:center'>";
            print "<a href='".$url.$foto['cartella'][$i]."/foto.php?id=".$foto['id'][$i]."'>";
            print "<img src='".$foto['foto'][$i]."' alt='foto_".$foto['id'][$i]."' class='scala' /><br /><br />";
            print "Pubblicata da: <a href='".$url.$foto['cartella'][$i]."'><span class='arancio'>".$foto['attivita'][$i]."</span></a><br />";
            print "<br /><br /></p>";
            }    
        }    
    print "</div>";

?>
</div>

  
<?php
include "../config/footer.php";
?>
