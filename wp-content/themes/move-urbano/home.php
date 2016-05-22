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
		    'posts_per_page', 3
		);
		$blog_result = new WP_Query( $args );

		// Query on fixed content
		$args = array(
		    'category_name' => 'conteudo',
		    'posts_per_page', 3
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
		$first_item=true;
		$it_count=0;
		$is_write_section=false;

		// CSS class of itens
		$curr_item_class="span_4_of_10 row_span_2_of_2";
		$class1='span_4_of_10 row_span_2_of_2';
		$class2='span_2_of_10';
		$class3='span_3_of_12';
		$temp_class=$class3;


		echo '<div class="main">';
			echo '<div class="cardboard">';

			if ( $merged_queried_post->have_posts() ) {

				echo '<div class="section">';

				while ( $merged_queried_post->have_posts() ) {
					$merged_queried_post->the_post();



					// This is provisional for tests
					if (in_array( $it_count, array(7, 11, 16, 20, 25, 29, 34, 38, 43) ))
						$is_write_section=true;



					// Define when write section tag
					if($is_write_section) {
						echo '</div>'; // DIV section
						echo '<div class="section">'; // DIV section
					}



					// Define current css item class
					// if create new section, change class
					if($is_write_section) {
						$tmp=$curr_item_class;
						$curr_item_class=$temp_class;
						$temp_class=$tmp;
					}						
					

					// Get the post tags to use by category
					$posttags = '';					
					if (get_the_tags()) {
					  	foreach(get_the_tags() as $tag) {
					    	$posttags.= $tag->name .= ' '; 
					  }
					}


					// ########### THE CARD ITEM ###########
					echo '<div class="col ' . $curr_item_class . '" data-category="' . $posttags . '">';
						echo '<h2 class="title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
						echo '<p class="descricao">' . get_the_excerpt() . '</p>';
					echo '</div>'; // card item
					// ########### THE CARD ITEM ###########


					// Make sure it is the first item and disables this validated
					if($first_item) {
						$curr_item_class=$class2;
						$first_item=false;
					}


					// Desable this control variable
					// Its have actvate after the section is complete again
					$is_write_section=false;

					$it_count++;

				}
				echo '</div>'; // Close last DIV section

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
	});	
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
