<?php
/**
 * Template Name: Blog
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="primary" class="main blog-index content-area">
	<main id="main" class="blog-index-menu site-main" role="main">
		<?php
		
			// Query on Blog
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			query_posts(array(
			    'category_name' => 'blog',
			    'paged'          => $paged,
			    'posts_per_page' => 3 // Define posts per pagination
			));
			//$blog_result = new query_posts( $args );

		if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php 
				echo '<div class="artigo">';
					echo '<h2 class="title"><a href="blog.html">' . get_the_title() . '</a></h2>';
					echo '<div class="meta">';
						echo '<p class="data"><span class="responsivo-hide">Publicado em ' . get_the_date('d/m/Y') . '</p>';
					echo '</div>';					
					echo '<p class="descricao">' . get_the_excerpt() . '</p>';
					echo '<a class="continuarlendo" href="'.get_permalink().'">Continuar lendo <span class="arrow">&xrarr;</span></a>';
				echo '</div>';
			?>

		<?php endwhile; ?>

			<div class="wp-paginate">
				<?php get_pagination(); ?>
			</div>

		<?php else : ?>

		        <?php echo '<h2>Nenhuma postagem foi cadastrada.</h2>' ?>
			
		<?php endif; ?>





		<?php
		/*if ( $blog_result->have_posts() ) {

			while ( $blog_result->have_posts() ) {
				$blog_result->the_post();	

				echo '<div class="blog-index-item border-bottom">';  
					echo '<span class="post-date">' . get_the_date() . '</span>';
					echo '<h2 class="title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
					echo '<p class="description">' . get_the_excerpt() . '</p>';
				echo '</div>';			
			}
		}*/

		?>

	</main><!-- .site-main -->


</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
