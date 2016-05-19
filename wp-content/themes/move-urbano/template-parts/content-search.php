<?php
/**
 * The template part for displaying results in search pages
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="search-thumbnail">
		<?php twentysixteen_post_thumbnail(); ?>
	</div>

	<div class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php twentysixteen_excerpt(); ?>
	</div><!-- .entry-header -->	


</article><!-- #post-## -->

<script>
	// Distribui cores aleatórias aos cards
	$('.search-area .site-main article').each(function(index, el) {
		$(this).addClass('cor-' + Math.floor((Math.random() * 4) + 1));
	});	
</script>
