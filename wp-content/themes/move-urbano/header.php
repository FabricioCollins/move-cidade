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
	$pagetitle=$pagetitle." | MoveCidade";
}
else 
	$pagetitle="MoveCidade";

?>

<!DOCTYPE html>

<html <?php language_attributes(); ?> class="no-js">
<head>

	<title><?php echo ucfirst($pagetitle); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no" /> 
	<meta HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="shortcut icon" href="<?php bloginfo( 'stylesheet_directory' );?>/img/favicon.ico" type="image/x-icon">

	<!-- JS LIBS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>	
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery.bxslider.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>

	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/idec.cardboard.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/LinePositionGraph.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/CriteriaPositionGraph.js"></script>	
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/Cookies.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/script.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/dock.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/contents.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/c19.js"></script>

	<!-- CSS LIBS -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">	
	<link href="<?php bloginfo('template_url'); ?>/css/jquery.bxslider.css" rel="stylesheet" type="text/css">	
	<link href="<?php bloginfo('template_url'); ?>/css/dock.css" rel="stylesheet" type="text/css">	

	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.7/select2-bootstrap.min.css">


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

		$logo_name='home';
		if (strpos(get_permalink(), get_permalink(get_page_by_path('Blog')) ) !== false || ($page_name=='blog' || $page_name='') && !is_home() ) {
			$logo_name='blog';
		}	
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

					<h1 class="col span_8_of_12 <?php echo $logo_name ?>">					
						<a class="index-link" href="http://movecidade.org.br">
						<span class="visuallyhidden">Move Cidade</span></a>
						<?php
							if($logo_name=="blog") {							
						?>
						<span class="blog-link-wrapper"><a class="blog-link" href="http://movecidade.org.br/blog">Blog</a></span>
						<?php

							}
						?>
					</h1>
				</div>

				<!-- Include dashboard if page is home -->
				<?php
					if(is_home()) {												
						include_once ('idec-dashboard.php');						
					}
				?>

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
							<li class="menu-item" data-target="os_modais_de_transporte">
								<a href="<?php echo $actionNav ?>os_modais_de_transporte">
									<span class="responsivo-hide">Os modais de </span>transporte</a>
								</a>
							</li>
							<li class="menu-item" data-target="entenda_seus_direitos">
								<a href="<?php echo $actionNav ?>entenda_seus_direitos">
									<span class="responsivo-hide">Entenda seus</span>direitos</a>
								</a>
							</li>
							<li class="menu-item" data-target="faca_sua_parte">
								<a href="<?php echo $actionNav ?>faca_sua_parte">
									<span class="responsivo-hide">Faça </span>sua parte</a>
								</a>
							</li>
							<li class="menu-item" data-target="novidades">
								<a href="<?php echo $actionNav ?>novidades">
									<span class="responsivo-hide">Novidades</a>
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

				<div class="cadastro mailing">
					<div class="form-wrapper">
						<p class="info">Receba novidades sobre campanhas de mobilidade</p>
						<form id="idec-mailing-form" method="POST" action="https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8">
							<!-- Form Fields -->
							<input id="first_name" class="name" maxlength="40" name="first_name" size="20" type="text" placeholder="Nome" required="required" />
							<input id="last_name" class="name" maxlength="80" name="last_name" size="20" type="text" placeholder="Sobrenome" required="required" />
							<input id="email" maxlength="80" name="email" size="20" type="text" placeholder="Email" required="required" />
							<!-- Request Fields -->
							<input type=hidden name="oid" value="00D37000000KRmT"> <!-- ID Idec -->
					   		<input type=hidden id="Campaign_ID" name="Campaign_ID" value="701370000001hB8"> <!-- ID Campanha -->
							<input type=hidden name="retURL" value="http://movecidade.org.br"> <!-- Página de sucesso -->
					   		<input type=hidden id="lead_source" name="lead_source" value="Web"> <!-- Origem do lead -->
					   		<input type=hidden id="00N37000005jnRO" name="00N37000005jnRO" value="MKT-Movecidade"> <!-- Descrição da Origem do Lead -->
					   		<input type=hidden id="country_code" name="country_code" value="BR"> <!-- País: Brasil -->
					   		<input type=hidden id="00N370000059b0X" name="00N370000059b0X" value="Simples"> <!-- Tipo do Form -->				   		
							<input class="send" type="submit" value="Cadastrar">
						</form>
						<p class="erro">Houve um problema ao cadastrar seu email. Tente novamente.</p>
					</div>
					<div class="toggle ativo">
						<i class="fa" aria-hidden="true"></i>
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
						<a href="<?php echo get_site_url();?>">
							<i class="icon fa fa-home" aria-hidden="true"></i><span class="descricao">Página inicial</span>
						</a>
					</li>
					<li class="menu-item <?php if($page_name=='blog') echo 'ativo'; ?>">
						<a href="<?php echo get_permalink(get_page_by_path('Blog'));?>">
							<i class="icon fa fa-newspaper-o" aria-hidden="true"></i><span class="descricao">Arquivos do blog</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="http://movecidade.org.br/conteudo/quem-somos/">
							<i class="icon fa fa-info-circle" aria-hidden="true"></i><span class="descricao">Sobre</span>
						</a>
					</li>
				</ul>

				<ul class="menu menu-social">
					<li class="menu-item">
						<a href="https://pt-br.facebook.com/idecbr/" target="_blank">
						<i class="icon fa fa-facebook" aria-hidden="true"></i>
						<span class="descricao">Facebook</span></a>
					</li>
					<li class="menu-item">
						<a href="https://twitter.com/idec" target="_blank">
						<i class="icon fa fa-twitter" aria-hidden="true"></i>
						<span class="descricao">Twitter</span></a>
					</li>
					<li class="menu-item">
						<a href="https://www.youtube.com/user/defesadoconsumidor" target="_blank">
						<i class="icon fa fa-youtube" aria-hidden="true"></i>
						<span class="descricao">Youtube</span></a>
					</li>
				</ul>
			</div>

		</div>
	</div>
</div>