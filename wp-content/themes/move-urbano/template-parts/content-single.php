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
	
	<div class="entry-content">
		<?php
			the_content();
		?>
	</div><!-- .entry-content -->

	<?php 
		global $posts; 
		$b = 0;

		$caegory_name='conteudo';
		if (strpos(get_permalink(), '/'.'blog') !== false) {
			$caegory_name='blog';
		}

		$args = array( 'posts_per_page' => 10, 'category_name' => $caegory_name );
		$loop = new WP_Query( $args );
	?>	



	<div class="carousel-items-wrapper">			
		<ul class="bxslider slideshow responsive carousel-items">
			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>			
				<li>
					<a href="<?php echo get_permalink();?>">
						<div class="content">
							<p><?php echo get_the_title();?></p>
							<!--< ? php twentysixteen_post_thumbnail(); ?> -->
						</div>				
					</a>
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
		//maxSlides : 5,
		slideMargin: 5,
		infiniteLoop : true,
		speed : 400,
		pager : false,
		hideControlOnEnd: false,		
		// Responsive
		responsive : true,
		touchEnabled : true,
		preventDefaultSwipeX: true, 
		preventDefaultSwipeY: false
		
	});

	// Distribui cores aleatórias aos cards
	$('.carousel-items-wrapper .bxslider li').each(function(index, el) {
		$(this).addClass('cor-' + Math.floor((Math.random() * 3) + 1));
	});	
</script>
