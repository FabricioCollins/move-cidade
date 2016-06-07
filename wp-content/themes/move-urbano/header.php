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
$pagename = get_query_var('pagename');  
if ( !$pagename ) {  
    // If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object  
    $post = $wp_query->get_queried_object();  
    $pagename = $post->post_name;  
}

if($pagename) {
	$pagetitle = str_replace("-", " ", $pagename);
	$pagetitle=$pagetitle." | MOVE CIDADE";
}
else 
	$pagetitle="MOVE CIDADE";

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>

	<title><?php echo strtoupper ($pagetitle); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="shortcut icon" href="<?php bloginfo( 'stylesheet_directory' );?>/img/favicon.ico" type="image/x-icon">

	<!-- JS LIBS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>	
	<script src="<?php bloginfo('template_url'); ?>/js/jquery.bxslider.min.js"></script>

	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/idec.cardboard.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/script.js"></script>

	<!-- CSS LIBS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">	
	<link href="<?php bloginfo('template_url'); ?>/css/jquery.bxslider.css" rel="stylesheet" type="text/css">


	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>	
	<?php endif; ?>
	<?php wp_head(); ?>

	<?php
		$actionNav='#';
		if(!is_home()) {
			$actionNav=get_site_url() . '/#';			
		}

		$page_name="";				
		$page_name=get_query_var('pagename');		
	?>

</head>

<body <?php body_class(); ?>>

<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div id="page" class="site">
	<div class="site-inner">
		<!--<a class="skip-link screen-reader-text" href="#content">< ? php _e( 'Skip to content', 'twentysixteen' ); ?></a>-->

		<div class="wrapper">
			<div class="header">

				<div class="title section">
					<div class="logo-idec col span_2_of_12">						
						<img src="<?php bloginfo( 'stylesheet_directory' );?>/img/idec_logo.png">						
					</div>

					<h1 class="col span_8_of_12">
						<?php 
							$logo_name='home';
							if (strpos(get_permalink(), get_permalink(get_page_by_path('Blog')) ) !== false && ($page_name=='blog' || $page_name='') ) {
								$logo_name='blog';
							}
						?>
						<a class="logo-<?php echo $logo_name ?>" href="<?php echo get_permalink(get_page_by_path('Home'));?>">
							<span class="visuallyhidden">Move Cidade</span>
						</a>
					</h1>
				</div>

				<div class="nav-filter">					
					<div class="logo">
						<a href="#"><img src="<?php bloginfo( 'stylesheet_directory' );?>/img/logo_branco.png"></a>
					</div>

					<div class="nav-categories">
						<div class="responsivo-show menu-toggle"><a href="javascript:void(0);">Seções</a></div>
						<ul class="menu">
							<li class="menu-item" data-target="mobilidade_e_cidade">
								<a href="<?php echo $actionNav ?>mobilidade_e_cidade">
									<span class="responsivo-hide">Mobilidade e </span>cidade</a>
								</a>
							</li>
							<li class="menu-item" data-target="mobilidade_e_cotidiano">
								<a href="<?php echo $actionNav ?>mobilidade_e_cotidiano">
									<span class="responsivo-hide">Mobilidade e </span>cotidiano</a>
								</a>
							</li>
							<li class="menu-item" data-target="entenda_seus_direitos">
								<a href="<?php echo $actionNav ?>entenda_seus_direitos">
									<span class="responsivo-hide">Entenda </span>seus direitos</a>
								</a>
							</li>
							<li class="menu-item" data-target="sem_carro_pela_cidade">
								<a href="<?php echo $actionNav ?>sem_carro_pela_cidade">
									Sem carro<span class="responsivo-hide"> pela cidade</span></a>
								</a>
							</li>
							<li class="menu-item" data-target="novidades">
								<a href="<?php echo $actionNav ?>novidades">
									Novidades
								</a>
							</li>
						</ul>
					</div>

					<div class="search">
						<form action="<?php echo get_site_url(); ?>" class="search-form" method="get" role="search">
							<input class="search-input" type="text" name="s" placeholder="Pesquisar" value="">
							<button class="search-submit" type="submit" value="Pesquisar" aria-label="Pesquisar no site">
								<i class="fa fa-search" aria-hidden="true"></i>
							</button>
						</form>
					</div>

					
				</div>

				<div class="cadastro">
					<div class="form-wrapper">
						<p>Receba novidades sobre campanhas de mobilidade</p>
						<?php do_shortcode("[simplenewsletter]"); ?>
					</div>
					<div class="toggle">
						<i class="fa fa-times" aria-hidden="true"></i>
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
					<li class="menu-item <?php if(is_home()) echo 'ativo'; ?>">
						<a href="<?php echo get_permalink(get_page_by_path('Home'));?>">
							<i class="icon fa fa-home" aria-hidden="true"></i><span class="descricao">Página inicial</span>
						</a>
					</li>
					<li class="menu-item <?php if($page_name=='blog') echo 'ativo'; ?>">
						<a href="<?php echo get_permalink(get_page_by_path('Blog'));?>">
							<i class="icon fa fa-newspaper-o" aria-hidden="true"></i><span class="descricao">Arquivos do blog</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="javascript:void(0);">
							<i class="icon fa fa-info-circle" aria-hidden="true"></i><span class="descricao">Sobre</span>
						</a>
					</li>
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