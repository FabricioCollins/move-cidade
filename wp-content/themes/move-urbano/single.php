<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div id="primary" class="main conteudo wrapper">
	<main id="main" class="site-main" role="main">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="meta">
			<div class="compartilhar">
				<h3>Compartilhar</h3>
				<ul>
					<li><a class="addthis_button_email email" href="#"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
					<li><a class="addthis_button_facebook facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a class="addthis_button_twittertwitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<li><a class="addthis_button_pinterest_share pinterest" href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</div>

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the single post content template.
			get_template_part( 'template-parts/content', 'single' );

		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
