<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
//require_once "../config/class_attivita.php"; $mysql=new mysql;

// struttura html
$title="Media";
$metaDescription="Link e finestre multimediali del portale, area download, eventi pubblicizzati";
$metaKeywords="eventi, album, foto, immagini, video, area download, files, feed, rss";
$metaRobots="ALL";

include "../config/head.php";
include "../config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h1>Media</h1>
<p class="testo">Link e finestre multimediali del portale, area download, eventi pubblicizzati</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-2">
<p><img src="../img/multimedia.png" alt="multimedia" class="scala" /></p>
</div>
</div>

<div class="riga">
<div class="colonna-1-2">
<a href="<?php print $url; ?>video/" rel="index" ><h2 class="rosso">Video</h2></a>
<p class="testo">I video realizzati e diffusi da <strong>Promogenova</strong> su <i>YouTube</i>.</p>
<p><a href="<?php print $url; ?>video/" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
<a href="<?php print $url; ?>album/" rel="index" ><h2 class="rosso">Album</h2></a>
<p class="testo">Immagini caricate da <strong>Promogenova</strong> sui maggiori <i>social network</i>.</p>
<p><a href="<?php print $url; ?>album/" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
<a href="<?php print $url; ?>download/" rel="index" ><h2 class="rosso">Area download</h2></a>
<p class="testo">Documenti, immagini e materiale vario caricato dal portale e messo a disposizione di tutti i visitatori. Tutti i file presenti sono sicuri e garantiti, il download è libero e gratuito.</p>
<p><a href="<?php print $url; ?>download/" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
</div>
<div class="colonna-1-2">
<a href="<?php print $url; ?>eventi/" rel="index" ><h2 class="rosso">Eventi</h2></a>
<p class="testo">Manifestazioni, festival, inaugurazioni e altre occasioni di ritrovo pubblicizzate <strong>Promogenova</strong>.</p>
<p><a href="<?php print $url; ?>eventi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
<a href="<?php print $url; ?>locandine/" rel="index" ><h2 class="rosso">Locandine</h2></a>
<p class="testo">Sfoglia le locandine pubblicate su <strong>Promogenova</strong>, scoprendo collegamenti a eventi, video e album.</p>
<p><a href="<?php print $url; ?>locandine/" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
<a href="<?php print $url; ?>rss/" rel="index" ><h2 class="rosso">RSS Novità</h2></a>
<p class="testo">Come rimanere sempre aggiornati su tutte le novità pubblicate su <strong>Promogenova</strong>.</p>
<p><a href="<?php print $url; ?>rss/" rel="index" ><img src="../lay/continua.png" alt="->" /> Vai alla pagina</a><br /><br /><br /><br /></p>
</div>
</div>
  
<?php
include "../config/footer.php";
?>
