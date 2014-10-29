<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?=get_stylesheet_directory_uri()?>/style/stylesheets/main.css">
<?php wp_head(); ?>
<title><?=ucwords(strtolower(wp_title("", false, ""))); ?> | <?= get_bloginfo( 'description' ) ?></title>
<meta name="viewport" content="initial-scale=1">
</head>
<body>
<div class="main-wrapper">
		<header class="main zig">
			<a class="logo" href="/"></a>
			<nav><?php wp_nav_menu( array( 'theme_location' => 'main-nav' ) );?></nav>
		</header>