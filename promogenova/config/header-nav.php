<header>
<a class="attiva-nav" href="#"><img src="<?php print $url; ?>img/menu.png"> Men&ugrave; </a>
<div id="logo">
<a rel="index" href="<?php print $url; ?>index.php"><img src="<?php print $url; ?>img/logo.png" alt="PromoGenova.it" title="Homepage" /></a>
</div>

<nav>
<ul>
<li><a rel="index" href="<?php print $url; ?>index.php">Home</a>
                <ul>
                  <li><a rel="index" href="<?php print $url; ?>faq/index.php">Questo portale</a></li>
                  <li><a rel="index" href="<?php print $url; ?>index.php#social">Promogenova sui social network</a></li>
                  <li><a rel="index" href="<?php print $url; ?>faq/contattaci.php">Lasciaci un messaggio</a></li>
                </ul>
</li>
<li><a rel="index" href="<?php print $url; ?>attivita/">Attivit&agrave;</a>
                <ul>
                  <li><a rel="index" href="<?php print $url; ?>attivita/index.php#vetrine">Vetrine web</a></li>
                  <li><a rel="index" href="<?php print $url; ?>attivita/index.php#articoli">Articoli (prodotti e servizi)</a></li>
                  <li><a rel="index" href="<?php print $url; ?>attivita/index.php#marchi">Marchi</a></li>
                  <li><a rel="index" href="<?php print $url; ?>attivita/index.php#foto">Fotogallery</a></li>
                  <li><a rel="index" href="<?php print $url; ?>ricerche/index.php">Ricerche commerciali</a></li>
                </ul>
</li>
<li><a rel="index" href="<?php print $url; ?>territorio/">Territorio</a>
                <ul>
                  <li><a rel="index" href="<?php print $url; ?>territorio/index.php#ge-municipi">Municipi e Quartieri di Genova</a></li>
                  <li><a rel="index" href="<?php print $url; ?>territorio/index.php#ge-comuni">Provincia di Genova</a></li>
                  <li><a rel="index" href="<?php print $url; ?>territorio/index.php#liguria">Regione Liguria</a></li>
                  <li><a rel="index" href="<?php print $url; ?>territorio/index.php#province">Altre province</a></li>
                  <li><a rel="index" href="<?php print $url; ?>territorio/index.php#regioni">Altre regioni</a></li>
                </ul>
</li>
<li><a rel="index" href="<?php print $url; ?>media/">Media</a>
                <ul>
                  <li><a rel="index" href="<?php print $url; ?>rss/index.php">RSS Novit&agrave;</a></li>
                  <li><a rel="index" href="<?php print $url; ?>eventi/index.php">Eventi</a></li>
                  <li><a rel="index" href="<?php print $url; ?>album/index.php">Album</a></li>
                  <li><a rel="index" href="<?php print $url; ?>video/index.php">Video</a></li>
                  <li><a rel="index" href="<?php print $url; ?>locandine/index.php">Locandine</a></li>
                  <li><a rel="index" href="<?php print $url; ?>download/index.php">Area download</a></li>
                </ul>
</li>
<li><a rel="index" href="<?php print $url; ?>reti/">Reti & Progetti</a>
                <ul>
                  <li><a href="<?php print $url; ?>reti/index.php#intro">Obbiettivo: fare rete</a></li>
                  <li><a href="<?php print $url; ?>reti/index.php#settori">Aree tematiche</a></li>
                  <li><a href="<?php print $url; ?>reti/index.php#elenco">Reti, centri e laboratori</a></li>
                  <li><a href="<?php print $url; ?>reti/index.php#collab">Collaborazioni, idee e progetti</a></li>
                </ul>
</li>
<li><a href="<?php print $url; ?>info-e-prezzi/index.php"><span style="color:pink">Info prezzi</span></a>
                <ul>
                  <li><a href="<?php print $url; ?>info-e-prezzi/index.php#vetrine-ordinarie">Vetrine web</a></li>
                  <li><a href="<?php print $url; ?>info-e-prezzi/index.php#vetrine-speciali">OFFERTE SPECIALI</a></li>
                  <li><a href="<?php print $url; ?>info-e-prezzi/index.php#optionals-vetrine">Assistenza clienti e opzione eventi</a></li>
                  <li><a href="<?php print $url; ?>info-e-prezzi/index.php#consulenze">Consulenze informatico-pubblicitarie</a></li>
                  <li><a href="<?php print $url; ?>info-e-prezzi/index.php#pagine">Pagine facebook</a></li>
                  <li><a href="<?php print $url; ?>info-e-prezzi/index.php#siti">Siti internet</a></li>
                  <li><a href="<?php print $url; ?>info-e-prezzi/index.php#pagamenti">Tempi e modalità di pagamento</a></li>
                </ul>
</li>
<li><a href="<?php print $url; ?>login-clienti.php"><span style="color:white">Area clienti</span></a></li>
</ul>

</nav>
</header>
<div id="focus">
<b>Condividi su</b> &nbsp;&nbsp;
<?php
$opwd="http://www.promogenova.it".$_SERVER['SCRIPT_NAME'];
if ($_SERVER['QUERY_STRING'] != '') { 
   $opwd .= '?'.$_SERVER['QUERY_STRING'];
}

// facebook
print " <a href=javascript:finestra('http://www.facebook.com/sharer.php?u=".$opwd."')><img src='".$url."ico/facebook.png' alt='f' title='Condividi su Facebook' /></a> &nbsp;&nbsp;";
// twitter  // home?status=".$title."++".$opwd."
print " <a href=javascript:finestra('http://twitter.com/home?status=".$opwd."++via+@Promogenova')><img src='".$url."ico/twitter.png' alt='t' title='Condividi su Twitter' /></a> &nbsp;&nbsp;";
// google plus 
print " <a href=javascript:finestra('https://plus.google.com/share?url=".$opwd."&+Promogenova')><img src='".$url."ico/googleplus.png' alt='g' title='Condividi su Google Plus' /></a> &nbsp;&nbsp;";
// linkedin // shareArticle?mini=true&amp;amp;url=".$opwd."&amp;amp;title=".$title."
print " <a href=javascript:finestra('http://www.linkedin.com/shareArticle?url=".$opwd."')><img src='".$url."ico/linkedin.png' alt='l' title='Condividi su LinkedIN' /></a> &nbsp;&nbsp;";
 ?>
</div>
