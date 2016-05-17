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
	<title>MOVE CIDADE</title>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<!-- JS LIBS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>	
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/idec.cardboard.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<!-- CSS LIBS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	<script src="<?php bloginfo('template_url'); ?>/js/jquery.bxslider.min.js"></script>
	<link href="<?php bloginfo('template_url'); ?>/css/jquery.bxslider.css" rel="stylesheet" type="text/css">

	<script>
		$( document ).ready(function() {

			// Controle as expansão do menu lateral
			$('.nav-toggle a').click(function(event) {
				$('.nav-main').toggleClass('open');
			});

			// Controla o componente de cadastro de email
			$('.cadastro .toggle').click(function(event) {
				$('.cadastro .form-wrapper').animate({
					// opacity: "toggle",
					height: "toggle",
					width: "toggle",
				}, 300);
				$(this).toggleClass('ativo').find('i').toggleClass('fa-times').toggleClass('fa-bus');
			});

			// Make search on key press after 0.5 second
			var searchEventContainer=null;
			$(".search-input").keyup(function(){
				if(searchEventContainer!=null) clearTimeout(searchEventContainer);

				searchEventContainer=setTimeout(function() {
					$(".cardboard").idecCardBoard().filterByContent($(".search-input").val());
				}, 500);
			});

		});	
	</script>

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>	
	<?php endif; ?>
	<?php wp_head(); ?>

	<?php
		$actionNav='#';
		if(!is_home()) {
			$actionNav=get_site_url() . '/#';			
		}
	?>

</head>

<body <?php body_class(); ?>>

<div id="page" class="site">
	<div class="site-inner">
		<!--<a class="skip-link screen-reader-text" href="#content">< ? php _e( 'Skip to content', 'twentysixteen' ); ?></a>-->

		<div class="wrapper">
			<div class="header">
				<div class="title">
					<h1><a href="<?php echo get_permalink(get_page_by_path('Blog'));?>"><img src="<?php bloginfo( 'stylesheet_directory' );?>/img/logo_web_cor.png" alt="Move Cidade"></a></h1>
					<div class="logo-idec">
						<a href="<?php echo get_permalink(get_page_by_path('Blog'));?>"><img src="<?php bloginfo( 'stylesheet_directory' );?>/img/idec_logo.png"></a>
					</div>
				</div>
			
				<div class="nav-filter">
					<div class="nav-categories">
						<ul class="menu">
							<li class="menu-item" data-target="mobilidade_e_cidade"><a href="<?php echo $actionNav ?>mobilidade_e_cidade">Mobilidade e cidade</a></li>
							<li class="menu-item" data-target="mobilidade_e_cotidiano"><a href="<?php echo $actionNav ?>mobilidade_e_cotidiano">Mobilidade e cotidiano</a></li>
							<li class="menu-item" data-target="entenda_seus_direitos"><a href="<?php echo $actionNav ?>entenda_seus_direitos">Entenda seus direitos</a></li>
							<li class="menu-item" data-target="sem_carro_pela_cidade"><a href="<?php echo $actionNav ?>sem_carro_pela_cidade">Sem carro pela cidade</a></li>
							<li class="menu-item" data-target="novidades"><a href="<?php echo $actionNav ?>novidades">Novidades</a></li>
						</ul>
					</div>

					<div class="search">
						<form action="<?php echo get_site_url(); ?>" class="search-form" method="get" role="search">
							<input class="search-input" type="search" name="s" placeholder="Pesquisar" value="">
							<button class="search-submit" type="submit" value="Pesquisar" aria-label="Pesquisar no site"><i class="fa fa-search" aria-hidden="true"></i></button>
						</form>
					</div>
					
				</div>

			</div>


			<div class="nav-main">
				<div class="menu nav-toggle">
					<div class="menu-item">
						<a href="javascript:void(0);">
							<i class="icon fa fa-arrow-right" aria-hidden="true"></i>
						</a>
					</div>
				</div>
				<ul class="menu menu-nav">
					<li class="menu-item"><a href="<?php echo get_permalink(get_page_by_path('Home'));?>"><i class="icon fa fa-home" aria-hidden="true"></i><span class="descricao">Página incial</span></a></li>
					<li class="menu-item"><a href="<?php echo get_permalink(get_page_by_path('Blog'));?>"><i class="icon fa fa-newspaper-o" aria-hidden="true"></i><span class="descricao">Arquivo do blog</span></a></li>
					<li class="menu-item"><a href="javascript:void(0);"><i class="icon fa fa-info-circle" aria-hidden="true"></i><span class="descricao">Sobre</span></a></li>
				</ul>
				<ul class="menu menu-social">
					<li class="menu-item"><a href="javascript:void(0);"><i class="icon fa fa-facebook" aria-hidden="true"></i><span class="descricao">Facebook</span></a></li>
					<li class="menu-item"><a href="javascript:void(0);"><i class="icon fa fa-twitter" aria-hidden="true"></i><span class="descricao">Twitter</span></a></li>
					<li class="menu-item"><a href="javascript:void(0);"><i class="icon fa fa-youtube" aria-hidden="true"></i><span class="descricao">Youtube</span></a></li>
				</ul>
			</div>

		</div>
	</div>
</div>