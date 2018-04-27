<!DOCTYPE html>
<html>
<head>
<title>
<?php
if ($title=="Homepage"){ print "Promogenova.it - Vetrine web, Eventi, Comunicazione"; } else{ print $title." @ Promogenova.it"; }
?>
</title>
<meta http-equiv="Content-language" content="IT" />
<meta http-equiv="Content-Type" content="text/html; utf-8" />
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="Distribution" content="Global" />
<meta name="author" content="Promogenova" />
<meta http-equiv="Reply-to" content="postmaster@promogenova.it" />
<meta name="google-site-verification" content="zPOJTx-LIkNyAAcoGpD_ijzGrM4-eblFNRWA8TLsN4M" />

<?php
// formatta metatag description (max 150 caratteri)
if($metaDescription!=""){
       $metaDescription=str_replace("'", " ", $metaDescription);
       $virg=chr(34);
       $metaDescription=str_replace($virg, " ", $metaDescription);
       $txtdes=substr($metaDescription,0,150);
	   if (strlen($metaDescription)>150){ $metaDescription=$txtdes; }
}

// formatta metatag keywords
if($metaKeywords!=""){
       $metaKeywords=str_replace("'", " ", $metaKeywords);
       $virg=chr(34);
       $metaKeywords=str_replace($virg, " ", $metaKeywords);
       $metaKeywords=str_replace("!", " ", $metaKeywords);
       $metaKeywords=str_replace("?", " ", $metaKeywords);
       $metaKeywords=str_replace(".", " ", $metaKeywords);
       $metaKeywords=str_replace(";", " ", $metaKeywords);
       $metaKeywords=str_replace("-", " ", $metaKeywords);
       $metaKeywords=str_replace("(", " ", $metaKeywords);
       $metaKeywords=str_replace(")", " ", $metaKeywords);
       $metaKeywords=str_replace(":", " ", $metaKeywords);
       $metaKeywords=str_replace("«", " ", $metaKeywords);
       $metaKeywords=str_replace("»", " ", $metaKeywords);
// conta parole (max 10)
    $arrParole=explode(",",$metaKeywords);
    $contParole=count($arrParole);
	if ($contParole>10){
	$metaKeywords="";
	for($i=0;$i<9;$i++){ 
	$metaKeywords.=$arrParole[$i].", ";
	}
	$metaKeywords.=$arrParole[9];
	}
	
}
?>

<meta name="Description" content="<?php print $metaDescription; ?>" />
<meta name="Keywords" content="<?php print $metaKeywords; ?>" />
<meta name="Robots" content="<?php print $metaRobots; ?>" />

<?php
// open graph (facebook)
if (isset($opengraph)){
print "<meta property='og:locale' content='it_IT' />";
print "<meta property='og:site_name' content='Promogenova.it' />";
$og_title=str_replace("'"," ",$og_title);
print "<meta property='og:title' content='".$og_title;
if ($og_title!="Promogenova.it"){ print " @ Promogenova.it";}
print "' />";
print "<meta property='og:type' content='object' />";
$og_url=str_replace("/promogenova.it/","",$og_url);
print "<meta property='og:url' content='".$og_url."' />";
$og_image="http://www.promogenova.it/".$og_image;
$og_image=str_replace("/promogenova.it/","",$og_image);
print "<meta property='og:image' content='".$og_image."' />";
}

// meta twitter)
if (isset($twitter)){
print "<meta name='twitter:card' content='summary' />";
print "<meta name='twitter:domain' content='Promogenova.it' />";
print "<meta name='twitter:site' content='@Promogenova' />";
print "<meta name='twitter:creator' content='@Promogenova' />";
$twitter_title=str_replace("'"," ",$twitter_title);
print "<meta name='twitter:title' content='".$twitter_title;
if ($twitter_title!="Promogenova.it"){ print " @ Promogenova.it";}
print "' />";
$twitter_url=str_replace("/promogenova.it/","",$twitter_url);
print "<meta name='twitter:url' content='".$twitter_url."' />";
print "<meta name='twitter:description' content='Vai su Promogenova.it' />";
$twitter_image="http://www.promogenova.it/".$twitter_image;
$twitter_image=str_replace("/promogenova.it/","",$twitter_image);
print "<meta name='twitter:image:src' content='".$twitter_image."' />";
}
?>

<link rel="alternate" type="application/rss+xml" href="<?php print $url; ?>rss/feed-vetrine.php" />
<link rel="alternate" type="application/rss+xml" href="<?php print $url; ?>rss/feed-articoli.php" />
<link rel="alternate" type="application/rss+xml" href="<?php print $url; ?>rss/feed-marchi.php" />
<link rel="alternate" type="application/rss+xml" href="<?php print $url; ?>rss/feed-eventi.php" />
<link rel="alternate" type="application/rss+xml" href="<?php print $url; ?>rss/feed-video.php" />
<link rel="alternate" type="application/rss+xml" href="<?php print $url; ?>rss/feed-album.php" />
<link rel="alternate" type="application/rss+xml" href="<?php print $url; ?>rss/feed-reti.php" />
<link rel="alternate" type="application/rss+xml" href="<?php print $url; ?>rss/feed-download.php" />

<link rel="stylesheet" type="text/css" href="<?php print $url; ?>css/stile-resp.css" media="screen, projection, tv " />

<!-- link rel="image_src" type="image/jpeg" href="<?php print $url; ?>lay/logo.jpg" / -->
<link rel="shortcut icon" type="image/x-icon" href="<?php print $url; ?>favicon.ico" />

<!-- codice validazione volunia: e637e67e4765440194024b4583df45a8 -->
<!-- codice pinterest -->
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>

<!-- codice layout liquido html5 -->
<script src="<?php print $url; ?>script/ios-orientationchange-fix.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="script/selectivizr-min.js"></script>
<script src="script/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
jQuery(document).ready(function($){
	$("a.attiva-nav").click(function() {
		$("nav").slideToggle();
		$(this).toggleClass("active");
	});
	
	$(window).resize(function() {
	var windowsize = $(window).width();
  if (windowsize > 767) {
  $('nav').css('display', '');
  }
});

});
</script>

<!-- addthis: contatti e canali in homepage
<?php
//if ($title=="Homepage"){ 
?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-522b9c1136547e5d"></script>
<?php 
//} 
?>
-->

</head>

<body>
<a name="inizio"></a>
<div class="contenitore">

