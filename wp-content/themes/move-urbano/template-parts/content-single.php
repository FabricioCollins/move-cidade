<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article class="corpo" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
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
					<h2 class="title" style="background-image: url('<?php echo wp_get_attachment_url(get_post_thumbnail_id())?>')">
						<a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a>
					</h2>
				</li>
			<?php endwhile ?>
		</ul>
	</div><!-- Carousel -->

	<div class="dock-menu-wrapper">
		<ul class="dock-menu">
			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>			
				<li class="menu-item">
					<h2 class="title" style="background-image: url('<?php echo wp_get_attachment_url(get_post_thumbnail_id())?>')">
						<a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a>
					</h2>
				</li>
			<?php endwhile ?>
		</ul>
	</div><!-- Dock -->

</article><!-- #post-## -->

<script>		
	$('.bxslider').bxSlider({
		// Slider 
		prevText : '<a href="#" class="carousel-previous"></a>',
		nextText: '<a href="#" class="carousel-next"></a>',
		slideWidth : 240,
		minSlides : 1,
		moveSlides: 1,
		maxSlides : 5,
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

	$('.dock-menu-wrapper').dock({
        'itemWidth': 240,
        'itemHeight': 110
    });

	// Distribui cores aleatórias aos cards
	$('.bxslider li, .dock-menu li').each(function(index, el) {
		$(this).addClass('cor-' + Math.floor((Math.random() * 3) + 1));
	});	
</script>