<header>
<a class="attiva-nav" href="#"><img src="<?php print $url; ?>img/menu.png"> Men&ugrave; </a>
<div id="logo">
<img src="<?php print $url; ?>img/logo.png" alt="PromoGenova.it" title="Homepage" />
</div>
<nav>
<ul>


<li><a href="<?php print $urlAdm; ?>">Inizio</a></li>
</li>
<li><a href="<?php print $urlAdm; ?>articoli/index.php">Articoli</a></li>
<?php
if ($creaEventi=="s") {
?>
<li><a href="<?php print $urlAdm; ?>eventi/index.php">Eventi</a></li>
<?php
}
?>

<!--
<li><a href="<?php print $urlAdm; ?>index.php#dati">I tuoi dati</a>
                <ul>
                  <li><a href="<?php print $urlAdm; ?>utente/password.php">Modifica password</a></li>
                  <li><a href="<?php print $urlAdm; ?>utente/pivacodfisc.php">Partita IVA e Codice fiscale</a></li>
                  <li><a href="<?php print $urlAdm; ?>utente/dati-riservati.php">Dati riservati (uso interno)</a></li>
                  <li><a href="<?php print $urlAdm; ?>utente/telef.php">Contatti telefonici</a></li>
                  <li><a href="<?php print $urlAdm; ?>utente/email.php">E-mail</a></li>
                  <li><a href="<?php print $urlAdm; ?>utente/social.php">Facebook e altri social</a></li>
                  <li><a href="<?php print $urlAdm; ?>utente/siti.php">Pagine e Siti internet</a></li>
                </ul>
</li>
<li><a href="<?php print $urlAdm; ?>index.php#vetrina">Vetrina</a>
                <ul>
                  <li><a href="<?php print $urlAdm; ?>vetrina/logo.php">Logo</a></li>
                  <li><a href="<?php print $urlAdm; ?>vetrina/chisiamo.php">Chi siamo</a></li>
                  <li><a href="<?php print $urlAdm; ?>vetrina/orari.php">Orari</a></li>
                  <li><a href="<?php print $urlAdm; ?>vetrina/parole.php">Parole chiave</a></li>
                  <li><a href="<?php print $urlAdm; ?>vetrina/marchi.php">Marchi</a></li>
                  <li><a href="<?php print $urlAdm; ?>vetrina/foto.php">Foto</a></li>
                  <li><a href="<?php print $urlAdm; ?>vetrina/video.php">Video</a></li>
                </ul>
</li>
<li><a href="<?php print $urlAdm; ?>articoli/index.php">Articoli</a></li>
<?php
if ($creaEventi=="s") {
?>
<li><a href="<?php print $urlAdm; ?>eventi/index.php">Eventi</a></li>
<?php
}
?>
<li><a href="<?php print $urlAdm; ?>index.php#info">Info & Aiuto</a>
                <ul>
                  <li><a href="<?php print $urlAdm; ?>cliente/assistenza.php">Richiedi assistenza</a></li>
                  <li><a href="<?php print $urlAdm; ?>cliente/statistiche.php">Statistiche</a></li>
                  <li><a href="<?php print $urlAdm; ?>cliente/index.php">Condizioni contratto</a></li>
                  <li><a href="<?php print $urlAdm; ?>cliente/bonifici.php">Pagamenti on line</a></li>
                  <li><a href="<?php print $urlAdm; ?>cliente/upgrade.php">Potenzia la tua vetrina</a></li>
                </ul>
</li>
-->
<li><a href='
<?php
if (isset($_SESSION['admin']) ){print $url."config/"; } else { print $urlAdm."index.php#uscita"; }
?>
'>USCITA</a></li>
</ul>

</nav>
</header>	
<!--
<div id="focus" style="text-align: right">
Admin cliente <b><?php print $attivita; ?></b> &nbsp;&nbsp;
</div>
-->
