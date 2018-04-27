<?php
$url="../";
include "../config/mydb.php";

require_once "../config/class_layout.php"; $myobj=new pagina;

// carica struttura html
$title="Cerca nel territorio";
$metaDescription="Eventi, attivit&agrave; e ricerche sul territorio";
$metaKeywords="genova, provincia di genova, liguria, piemonte, italia";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1 class="rosso">Cerca nel territorio</h1>
<p class="testo">Ricerca per Regioni, Province, Comuni, Municipi e Quartieri.</p>
</div>
<div class="colonna-1-4">

<p><img src="../img/territorio-cerca.jpg" alt="territorio" class="scala" /></p>
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



<div class="riga">
<div class="colonna-2-3">
<a name="ge-municipi"></a>
<h2 class="bianco sfTondo sfVerde">Genova Comune</h2>
<p><br />
<img src="../img/stemma-comune-genova.jpg" alt="ge-comune" class="scala" /><br /><br />
<?php
     $conta=0;
     $sql_p="SELECT idM,municipio FROM municipi WHERE idC='25'ORDER BY idM ASC";
     $query_p=mysqli_query($conn,$sql_p);
     while ($tit=mysqli_fetch_array($query_p,MYSQLI_ASSOC)){
     $conta++;
	 print "<p><h4><a href='municipi.php?idM=".$tit['idM']."'><span class='verde'>Municipio ".$tit['idM']." Genova ".$tit['municipio']."</span></a></h4>";
		      $sql_q="SELECT idQ,quartiere,rioni FROM quartieri WHERE idC='25' AND idM='".$tit['idM']."'ORDER BY quartiere ASC";
              $query_q=mysqli_query($conn,$sql_q);
              while ($q=mysqli_fetch_array($query_q,MYSQLI_ASSOC)){
              $rioni=$myobj->mb_convert_encoding($q['rioni']);
              print "<a href='quartieri.php?idQ=".$q['idQ']."'>".$q['quartiere']."</a> ".$q['quartiere']." ".$rioni."<br />";
              }
              print "<br /></p>";
    }
?>
<br /><br />
</p>
</div>

<div class="colonna-1-3">
<a name="ge-comuni"></a>
<h2 class="bianco sfTondo sfRosso">Genova Provincia</h2>
<p class="testo"><br /><br />
<img src="../img/stemma-provincia-genova.jpg" alt="ge-provincia" class="scala" /><br /><br /><br />
<?php
     $conta=0;
     $sql_p="SELECT idC,comune FROM comuni WHERE idP='1' ORDER BY comune ASC";
     $query_p=mysqli_query($conn,$sql_p);
     while ($tit=mysqli_fetch_array($query_p,MYSQLI_ASSOC)){
     $conta++;
     $comune=$myobj->mb_convert_encoding($tit['comune']);
	 print "<a href='comuni.php?idC=".$tit['idC']."' class='rosso'>".$comune."</a> ";
    }
?>
<br /><br /><br /><br /><br />
</p>

<a name="liguria"></a>
<h2 class="bianco sfTondo sfBlu">Regione Liguria</h2>
<p>
<img src="../img/stemma-regione-liguria.jpg" alt="liguria" class="scala" /><br /><br />
<?php
     $conta=0;
     $sql_p="SELECT idP,provincia,sigla FROM province WHERE idR='1' ORDER BY provincia ASC";
     $query_p=mysqli_query($conn,$sql_p);
     while ($tit=mysqli_fetch_array($query_p,MYSQLI_ASSOC)){
     $conta++;
     $provincia=$myobj->mb_convert_encoding($tit['provincia']);
	 print "<h3><a href='province.php?idP=".$tit['idP']."'>".ucwords($provincia)."</a> (Prov. <span class='verde'>".$tit['sigla']."</span>)<br /></h3>"; 
    }
?>
<br /><br /><br /><br />
</p>
</div>
</div>


<div class="riga">
<div class="colonna-2-3">
<a name="province"></a>
<h2 class="bianco sfTondo sfViola">Altre Province</h2>
<p><br />
<?php
$sql_r="SELECT idR,regione FROM regioni WHERE idR!='1' ORDER BY regione ASC";
$query_r=mysqli_query($conn,$sql_r);
while ($regione=mysqli_fetch_array($query_r,MYSQLI_ASSOC)){
$nome=$myobj->mb_convert_encoding($regione['regione']);
print "<h4><a href='regioni.php?idR=".$regione['idR']."' class='viola'>".ucwords($nome)."</a></h4>"; 

     $sql_p="SELECT province.idP,provincia
     FROM province WHERE province.idR='".$regione['idR']."' 
     ORDER BY provincia ASC";
     $query_p=mysqli_query($conn,$sql_p);
     while ($tit=mysqli_fetch_array($query_p,MYSQLI_ASSOC)){
     $provincia=$myobj->mb_convert_encoding($tit['provincia']);
	 print "<a href='province.php?idP=".$tit['idP']."'>".ucwords($provincia)."</a> "; 
     }
print "<br /><br />";
}
?>
<br /><br />
</p>
</div>

<div class="colonna-1-3">
<a name="regioni"></a>
<h2 class="bianco sfTondo sfNero">Regioni</h2>
<p class="testo"><br />
<?php
     $conta=0;
     $sql_p="SELECT idR,regione FROM regioni ORDER BY regione ASC";
     $query_p=mysqli_query($conn,$sql_p);
     while ($tit=mysqli_fetch_array($query_p,MYSQLI_ASSOC)){
     $conta++;
     $regione=$myobj->mb_convert_encoding($tit['regione']);
	 print "<h3><a href='regioni.php?idR=".$tit['idR']."' class='nero'>".$regione."</a></h3>";
    }
?>
<br /><br />
<img src="../img/puzzle-italia.jpg" alt="puzzle-italia" class="scala" />
<br /><br /><br />
</p>
</div>
</div>

<?php
include "../config/footer.php";
?>
