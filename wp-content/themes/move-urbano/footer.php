<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
	
</div><!-- .site -->

	<div class="footer">
		<div class="logotipo">
			<a href="index.html"><img src="<?php bloginfo( 'stylesheet_directory' );?>/img/logotipo-lateral_branco.png"></a>
			<img src="<?php bloginfo( 'stylesheet_directory' );?>/img/idec_logo_branco.png">
			<img src="<?php bloginfo( 'stylesheet_directory' );?>/img/logotipo-ics-branco.png">
			<img src="<?php bloginfo( 'stylesheet_directory' );?>/img/logo_led.png">
		</div>
	</div>

	<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
	<script>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='https://www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga('create','UA-XXXXX-X','auto');ga('send','pageview');
	</script>

<?php wp_footer(); ?>
</body>
</html>
