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
	
	<div class="entry-content <?php echo get_query_var('category_name'); ?>">
		<?php
			the_content();
		?>
	</div><!-- .entry-content -->

	<?php 
		global $posts; 
		$b = 0;

		// Query on Notices
		$args = array(
		    'category_name' => 'blog',
		    'posts_per_page' => 3,
		    'orderby' => 'date', 
		    'order' => 'DESC'		    
		);
		$blog_result = new WP_Query( $args );

		// Query on fixed content
		$args = array(
		    'category_name' => 'conteudo',
		    'posts_per_page' => -1
		);
		$page_result = new WP_Query( $args );

		// Suffle Page Result
		shuffle($page_result->posts);

		// Do merge on two arrays
		$merged_queried_post = new WP_Query();
        $merged_queried_post->posts = array_merge($blog_result->posts,$page_result->posts);
        $merged_queried_post->post_count = $blog_result->post_count + $page_result->post_count;
	?>	

	<div class="carousel-items-wrapper">			
		<ul class="bxslider slideshow responsive carousel-items">
			<?php while ( $merged_queried_post->have_posts() ) : $merged_queried_post->the_post(); ?>			
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
			<?php while ( $merged_queried_post->have_posts() ) : $merged_queried_post->the_post(); ?>			
				<li class="menu-item">
					<h2 class="title" style="background-image: url('<?php echo wp_get_attachment_url(get_post_thumbnail_id())?>')">
						<a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a>
					</h2>
				</li>
			<?php endwhile ?>
		</ul>
		<img class="dock-nav-left" src="<?php bloginfo( 'stylesheet_directory' );?>/img/nav_left-32.png">
		<img class="dock-nav-right" src="<?php bloginfo( 'stylesheet_directory' );?>/img/nav_right-32.png">
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
		infinitemerged_queried_post : true,
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