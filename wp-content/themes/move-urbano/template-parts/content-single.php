<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header border-bottom">
		<?php the_title( '<h1 class="entry-title border-bottom">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<section class="content-social border-bottom">		
		<a href="#">@</a>
		<a href="#">@</a>
		<a href="#">@</a>
		<a href="#">@</a>
		<span>Compartilhar</span>
	</section>

	<div class="entry-content">
		<?php
			the_content();
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
