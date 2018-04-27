<!DOCTYPE html>
<html>
<head>
<title>
<?php print $title; ?>
</title>
<meta http-equiv="Content-language" content="IT" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="iso-8859-1"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="info@promogenova.it" />
<meta http-equiv="Reply-to" content="info@promogenova.it" />
<meta name="Robots" content="<?php print $metaRobots; ?>" />
<link rel="stylesheet" type="text/css" href="<?php print $url; ?>css/stile-resp.css" media="screen, projection, tv " />
<link rel="stylesheet" type="text/css" href="<?php print $urlAdm; ?>inc/stile-adm.css" media="screen, projection, tv " />

<!-- link rel="image_src" type="image/jpeg" href="<?php print $url; ?>lay/logo.jpg" / -->
<link rel="shortcut icon" type="image/x-icon" href="<?php print $url; ?>favicon.ico" />

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


// mostra-nascondi DIV

 function mostra_nascondi(id){

 if (document.getElementById){

 if(document.getElementById(id).style.display == 'none'){

 document.getElementById(id).style.display = 'block'; }

 else

 {document.getElementById(id).style.display = 'none';}

 }

}
</script>





</head>

<body>
<a name="inizio"></a>
<div class="contenitore">

