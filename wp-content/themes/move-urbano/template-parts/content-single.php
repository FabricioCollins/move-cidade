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
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<section class="content-social border-bottom">		
		<a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
		<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
		<a href="#"><i class="icon fa fa-facebook" aria-hidden="true"></i></a>		
		<a href="#">@</a>
		<span>Compartilhar</span>
	</section>

	<div class="entry-content">
		<?php
			the_content();
		?>
	</div><!-- .entry-content -->

	<?php 
		global $posts; 
		$b = 0;
		$args = array( 'posts_per_page' => 10 );
		$loop = new WP_Query( $args );
	?>

	<div class="carousel-items-wrapper">			
		<ul class="bxslider slideshow responsive carousel-items">
			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>			
				<li>
					<a href="<?php get_permalink();?>"><?php twentysixteen_post_thumbnail(); ?></a>
				</li>
			<?php endwhile ?>
		</ul>
	</div><!-- The Carousel -->

</article><!-- #post-## -->


<script>		
	$('.bxslider').bxSlider({
		// Slider 
		prevText : '<a href="#" class="carousel-previous"></a>',
		nextText: '<a href="#" class="carousel-next"></a>',
		slideWidth : 240,
		minSlides : 1,
		maxSlides : 5,
		slideMargin: 5,
		infiniteLoop : false,
		speed : 400,
		pager : false,
		hideControlOnEnd: false,		
		// Responsive
		responsive : true,
		touchEnabled : true,
		preventDefaultSwipeX: true, 
		preventDefaultSwipeY: false
		
	});
</script>
