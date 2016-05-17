<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				
				<h1 class="page-title"><?php _e( 'Não encontramos a página que você procura =(', 'twentysixteen' ); ?></h1>
				
				<div class="page-content">
					<p><?php _e( 'Ela pode ter sido removida ou mudado de endereço. <br/> Tente usar nossa busca para encontra-la.', 'twentysixteen' ); ?></p>

					<form action="<?php echo get_site_url(); ?>" class="search-form" method="get" role="search">
						<label>
							<input type="search" name="s" value="" placeholder="" class="search search-field form-control">
						</label>
					</form>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- .site-main -->

		<?php get_sidebar( 'content-bottom' ); ?>

	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
