<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div class="wrapper">
		
		<!-- Query to get dymanic content -->
		<?php

		// The Query
		$args = array(
		    'category_name' => 'noticias',
		    'posts_per_page', 3
		);
		$the_query = new WP_Query( $args );

		$args = array(
		    'category_name' => 'fixa',
		    'posts_per_page', 3
		);
		$the_query_fixed = new WP_Query( $args );

		// Merge nos dois arrays

		// The Loop
		if ( $the_query->have_posts() ) {
			echo '<ul>';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				echo '<li>' . get_the_title() . '</li>';
			}
			echo '</ul>';
		} else {
			// no posts found
		}
		/* Restore original Post Data */
		wp_reset_postdata();

		?>
		
		<div class="main">
			<!-- <div class="shuffle"><i class="icon fa fa-random" aria-hidden="true"></i></div> -->
			<div class="index-menu">
				<div class="section">
					<div class="col span_6_of_12 row_span_2_of_2">
						<h2 class="title"><a href="#oquee">O que é mobilidade urbana?</a></h2>
						<p class="descricao">Você já ficou horas preso no trânsito na sua cidade? Saiba um pouco mais sobre mobilidade urbana e como você pode  contribuir para melhorar a mobilidade e o que devemos exigir do governo para melhorar o trânsito de nossas cidades.</p>
					</div>
					<div class="col span_3_of_12">
						<h2 class="title"><a href="#transito">Trânsito e poluição</a></h2>
						<p class="descricao">Os gases emitidos pelos carros, motos e ônibus contribuem para o aquecimento global, para formação de ilhas de calor nas cidades e pioram a qualidade do ar que você respira. Saiba o quanto você contribui para a poluição da cidade e formas de amenizar</p>
					</div>
					<div class="col span_3_of_12">
						<h2 class="title"><a href="#carro">Carro, um problema?</a></h2>
						<p class="descricao">O carro é a solução para o problema de muita gente, mas seu uso exagerado transformou ele no  grande vilão para o trânsito nas grandes cidades. Confira aqui dicas de como substituir o carro por outros meios de transporte.</p>
					</div>
						<div class="col span_3_of_12">
							<h2 class="title"><a href="#planos">Planos de Mobilidade no Brasil</a></h2>
							<p class="descricao">Conheças os planos de mobilidade no país, como ele se tornou o que é hoje e os pontos positivos e negativos de cada um</p>
						</div>
						<div class="col span_3_of_12">
							<h2 class="title"><a href="#paraonte">Para onde vai meu dinheiro?</a></h2>
							<p class="descricao">Cada vez que você pega um ônibus ou metrô a sua tarifa paga o salário dos funcionários, impostos para o governo e contribui com o lucro das empresas de ônibus. Saiba onde seu dinheiro vai parar.</p>
						</div>
				</div>

				<div class="section">
					<div class="col span_4_of_12">
						<h2 class="title"><a href="#vamosde">Vamos de bicicleta?</a></h2>
						<p class="descricao">Conheça as capitais do país que investem em ciclovias e saiba um pouco mais sobre seus projetos</p>
					</div>
					<div class="col span_4_of_12">
						<h2 class="title"><a href="#quantoespaco">Quanto espaço você ocupa?</a></h2>
						<p class="descricao">Confira qual o espaço ocupado por diferentes meios de transporte</p>
					</div>
					<div class="col span_4_of_12">
						<h2 class="title"><a href="#acidentes">Acidentes de trânsito</a></h2>
						<p class="descricao">Quem é o culpado? Como evitar acidentes?</p>
					</div>
				</div>

				<div class="section">
					<div class="col span_3_of_12">
						<h2 class="title"><a href="#colabore">Colabore</a></h2>
						<p class="descricao">Ajude-nos inserindo no mapa dicas para outras pessoas que transitam pela sua regição, problemas viários , falta de informação nos pontos de ônibus...</p>
					</div>
					<div class="col span_3_of_12">
						<h2 class="title"><a href="#garanta">Garanta seus direitos</a></h2>
						<p class="descricao">Você sabia que em algumas cidades os estudante tem desconto na tarifa do ônibus? Conheça esse e outros direitos dos usuários clicando aqui.</p>
					</div>
					<div class="col span_3_of_12">
						<h2 class="title"><a href="#transporte">Transporte para todos</a></h2>
						<p class="descricao">O transporte público é para todo mundo? Conheça as dificuldades enfrentadas por pessoas com mobilidade reduzida, gestantes e idosos</p>
					</div>
					<div class="col span_3_of_12">
						<h2 class="title"><a href="#preciso">Preciso de ajuda!</a></h2>
						<p class="descricao">Confira aqui onde procurar ajuda para garantir seus direitos</p>
					</div>
				</div>

				<div class="section">
					<div class="col span_4_of_12">
						<h2 class="title"><a href="#voceconhece">Você conhece o Plano Nacional de Mobilidade Urbana? </a></h2>
						<p class="descricao">Saiba mais sobre suas diretrizes e como as prefeituras podem implementá-lo</p>
					</div>
					<div class="col span_4_of_12">
						<h2 class="title"><a href="#como">Como funcionam as licitações de ônibus?</a></h2>
						<p class="descricao">Como funciona a concorrência entre as empresas de transporte e quais as contrapartidas elas oferecem</p>
					</div>
					<div class="col span_4_of_12">
						<h2 class="title"><a href="#vocesabe">Você sabe o que é Desenvolvimento Voltado para o Trânsito</a></h2>
						<p class="descricao">Você já ouviu falar em Transit Oriented Development ou Transportation Demand Management, então clique aqui e saiba como esse conceito está mudando a forma de pensar o planejamento das cidades</p>
					</div>
				</div>

			</div>
		</div>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
