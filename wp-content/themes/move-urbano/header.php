<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" media="all" href="http://move.localhost/wp-content/themes/move-urbano/css/main.css" />
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>

		<div class="wrapper">
			<div class="header">
				<div class="title">
					<h1><a href="javascript:void(0);"><img src="<?php bloginfo( 'stylesheet_directory' );?>/img/logo_web_cor.png" alt="Move Cidade"></a></h1>
					<div class="logo-idec">
						<img src="<?php bloginfo( 'stylesheet_directory' );?>/img/idec_logo.png">
					</div>
				</div>
			
				<div class="nav-filter">
					<div class="nav-categories">
						<ul class="menu">
							<li class="menu-item"><a href="#blog">Mobilidade e cidade</a></li>
							<li class="menu-item"><a href="#blog">Mobilidade e cotidiano</a></li>
							<li class="menu-item"><a href="#blog">Entenda seus direitos</a></li>
							<li class="menu-item"><a href="#blog">Sem carro pela cidade</a></li>
							<li class="menu-item"><a href="#blog">Novidades</a></li>
						</ul>
					</div>

					<div class="search">
						<form action="" class="search-form">
							<input class="search-input" type="text" name="pesquisa" placeholder="Pesquisar" value="">
							<button class="search-submit" type="submit" value="Pesquisar" aria-label="Pesquisar no site"><i class="fa fa-search" aria-hidden="true"></i></button>
						</form>
					</div>
					
				</div>

			</div>