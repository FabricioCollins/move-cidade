<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<section class="no-results not-found">
	
	<div class="no-results page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'twentysixteen' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><b>Não foi encontrado nenhum resultado que contenha os termos: </b><span><?php the_search_query(); ?></span></p>
			<p>Teste outros termos ou use o menu acima para navegar pelo conteúdo.</p>
			
			<form action="<?php $_SERVER['HOST_NAME']?>/move-cidade/" class="search-form" method="get" role="search">
				<label>
					<input type="search" name="s" value="" placeholder="" class="search search-field form-control">
				</label>
			</form>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'twentysixteen' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
