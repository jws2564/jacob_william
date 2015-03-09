<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?=get_stylesheet_directory_uri()?>/style/stylesheets/main.css">
<?php wp_head(); ?>
<title><?=ucwords(strtolower(wp_title("", false, ""))); ?> | <?= get_bloginfo( 'description' ) ?></title>
<meta name="viewport" content="initial-scale=1">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60493964-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
<div class="main-wrapper one-col">
	<div class="left">
		<header class="main">
			<a class="logo" href="/"></a>
			<nav><?php wp_nav_menu( array( 'theme_location' => 'main-nav' ) );?></nav>
		</header>