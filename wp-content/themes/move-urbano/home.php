<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div class="wrapper">
		
	<?php

		/*
		*  Find dymanic content
		*/

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


		/*
		*  Mounts page Cardboard
		*/
		$it_count=0;
		$it_round_count=0;

		// CSS class of itens
		$curr_item_class="";
		$class0='span_4_of_10 row_span_2_of_2';		
		$class1='span_2_of_10';
		$class2='span_4_of_10';
		$temp_class=$class3;


		echo '<div class="main clearfix">';
			echo '<div class="cardboard">';

			if ( $merged_queried_post->have_posts() ) {
				
				while ( $merged_queried_post->have_posts() ) {
					$merged_queried_post->the_post();
			

					// Define css used class
					if($it_count==0) {
						$curr_item_class=$class0;
					}
					else if($it_count==1) {
						$curr_item_class=$class2;
					}
					else if($it_count <= 5) {
						$curr_item_class=$class1;	
					}
					else {

						if($it_round_count==3) {
							$curr_item_class=$class2;
							$it_round_count=0;
						}
						else {
							$curr_item_class=$class1;
							$it_round_count++;
						}						
					}
					

					// Get the post tags to use by category
					$posttags = '';					
					if (get_the_tags()) {
					  	foreach(get_the_tags() as $tag) {
					    	$posttags.= $tag->name .= ' '; 
					  }
					}


					// ########### THE CARD ITEM ###########
					$post_subtitle=get_post_meta(get_the_ID(), 'subtitulo', TRUE);
					if($post_subtitle != '')
						$post_subtitle=': ' . $post_subtitle;

					echo '<div class="card-item col ' . $curr_item_class . '" data-category="' . $posttags . '">';
						echo '<h2 style="background-image: url('. wp_get_attachment_url(get_post_thumbnail_id())  . ');" class="title">';
						echo '<a href="' . get_permalink() . '">' . get_the_title() . $post_subtitle . '</a>';
						try {
							if(get_the_category()[0]->cat_name == "Blog")
								echo '<span class="tag-blog">Blog</span>';
						}
						catch(Exception $e) {}		
						
						echo '</h2><p class="description">' . get_the_excerpt() . '</p>';
					echo '</div>'; // card item
					// ########### THE CARD ITEM ###########


					// Make sure it is the first item and disables this validated
					if($it_count_round) {
						$curr_item_class=$class2;
						$first_item=false;
					}

					$it_count++;

				}

			}

			echo '</div>'; // DIV cardboard	
		echo '</div>'; // DIV main

		/* Restore original Post Data */
		wp_reset_postdata();
	?>

</div>	

<script>
	$( document ).ready(function() {
		// Inicializa o plugin cardboard
		var cardboard = $(".cardboard").idecCardBoard();
		cardboard.setCardsRandomColours();
        cardboard.joinMenuCardCategories();

        $(".idec-logo-nav").click(function() {
        	cardboard.resetFilter();
        });

        var urlParam=getUrlParameter();
        cardboard.filterByCategory(urlParam);
        $("li[data-target='"+urlParam+"']").addClass("selected");
        console.log(urlParam);
	});	
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
