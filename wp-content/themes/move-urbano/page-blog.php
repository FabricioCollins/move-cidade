<?php
/**
 * Template Name: Blog
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
			// Query on Notices
		$args = array(
		    'category_name' => 'blog',
		    'posts_per_page' => 3,

		);
		$blog_result = new WP_Query( $args );

		if ( $blog_result->have_posts() ) {

			while ( $blog_result->have_posts() ) {
				$blog_result->the_post();	

				echo '<div class="blog-index-item">';  
					echo '<span class="post-date">' . get_the_date() . '</span>';
					echo '<h2 class="title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
					echo '<p class="description">' . get_the_excerpt() . '</p>';
				echo '</div>';			
			}
		}

		?>

	</main><!-- .site-main -->


</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
